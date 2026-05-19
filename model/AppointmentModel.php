<?php
/**
 * AppointmentModel - Updated for new appointments table structure
 * Fully secure with PDO prepared statements
 */

class AppointmentModel  {
    private $conn;
    private $table = "appointments";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Get Appointments by Username
     */
    public function getAppointmentsByUsername($username) {
        try {
            if (empty($username)) return [];

            $query = "SELECT a.*,
                             p.pet_name, p.pet_type, p.breed,
                             s.name AS service_name, s.type AS service_type, s.price AS service_price,
                             u.username, u.first_name, u.last_name,
                             e.employee_id, e.is_admin
                      FROM " . $this->table . " a
                      INNER JOIN pets p ON a.pet_id = p.pet_id
                      INNER JOIN services s ON a.service_id = s.service_id
                      INNER JOIN users u ON a.user_id = u.user_id
                      INNER JOIN employees e ON a.employee_id = e.employee_id
                      WHERE u.username = :username
                      ORDER BY a.start_date DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PDOException $e) {
            error_log("Get Appointments By Username Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Appointment by ID
     */
    public function getAppointmentsById($id) {
        try {
            if (!is_numeric($id) || $id <= 0) return null;

            $query = "SELECT a.*,
                             p.pet_name, p.pet_type, p.breed, p.age,
                             s.name AS service_name, s.type AS service_type, s.price AS service_price, s.duration,
                             u.username, u.first_name, u.last_name, u.email, u.phone_number,
                             e.employee_id, e.is_admin
                      FROM " . $this->table . " a
                      INNER JOIN pets p ON a.pet_id = p.pet_id
                      INNER JOIN services s ON a.service_id = s.service_id
                      INNER JOIN users u ON a.user_id = u.user_id
                      INNER JOIN employees e ON a.employee_id = e.employee_id
                      WHERE a.appointment_id = :id
                      LIMIT 1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch();

        } catch (PDOException $e) {
            error_log("Get Appointment By ID Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create Appointment
     */
    public function createAppointment($post) {
        try {
            $start_date  = trim($post['start_date'] ?? '');
            $expiry      = trim($post['expiry'] ?? null);
            $pet_id      = trim($post['pet_id'] ?? '');
            $service_id  = trim($post['service_id'] ?? '');
            $employee_id = trim($post['employee_id'] ?? '');
            $user_id     = trim($post['user_id'] ?? '');

            if (empty($start_date) || empty($pet_id) || empty($service_id) || empty($employee_id) || empty($user_id)) {
                return ['success'=>false, 'message'=>'All fields are required'];
            }

            // Validate numeric IDs
            foreach (['pet_id'=>$pet_id, 'service_id'=>$service_id, 'employee_id'=>$employee_id, 'user_id'=>$user_id] as $k=>$v) {
                if (!is_numeric($v) || $v <= 0) return ['success'=>false,'message'=>"Invalid $k"];
            }

            // Validate date
            $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $start_date);
            if (!$dateObj) return ['success'=>false,'message'=>'Invalid start date'];

            // Optional: Check conflicts
            $conflictCheck = "SELECT appointment_id FROM " . $this->table . " 
                              WHERE pet_id = :pet_id AND start_date = :start_date LIMIT 1";
            $stmt = $this->conn->prepare($conflictCheck);
            $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->execute();
            if ($stmt->rowCount() > 0) return ['success'=>false,'message'=>'Appointment conflict for this pet'];

            // Insert
            $query = "INSERT INTO " . $this->table . " 
                      (employee_id, user_id, pet_id, service_id, start_date, app_status, expiry, created_at) 
                      VALUES (:employee_id, :user_id, :pet_id, :service_id, :start_date, 'Pending', :expiry, NOW())";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':expiry', $expiry);

            if ($stmt->execute()) {
                return ['success'=>true, 'message'=>'Appointment created', 'appointment_id'=>$this->conn->lastInsertId()];
            }

            return ['success'=>false,'message'=>'Failed to create appointment'];

        } catch (PDOException $e) {
            error_log("Create Appointment Error: " . $e->getMessage());
            return ['success'=>false,'message'=>'Error creating appointment'];
        }
    }

    /**
     * Update Appointment
     */
    public function updateAppointment($post) {
        try {
            $id          = trim($post['appointment_id'] ?? '');
            $start_date  = trim($post['start_date'] ?? '');
            $expiry      = trim($post['expiry'] ?? null);
            $pet_id      = trim($post['pet_id'] ?? '');
            $service_id  = trim($post['service_id'] ?? '');
            $employee_id = trim($post['employee_id'] ?? '');
            $user_id     = trim($post['user_id'] ?? '');

            if (empty($id) || empty($start_date) || empty($pet_id) || empty($service_id) || empty($employee_id) || empty($user_id)) {
                return ['success'=>false, 'message'=>'All fields are required'];
            }

            if (!is_numeric($id) || $id <= 0) return ['success'=>false,'message'=>'Invalid appointment ID'];
            foreach (['pet_id'=>$pet_id, 'service_id'=>$service_id, 'employee_id'=>$employee_id, 'user_id'=>$user_id] as $k=>$v) {
                if (!is_numeric($v) || $v <= 0) return ['success'=>false,'message'=>"Invalid $k"];
            }

            $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $start_date);
            if (!$dateObj) return ['success'=>false,'message'=>'Invalid start date'];

            // Check if appointment exists
            $existsCheck = "SELECT appointment_id FROM " . $this->table . " WHERE appointment_id = :id LIMIT 1";
            $stmt = $this->conn->prepare($existsCheck);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() === 0) return ['success'=>false,'message'=>'Appointment not found'];

            // Check for conflict (excluding current appointment)
            $conflictCheck = "SELECT appointment_id FROM " . $this->table . " 
                              WHERE pet_id = :pet_id AND start_date = :start_date AND appointment_id != :id LIMIT 1";
            $stmt = $this->conn->prepare($conflictCheck);
            $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) return ['success'=>false,'message'=>'Appointment conflict for this pet'];

            // Update
            $query = "UPDATE " . $this->table . " 
                      SET employee_id = :employee_id,
                          user_id = :user_id,
                          pet_id = :pet_id,
                          service_id = :service_id,
                          start_date = :start_date,
                          app_status = :app_status,
                          expiry = :expiry
                      WHERE appointment_id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':app_status', $post['app_status']);
            $stmt->bindParam(':expiry', $expiry);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['success'=>true,'message'=>'Appointment updated successfully'];
            }

            return ['success'=>false,'message'=>'Failed to update appointment'];

        } catch (PDOException $e) {
            error_log("Update Appointment Error: " . $e->getMessage());
            return ['success'=>false,'message'=>'Error updating appointment'];
        }
    }

