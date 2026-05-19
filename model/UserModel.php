<?php
/**
 * UserModel - Secure version with PDO prepared statements
 * All SQL injection vulnerabilities fixed
 */

class UserModel {
    private $conn;
    private $table = "users";
    private $target_dir = "uploads/profile_pictures/";
    
    /**
     * Constructor - Accept PDO connection
     * @param PDO $db - Database connection from Database class
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * User Registration - SECURE
     */
    public function register(array $data): array
    {
        // Check if email or username already exists
        $check = $this->conn->prepare(
            "SELECT user_id FROM users WHERE email = :email OR username = :username LIMIT 1"
        );
        $check->execute([
            ':email' => $data['email'],
            ':username' => $data['username']
        ]);

        if ($check->rowCount() > 0) {
            return ['success' => false, 'message' => 'Email or username already exists'];
        }

        $sql = "
            INSERT INTO users (
                first_name, last_name, username,
                email, password, city,
                phone_number, profile_picture
            )
            VALUES (
                :first_name, :last_name, :username,
                :email, :password, :city,
                :phone, :picture
            )
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name'  => $data['last_name'],
            ':username'   => $data['username'],
            ':email'      => $data['email'],
            ':password'   => password_hash($data['password'], PASSWORD_BCRYPT),
            ':city'       => $data['city'],
            ':phone'      => $data['phone'] ?: null,
            ':picture'    => null
        ]);

        return ['success' => true, 'message' => 'Registration successful'];
    }
    /**
     * User Login - SECURE
     */
    public function login(string $email, string $password): array
    {
        $stmt = $this->conn->prepare(
            "SELECT user_id, username, email, password
            FROM users
            WHERE email = :email
            LIMIT 1"
        );

        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Invalid credentials: account not found.'];
        }

        $user = $stmt->fetch();

        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid credentials: wrong password.'];
        }

        return [
            'success' => true,
            'user' => $user
        ];
    }
        /**
     * Update User Profile - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function updateUser($postData) {
        try {
            // Sanitize and validate input
            $firstname = trim($postData['ufirstname'] ?? '');
            $lastname = trim($postData['ulastname'] ?? '');
            $username = trim($postData['uusername'] ?? '');
            $email = trim($postData['uemail'] ?? '');
            $password = $postData['upassword'] ?? '';
            $city = trim($postData['ucity'] ?? '');
            $phone = trim($postData['uphone'] ?? '');
            
            // Validate required fields
            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Username and password required'];
            }
            
            // Verify current password first
            $verifyQuery = "SELECT password FROM " . $this->table . " WHERE username = :username LIMIT 1";
            $verifyStmt = $this->conn->prepare($verifyQuery);
            $verifyStmt->bindParam(':username', $username);
            $verifyStmt->execute();
            
            if ($verifyStmt->rowCount() === 0) {
                return ['success' => false, 'message' => 'User not found'];
            }
            
            $user = $verifyStmt->fetch();
            
            if (!password_verify($password, $user['password'])) {
                return ['success' => false, 'message' => 'Incorrect password'];
            }
            
            // Update user information - SECURE with PDO
            $query = "UPDATE " . $this->table . " 
                      SET username = :username,
                          first_name = :firstname, 
                          last_name = :lastname,  
                          email = :email, 
                          city = :city, 
                          phone_number = :phone
                      WHERE username = :username";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':username', $username);
            
            if ($stmt->execute()) {
                // Check if user is admin and redirect
                $this->isAdmin($username);
                return ['success' => true, 'message' => 'Profile updated successfully'];
            }
            
            return ['success' => false, 'message' => 'Update failed'];
            
        } catch (PDOException $e) {
            error_log("Update User Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed, please try again. '.$e->getMessage()];
        }
    }

    /**
     * Change Password - SECURE
     * FIXED: SQL Injection vulnerability removed + Password hashing
     */
    public function changePassword($postData) {
        try {
            $current_password = $postData['current_password'] ?? '';
            $new_password = $postData['new_password'] ?? '';
            $current_user = trim($postData['current_user'] ?? '');
            
            // Validate input
            if (empty($current_password) || empty($new_password) || empty($current_user)) {
                return ['success' => false, 'message' => 'All fields required'];
            }
            
            // Password strength validation
            if (strlen($new_password) < 8) {
                return ['success' => false, 'message' => 'Password must be at least 8 characters'];
            }
            
            // Verify current password
            $verifyQuery = "SELECT password FROM " . $this->table . " WHERE username = :username LIMIT 1";
            $verifyStmt = $this->conn->prepare($verifyQuery);
            $verifyStmt->bindParam(':username', $current_user);
            $verifyStmt->execute();
            
            if ($verifyStmt->rowCount() === 0) {
                return ['success' => false, 'message' => 'User not found'];
            }
            
            $user = $verifyStmt->fetch();
            
            if (!password_verify($current_password, $user['password'])) {
                return ['success' => false, 'message' => 'Current password is incorrect'];
            }
            
            // Update password - SECURE with hashing
            $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
            
            $query = "UPDATE " . $this->table . "
                      SET password = :new_password
                      WHERE username = :username";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':new_password', $hashed_new_password);
            $stmt->bindParam(':username', $current_user);
            
            if ($stmt->execute()) {
                $this->isAdmin($current_user);
                return ['success' => true, 'message' => 'Password changed successfully'];
            }
            
            return ['success' => false, 'message' => 'Password update failed'];
            
        } catch (PDOException $e) {
            error_log("Change Password Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed, please try again'];
        }
    }

    /**
     * Update Profile Picture - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function updatePicture($fileName, $user_name) {
        try {
            // Sanitize filename
            $safe_filename = basename($fileName);
            $picture = $this->target_dir . $safe_filename;
            
            // Validate username
            if (empty($user_name)) {
                return ['success' => false, 'message' => 'Username required'];
            }
            
            // Update profile picture - SECURE
            $query = "UPDATE " . $this->table . "
                      SET profile_picture = :picture
                      WHERE username = :username";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':picture', $picture);
            $stmt->bindParam(':username', $user_name);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $this->isAdmin($user_name);
                    return ['success' => true, 'message' => 'Picture updated successfully'];
                } else {
                    return ['success' => false, 'message' => 'User not found'];
                }
            }
            
            return ['success' => false, 'message' => 'Picture update failed'];
            
        } catch (PDOException $e) {
            error_log("Update Picture Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed, please try again'];
        }
    }

    /**
     * Delete User - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function deleteUser($id) {
        try {
            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                return ['success' => false, 'message' => 'Invalid user ID'];
            }
            
            // Delete user - SECURE
            $query = "DELETE FROM " . $this->table . " WHERE user_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // User deleted successfully
                    header("Location: logout.php");
                    exit();
                } else {
                    return ['success' => false, 'message' => 'User not found'];
                }
            }
            
            return ['success' => false, 'message' => 'Delete failed'];
            
        } catch (PDOException $e) {
            error_log("Delete User Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Delete failed, please try again'];
        }
    }

    /**
     * Check if User is Admin and Redirect - SECURE
     * FIXED: SQL Injection vulnerability removed
     */
    public function isAdmin($user) {
        try {
            // Check admin status - SECURE
            $query = "SELECT e.is_admin
                      FROM employees e
                      INNER JOIN users u ON e.user_id = u.user_id
                      WHERE u.username = :username
                      LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $user);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch();
                
                if ($data['is_admin'] == 1) {
                    header("Location: admin_profile.php?login=" . urlencode($user));
                    exit();
                }
            }
            
            // Regular user
            header("Location: user_profile.php?login=" . urlencode($user));
            exit();
            
        } catch (PDOException $e) {
            error_log("isAdmin Error: " . $e->getMessage());
            header("Location: user_profile.php?login=" . urlencode($user));
            exit();
        }
    }

    /**
     * Get User by Username - SECURE (Helper method)
     */
    public function getUserByUsername(string $username, string $field): ?string {
        $allowedFields = ['username','first_name','last_name','email','city','phone_number','profile_pic'];
        if (!in_array($field, $allowedFields, true)) {
            return null;
        }

        $query = "SELECT $field FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row[$field] ?? null;
    }

    public function getUserByUsernameComplete(string $username): ?array {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Get User by ID - SECURE (Helper method)
     */
    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch()?: null;
    }

    /**
     * Get All Users - SECURE (For admin panel)
     */
    public function getAllUsers($limit = 100, $offset = 0) {
        $query = "SELECT user_id, username, first_name, last_name, email, city, phone_number,
                         profile_picture
                  FROM " . $this->table . "
                  ORDER BY user_id DESC
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}