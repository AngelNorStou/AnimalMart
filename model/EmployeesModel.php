<?php
/**
 * EmployeesModel - Fully Secure PDO Version
 * Handles employees CRUD, admin checks, stats, and searches
 */

class EmployeesModel {
    private $conn;
    private $table = "employees";

    public function __construct($db) {
        $this->conn = $db;
    }


    /**
     * Get All Employees
     */
    public function getAllEmployees() {
        try {
            $query = "SELECT e.employee_id, e.start_date, e.end_date, e.is_admin,
                             u.user_id, u.username, u.first_name, u.last_name, u.email, u.phone_number
                      FROM " . $this->table . " e
                      INNER JOIN users u ON e.user_id = u.user_id
                      ORDER BY e.start_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get All Employees Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get Single Employee by username
     */
    public function getEmployeeByUsername($username) {
        try {
            if (empty($username)) return null;

            $query = "SELECT e.*, u.username, u.first_name, u.last_name, u.email, u.phone_number
                      FROM " . $this->table . " e
                      INNER JOIN users u ON e.user_id = u.user_id
                      WHERE u.username = :username
                      LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            error_log("Get Employee By Username Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get Single Employee by ID
     */
    public function getEmployeeById($employee_id) {
        try {
            if (!is_numeric($employee_id) || $employee_id <= 0) return null;

            $query = "SELECT e.*, u.username, u.first_name, u.last_name, u.email, u.phone_number
                      FROM " . $this->table . " e
                      INNER JOIN users u ON e.user_id = u.user_id
                      WHERE e.employee_id = :employee_id
                      LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            error_log("Get Employee By ID Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create Employee
     */
    public function createEmployee($user_id, $start_date, $isAdmin = 0) {
        try {
            $user_id = intval($user_id);
            $isAdmin = ($isAdmin == 1) ? 1 : 0;

            if ($user_id <= 0 || empty($start_date)) {
                return ['success'=>false, 'message'=>'Invalid input'];
            }

            $dateObj = DateTime::createFromFormat('Y-m-d', $start_date);
            if (!$dateObj) return ['success'=>false, 'message'=>'Invalid date format'];

            // Check if user exists
            $userCheck = "SELECT user_id FROM users WHERE user_id = :user_id LIMIT 1";
            $stmt = $this->conn->prepare($userCheck);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() === 0) return ['success'=>false,'message'=>'User not found'];

            // Check if already an employee
            $empCheck = "SELECT employee_id FROM " . $this->table . " WHERE user_id = :user_id LIMIT 1";
            $stmt = $this->conn->prepare($empCheck);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) return ['success'=>false,'message'=>'User is already an employee'];

            // Insert
            $query = "INSERT INTO " . $this->table . " (user_id, start_date, is_admin)
                      VALUES (:user_id, :start_date, :isAdmin)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':isAdmin', $isAdmin, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return ['success'=>true, 'message'=>'Employee created','employee_id'=>$this->conn->lastInsertId()];
            }
            return ['success'=>false, 'message'=>'Failed to create employee'];
        } catch (PDOException $e) {
            error_log("Create Employee Error: " . $e->getMessage());
            return ['success'=>false, 'message'=>'Error creating employee'];
        }
    }

    /**
     * Update Employee
     */
    public function updateEmployee($user_id, $start_date, $end_date = null, $isAdmin = 0) {
        try {
            $user_id = intval($user_id);
            $isAdmin = ($isAdmin == 1) ? 1 : 0;

            if ($user_id <= 0 || empty($start_date)) return ['success'=>false,'message'=>'Invalid input'];

            $startObj = DateTime::createFromFormat('Y-m-d', $start_date);
            if (!$startObj) return ['success'=>false,'message'=>'Invalid start date format'];

            if (!empty($end_date)) {
                $endObj = DateTime::createFromFormat('Y-m-d', $end_date);
                if (!$endObj) return ['success'=>false,'message'=>'Invalid end date format'];
                if ($endObj <= $startObj) return ['success'=>false,'message'=>'End date must be after start date'];
            } else {
                $end_date = null;
            }

            // Check employee exists
            $empCheck = "SELECT employee_id FROM " . $this->table . " WHERE user_id = :user_id LIMIT 1";
            $stmt = $this->conn->prepare($empCheck);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() === 0) return ['success'=>false,'message'=>'Employee not found'];

            // Update
            $query = "UPDATE " . $this->table . " 
                      SET start_date = :start_date, end_date = :end_date, is_admin = :isAdmin
                      WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':isAdmin', $isAdmin, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return ['success'=>true, 'message'=>'Employee updated successfully'];
            }
            return ['success'=>false,'message'=>'Failed to update employee'];
        } catch (PDOException $e) {
            error_log("Update Employee Error: " . $e->getMessage());
            return ['success'=>false,'message'=>'Error updating employee'];
        }
    }

    /**
     * Delete Employee
     */
    public function deleteEmployee($user_id) {
        try {
            $user_id = intval($user_id);
            if ($user_id <= 0) return ['success'=>false,'message'=>'Invalid user ID'];

            // Check employee exists
            $empCheck = "SELECT employee_id FROM " . $this->table . " WHERE user_id = :user_id LIMIT 1";
            $stmt = $this->conn->prepare($empCheck);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() === 0) return ['success'=>false,'message'=>'Employee not found'];

            $query = "DELETE FROM " . $this->table . " WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            if ($stmt->execute()) return ['success'=>true,'message'=>'Employee deleted successfully'];

            return ['success'=>false,'message'=>'Failed to delete employee'];
        } catch (PDOException $e) {
            error_log("Delete Employee Error: " . $e->getMessage());
            return ['success'=>false,'message'=>'Error deleting employee'];
        }
    }

    /**
     * Get User ID by Username (from users table)
     */
    public function getUserIdByUsername(string $username): ?int {
        try {
            if (empty($username)) return null;
            $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row ? (int)$row['user_id'] : null;
        } catch (PDOException $e) {
            error_log("Get User ID By Username Error: " . $e->getMessage());
            return null;
        }
    }


    /**
     * Get Active Employees
     */
    public function getActiveEmployees() {
        try {
            $query = "SELECT e.employee_id, e.start_date, e.is_admin, 
                             u.user_id, u.username, u.first_name, u.last_name, u.email
                      FROM " . $this->table . " e
                      INNER JOIN users u ON e.user_id = u.user_id
                      WHERE e.end_date IS NULL OR e.end_date > NOW()
                      ORDER BY e.start_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get Active Employees Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get All Admins
     */
    public function getAdmins() {
        try {
            $query = "SELECT e.employee_id, e.start_date, e.end_date, u.user_id, u.username, u.first_name, u.last_name
                      FROM " . $this->table . " e
                      INNER JOIN users u ON e.user_id = u.user_id
                      WHERE e.is_admin = 1 AND (e.end_date IS NULL OR e.end_date > NOW())
                      ORDER BY e.start_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get Admins Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if User is Admin
     */
    public function isUserAdmin($user_id) {
        try {
            $user_id = intval($user_id);
            if ($user_id <= 0) return false;

            $query = "SELECT is_admin FROM " . $this->table . "
                      WHERE user_id = :user_id AND (end_date IS NULL OR end_date > NOW()) LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch();
            return $data && $data['is_admin'] == 1;
        } catch (PDOException $e) {
            error_log("Is User Admin Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Employee Stats
     */
    public function getEmployeeStats() {
        try {
            $query = "SELECT COUNT(*) as total_employees,
                             SUM(CASE WHEN is_admin = 1 THEN 1 ELSE 0 END) as total_admins,
                             SUM(CASE WHEN end_date IS NULL OR end_date > NOW() THEN 1 ELSE 0 END) as active_employees,
                             SUM(CASE WHEN end_date IS NOT NULL AND end_date <= NOW() THEN 1 ELSE 0 END) as inactive_employees
                      FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get Employee Stats Error: " . $e->getMessage());
            return ['total_employees'=>0,'total_admins'=>0,'active_employees'=>0,'inactive_employees'=>0];
        }
    }

    /**
     * Search Employees
     */
    public function searchEmployees($term) {
        try {
            if (empty($term)) return [];
            $term = "%$term%";

            $query = "SELECT e.employee_id, e.start_date, e.end_date, e.is_admin,
                             u.user_id, u.username, u.first_name, u.last_name, u.email
                      FROM " . $this->table . " e
                      INNER JOIN users u ON e.user_id = u.user_id
                      WHERE u.username LIKE :term OR u.first_name LIKE :term OR u.last_name LIKE :term OR u.email LIKE :term
                      ORDER BY e.start_date DESC
                      LIMIT 50";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':term', $term);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Search Employees Error: " . $e->getMessage());
            return [];
        }
    }
}
