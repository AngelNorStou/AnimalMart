<?php
/**
 * PetsModel - Secure version with PDO prepared statements
 * All SQL injection vulnerabilities fixed
 */

class PetsModel {
    private $conn;
    private $table = "pets";

    /**
     * Constructor - Accept PDO connection
     * @param PDO $db - Database connection from Database class
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Display Pets by Username - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function displayPetsByUsername($user_name) {
        try {
            // Validate input
            if (empty($user_name)) {
                return [];
            }

            // Using JOIN instead of subquery for better performance
            $query = "SELECT p.* 
                      FROM " . $this->table . " p
                      INNER JOIN users u ON p.user_id = u.user_id
                      WHERE u.username = :username
                      ORDER BY p.pet_name ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $user_name);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll();
            }
            
            return [];
            
        } catch (PDOException $e) {
            error_log("Display Pets Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Display Pet by ID - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function displayPetById($id) {
        try {
            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                return null;
            }

            $query = "SELECT * FROM " . $this->table . " WHERE pet_id = :id LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch();
            }
            
            return null;
            
        } catch (PDOException $e) {
            error_log("Display Pet By ID Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update Pet - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function updatePet($postData) {
        try {
            // Sanitize and validate input
            $petname = trim($postData['edit_pet_name'] ?? '');
            $type = trim($postData['edit_pet_type'] ?? '');
            $breed = trim($postData['edit_pet_breed'] ?? '');
            $gender = trim($postData['edit_pet_gender'] ?? '');
            $size = trim($postData['edit_pet_size'] ?? '');
            $weight = trim($postData['edit_pet_weight'] ?? '');
            $age = trim($postData['edit_pet_age'] ?? '');
            $id = trim($postData['edit_pet_id'] ?? '');

            // Validate required fields
            if (empty($petname) || empty($id)) {
                return [
                    'success' => false, 
                    'message' => 'Pet name and ID are required'
                ];
            }

            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                return [
                    'success' => false, 
                    'message' => 'Invalid pet ID'
                ];
            }

            // Validate numeric fields
            if (!empty($weight) && !is_numeric($weight)) {
                return [
                    'success' => false, 
                    'message' => 'Weight must be a number'
                ];
            }

            if (!empty($age) && !is_numeric($age)) {
                return [
                    'success' => false, 
                    'message' => 'Age must be a number'
                ];
            }

            // Update pet - SECURE with PDO
            $query = "UPDATE " . $this->table . " 
                      SET pet_name = :petname, 
                          pet_type = :type, 
                          breed = :breed,
                          gender = :gender, 
                          size = :size,
                          weight = :weight,
                          age = :age
                      WHERE pet_id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':petname', $petname);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':breed', $breed);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':size', $size);
            $stmt->bindParam(':weight', $weight);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // Get username for redirect
                    $user_name = $this->getUsername($id);
                    
                    if ($user_name) {
                        header("Location: user_profile.php?login=" . urlencode($user_name));
                        exit();
                    }
                    
                    return [
                        'success' => true, 
                        'message' => 'Pet updated successfully'
                    ];
                } else {
                    return [
                        'success' => false, 
                        'message' => 'No changes made or pet not found'
                    ];
                }
            }
            
            return [
                'success' => false, 
                'message' => 'Update failed'
            ];
            
        } catch (PDOException $e) {
            error_log("Update Pet Error: " . $e->getMessage());
            return [
                'success' => false, 
                'message' => 'Update failed, please try again'
            ];
        }
    }

    /**
     * Insert New Pet - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function insertPet($postData) {
        try {
            // Sanitize and validate input
            $name = trim($postData['pet_name'] ?? '');
            $type = trim($postData['type'] ?? '');
            $breed = trim($postData['breed'] ?? '');
            $gender = trim($postData['gender'] ?? '');
            $size = trim($postData['size'] ?? '');
            $weight = trim($postData['weight'] ?? '');
            $age = trim($postData['age'] ?? '');
            $user_name = trim($postData['user'] ?? '');

            // Validate required fields
            if (empty($name) || empty($user_name)) {
                return [
                    'success' => false, 
                    'message' => 'Pet name and username are required'
                ];
            }

            // Convert age to integer
            $age = intval($age);

            // Validate numeric fields
            if (!empty($weight) && !is_numeric($weight)) {
                return [
                    'success' => false, 
                    'message' => 'Weight must be a number'
                ];
            }

            // Get user ID securely
            $user_id = $this->getUserID($user_name);
            
            if (!$user_id) {
                return [
                    'success' => false, 
                    'message' => 'User not found'
                ];
            }

            // Insert pet - SECURE with PDO
            $query = "INSERT INTO " . $this->table . "
                      (pet_name, pet_type, breed, gender, size, weight, age, user_id)
                      VALUES (:name, :type, :breed, :gender, :size, :weight, :age, :user_id)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':breed', $breed);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':size', $size);
            $stmt->bindParam(':weight', $weight);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                header("Location: user_profile.php?login=" . urlencode($user_name));
                exit();
            }
            
            return [
                'success' => false, 
                'message' => 'Pet creation failed'
            ];
            
        } catch (PDOException $e) {
            error_log("Insert Pet Error: " . $e->getMessage());
            return [
                'success' => false, 
                'message' => 'Pet creation failed, please try again'
            ];
        }
    }

    /**
     * Get Username by Pet ID - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function getUsername($id) {
        try {
            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                return null;
            }

            // Using JOIN for better performance and clarity
            $query = "SELECT u.username 
                      FROM users u
                      INNER JOIN " . $this->table . " p ON u.user_id = p.user_id
                      WHERE p.pet_id = :id
                      LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch();
                return $row['username'];
            }
            
            return null;
            
        } catch (PDOException $e) {
            error_log("Get Username Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get User ID by Username - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function getUserID($user_name) {
        try {
            // Validate input
            if (empty($user_name)) {
                return null;
            }

            $query = "SELECT user_id FROM users WHERE username = :username LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $user_name);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch();
                return $row['user_id'];
            }
            
            return null;
            
        } catch (PDOException $e) {
            error_log("Get User ID Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete Pet - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function deletePet($id) {
        try {
            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                return [
                    'success' => false, 
                    'message' => 'Invalid pet ID'
                ];
            }

            // Delete pet - SECURE
            $query = "DELETE FROM " . $this->table . " WHERE pet_id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return [
                        'success' => true, 
                        'message' => 'Pet deleted successfully'
                    ];
                } else {
                    return [
                        'success' => false, 
                        'message' => 'Pet not found'
                    ];
                }
            }
            
            return [
                'success' => false, 
                'message' => 'Delete failed'
            ];
            
        } catch (PDOException $e) {
            error_log("Delete Pet Error: " . $e->getMessage());
            return [
                'success' => false, 
                'message' => 'Delete failed, please try again'
            ];
        }
    }

    /**
     * Get All Pets - SECURE (Helper method for admin)
     */
    public function getAllPets($limit = 100, $offset = 0) {
        try {
            $query = "SELECT p.*, u.username, u.first_name, u.last_name 
                      FROM " . $this->table . " p
                      INNER JOIN users u ON p.user_id = u.user_id
                      ORDER BY p.pet_id DESC
                      LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("Get All Pets Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Count Pets by User - SECURE (Helper method)
     */
    public function countPetsByUser($user_name) {
        try {
            if (empty($user_name)) {
                return 0;
            }

            $query = "SELECT COUNT(*) as total 
                      FROM " . $this->table . " p
                      INNER JOIN users u ON p.user_id = u.user_id
                      WHERE u.username = :username";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $user_name);
            $stmt->execute();
            
            $result = $stmt->fetch();
            return $result['total'] ?? 0;
            
        } catch (PDOException $e) {
            error_log("Count Pets Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Search Pets - SECURE (Helper method for search functionality)
     */
    public function searchPets($searchTerm, $user_name = null) {
        try {
            $query = "SELECT p.*, u.username 
                      FROM " . $this->table . " p
                      INNER JOIN users u ON p.user_id = u.user_id
                      WHERE (p.pet_name LIKE :search 
                         OR p.pet_type LIKE :search 
                         OR p.breed LIKE :search)";
            
            // If username provided, filter by user
            if (!empty($user_name)) {
                $query .= " AND u.username = :username";
            }
            
            $query .= " ORDER BY p.pet_name ASC LIMIT 50";
            
            $stmt = $this->conn->prepare($query);
            
            $searchParam = '%' . $searchTerm . '%';
            $stmt->bindParam(':search', $searchParam);
            
            if (!empty($user_name)) {
                $stmt->bindParam(':username', $user_name);
            }
            
            $stmt->execute();
            
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("Search Pets Error: " . $e->getMessage());
            return [];
        }
    }
}