    /**
     * Delete Appointment
     */
    public function deleteAppointment($id) {
        try {
            if (!is_numeric($id) || $id <= 0) return ['success'=>false,'message'=>'Invalid appointment ID'];

            $existsCheck = "SELECT appointment_id FROM " . $this->table . " WHERE appointment_id = :id LIMIT 1";
            $stmt = $this->conn->prepare($existsCheck);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() === 0) return ['success'=>false,'message'=>'Appointment not found'];

            $query = "DELETE FROM " . $this->table . " WHERE appointment_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) return ['success'=>true,'message'=>'Appointment deleted successfully'];

            return ['success'=>false,'message'=>'Failed to delete appointment'];

        } catch (PDOException $e) {
            error_log("Delete Appointment Error: " . $e->getMessage());
            return ['success'=>false,'message'=>'Error deleting appointment'];
        }
    }

    /**
     * Get All Appointments (Admin)
     */
    public function getAllAppointments($limit = 100, $offset = 0) {
        try {
            $limit = intval($limit);
            $offset = intval($offset);

            $query = "SELECT a.*,
                             p.pet_name, p.pet_type,
                             s.name AS service_name, s.type AS service_type, s.price AS service_price,
                             u.username, u.first_name, u.last_name,
                             e.employee_id
                      FROM " . $this->table . " a
                      INNER JOIN pets p ON a.pet_id = p.pet_id
                      INNER JOIN services s ON a.service_id = s.service_id
                      INNER JOIN users u ON a.user_id = u.user_id
                      INNER JOIN employees e ON a.employee_id = e.employee_id
                      ORDER BY a.start_date DESC
                      LIMIT :limit OFFSET :offset";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PDOException $e) {
            error_log("Get All Appointments Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Upcoming Appointments
     */
    public function getUpcomingAppointments($username = null, $days = 7) {
        try {
            $futureDate = date('Y-m-d H:i:s', strtotime("+{$days} days"));

            $query = "SELECT a.*,
                             p.pet_name, p.pet_type,
                             s.name AS service_name, s.type AS service_type,
                             u.username, u.first_name, u.last_name
                      FROM " . $this->table . " a
                      INNER JOIN pets p ON a.pet_id = p.pet_id
                      INNER JOIN services s ON a.service_id = s.service_id
                      INNER JOIN users u ON a.user_id = u.user_id
                      WHERE a.start_date BETWEEN NOW() AND :future_date";

            if ($username) $query .= " AND u.username = :username";

            $query .= " ORDER BY a.start_date ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':future_date', $futureDate);
            if ($username) $stmt->bindParam(':username', $username);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PDOException $e) {
            error_log("Get Upcoming Appointments Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Appointment Stats
     */
    public function getAppointmentStats($username = null) {
        try {
            $query = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN start_date > NOW() THEN 1 ELSE 0 END) as upcoming,
                        SUM(CASE WHEN start_date < NOW() THEN 1 ELSE 0 END) as past
                      FROM " . $this->table . " a
                      INNER JOIN pets p ON a.pet_id = p.pet_id
                      INNER JOIN users u ON a.user_id = u.user_id";

            if ($username) $query .= " WHERE u.username = :username";

            $stmt = $this->conn->prepare($query);
            if ($username) $stmt->bindParam(':username', $username);
            $stmt->execute();

            return $stmt->fetch();

        } catch (PDOException $e) {
            error_log("Get Appointment Stats Error: " . $e->getMessage());
            return ['total'=>0,'upcoming'=>0,'past'=>0];
        }
    }

    /**
     * Check Appointment Availability
     */
    public function checkAvailability($start_date, $service_id) {
        try {
            if (empty($start_date) || !is_numeric($service_id)) return false;

            $query = "SELECT COUNT(*) as count
                      FROM " . $this->table . " 
                      WHERE start_date = :start_date AND service_id = :service_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch();
            return ($result['count'] < 5); // max 5 per slot

        } catch (PDOException $e) {
            error_log("Check Availability Error: " . $e->getMessage());
            return false;
        }
    }
}
