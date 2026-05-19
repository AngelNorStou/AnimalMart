<?php
/**
 * ServiceModel - Secure version with PDO prepared statements
 * All SQL injection vulnerabilities fixed
 */

class ServiceModel {
    private $conn;
    private $table = "services";

    /**
     * Constructor - Accept PDO connection
     * @param PDO $db - Database connection from Database class
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Display All Services
     */
    public function displayService() {
        try {
            $query = "SELECT * FROM {$this->table} ORDER BY name ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Display Service Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Number of Services by Type
     */
    public function getNumOfServices($type) {
        try {
            if (empty($type)) return 0;
            $query = "SELECT COUNT(*) AS total FROM {$this->table} WHERE type = :type";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get Num of Services Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get Services with Pagination
     */
    public function getServices($limit = 10, $offset = 0) {
        try {
            $limit = max(intval($limit), 1);
            $offset = max(intval($offset), 0);
            $query = "SELECT * FROM {$this->table} ORDER BY name ASC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Services Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Distinct Service Types
     */
    public function getServiceType() {
        try {
            $query = "SELECT DISTINCT type FROM {$this->table} ORDER BY type ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Service Type Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Display Service by ID
     */
    public function displayServiceById($id) {
        try {
            $id = intval($id);
            if ($id <= 0) return null;
            $query = "SELECT * FROM {$this->table} WHERE service_id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Display Service By ID Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add New Service
     */
    public function addService($post) {
        try {
            $type = trim($post['type'] ?? '');
            $name = trim($post['name'] ?? '');
            $desc = trim($post['desc'] ?? '');
            $length = $post['length'] ?? null;
            $price = $post['price'] ?? null;

            if (empty($type) || empty($name)) {
                return ['success' => false, 'message' => 'Service type and name are required'];
            }

            if ($length !== null && !is_numeric($length)) {
                return ['success' => false, 'message' => 'Service length must be numeric'];
            }

            if ($price !== null && !is_numeric($price)) {
                return ['success' => false, 'message' => 'Price must be numeric'];
            }

            $query = "INSERT INTO {$this->table} (type, name, description, duration, price, created_at)
                      VALUES (:type, :name, :desc, :length, :price, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':type', $type);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':desc', $desc ?: null);
            $stmt->bindValue(':length', $length !== null ? intval($length) : null, PDO::PARAM_INT);
            $stmt->bindValue(':price', $price !== null ? floatval($price) : null);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Service added successfully', 'service_id' => $this->conn->lastInsertId()];
            }

            return ['success' => false, 'message' => 'Failed to add service'];
        } catch (PDOException $e) {
            error_log("Add Service Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to add service, please try again'];
        }
    }

    /**
     * Edit Service
     */
    public function editService($post) {
        try {
            $id = intval($post['service_id'] ?? 0);
            $name = trim($post['name'] ?? '');
            $desc = trim($post['desc'] ?? '');
            $length = $post['length'] ?? null;
            $price = $post['price'] ?? null;

            if ($id <= 0 || empty($name)) {
                return ['success' => false, 'message' => 'Service ID and name are required'];
            }

            if ($length !== null && !is_numeric($length)) {
                return ['success' => false, 'message' => 'Service length must be numeric'];
            }

            if ($price !== null && !is_numeric($price)) {
                return ['success' => false, 'message' => 'Price must be numeric'];
            }

            $query = "UPDATE {$this->table} 
                      SET name = :name, description = :desc, duration = :length, price = :price
                      WHERE service_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':desc', $desc ?: null);
            $stmt->bindValue(':length', $length !== null ? intval($length) : null, PDO::PARAM_INT);
            $stmt->bindValue(':price', $price !== null ? floatval($price) : null);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => $stmt->rowCount() > 0 ? 'Service updated successfully' : 'No changes made'];
            }

            return ['success' => false, 'message' => 'Failed to update service'];
        } catch (PDOException $e) {
            error_log("Edit Service Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update service, please try again'];
        }
    }

    /**
     * Delete Service
     */
    public function deleteService($id) {
        try {
            $id = intval($id);
            if ($id <= 0) return ['success' => false, 'message' => 'Invalid service ID'];

            // Check if service has appointments
            $checkStmt = $this->conn->prepare("SELECT COUNT(*) as count FROM appointments WHERE service_id = :id");
            $checkStmt->bindValue(':id', $id, PDO::PARAM_INT);
            $checkStmt->execute();
            if ($checkStmt->fetchColumn() > 0) {
                return ['success' => false, 'message' => 'Cannot delete service with existing appointments'];
            }

            $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE service_id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return ['success' => true, 'message' => $stmt->rowCount() > 0 ? 'Service deleted successfully' : 'Service not found'];
            }
            return ['success' => false, 'message' => 'Failed to delete service'];
        } catch (PDOException $e) {
            error_log("Delete Service Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete service, please try again'];
        }
    }

    /**
     * Search Services
     */
    public function searchServices($string) {
        try {
            if (empty($string)) return [];
            $term = '%' . $string . '%';
            $query = "SELECT * FROM {$this->table} WHERE name LIKE :term OR type LIKE :term OR description LIKE :term ORDER BY name ASC LIMIT 50";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':term', $term);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search Services Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Services by Type
     */
    public function getServicesByType($type, $limit = 50, $offset = 0) {
        try {
            if (empty($type)) return [];
            $limit = max(intval($limit), 1);
            $offset = max(intval($offset), 0);

            $query = "SELECT * FROM {$this->table} WHERE type = :type ORDER BY name ASC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':type', $type);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Services By Type Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Services by Price Range
     */
    public function getServicesByPriceRange($minPrice, $maxPrice) {
        try {
            $min = floatval($minPrice);
            $max = floatval($maxPrice);
            $query = "SELECT * FROM {$this->table} WHERE price BETWEEN :min AND :max ORDER BY price ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':min', $min);
            $stmt->bindValue(':max', $max);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Services By Price Range Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Total Service Count
     */
    public function getTotalServiceCount() {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM {$this->table}");
            $stmt->execute();
            return $stmt->fetchColumn() ?: 0;
        } catch (PDOException $e) {
            error_log("Get Total Service Count Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get Popular Services
     */
    public function getPopularServices($limit = 10) {
        try {
            $limit = max(intval($limit), 1);
            $query = "SELECT s.*, COUNT(a.appointment_id) as booking_count
                      FROM {$this->table} s
                      LEFT JOIN appointments a ON s.service_id = a.service_id
                      GROUP BY s.service_id
                      ORDER BY booking_count DESC
                      LIMIT :limit";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Popular Services Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if Service Exists
     */
    public function serviceExists($id) {
        try {
            $id = intval($id);
            if ($id <= 0) return false;
            $stmt = $this->conn->prepare("SELECT service_id FROM {$this->table} WHERE service_id = :id LIMIT 1");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Service Exists Check Error: " . $e->getMessage());
            return false;
        }
    }
}