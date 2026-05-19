<?php
require_once  '../model/UserModel.php';
class UserController
{
    private UserModel $userModel;
    private PDO $conn;
    // Best practice: Create the model outside the controller and inject it into the controller.
    public function __construct(UserModel $userModel, PDO $conn)
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }        
        $this->userModel = $userModel;
        $this->conn = $conn;

    }


    public function verifyLogin(array $post): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }

        $email = trim($post['login_email'] ?? '');
        $password = $post['login_password'] ?? '';

        if ($email === '' || $password === '') {
            return ['success' => false, 'message' => 'Email and password required'];
        }

        $result = $this->userModel->login($email, $password);

        if ($result['success'] === true) {
            $isAdmin = $this->checkIsAdmin((int)$result['user']['user_id']);

            $_SESSION['user'] = [
                'id'       => $result['user']['user_id'],
                'username' => $result['user']['username'],
                'email'    => $result['user']['email'],
                'isAdmin'  => $isAdmin
            ];

            $dest = $isAdmin
                ? 'admin_profile.php?login=' . urlencode($result['user']['username'])
                : 'user_profile.php?login='  . urlencode($result['user']['username']);

            header("Location: $dest");
            exit;
        }

        return $result;
    }



    public function verifyRegister(array $post, array $files)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }

        $data = [
            'first_name' => trim($post['first_name'] ?? ''),
            'last_name'  => trim($post['last_name'] ?? ''),
            'username'   => trim($post['username'] ?? ''),
            'email'      => trim($post['email'] ?? ''),
            'password'   => $post['password'] ?? '',
            'city'       => trim($post['city'] ?? ''),
            'phone'      => trim($post['phone_number'] ?? ''),
            'picture'    => $files['profile_picture'] ?? null
        ];

        // REQUIRED fields only
        foreach (['first_name','last_name','username','email','password','city'] as $field) {
            if (empty($data[$field])) {
                return ['success' => false, 'message' => 'Required fields missing'];
            }
        }

        // Password length
        if (strlen($data['password']) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters'];
        }

        return $this->userModel->register($data);
    }

    /**
     * UPDATE USER PROFILE - SECURE
     */
    public function verifyUpdate(array $post)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        return $this->userModel->updateUser($post);
    }

    /**
     * CHANGE PASSWORD - SECURE
     */
    public function verifyPasswordChange(array $post)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        return $this->userModel->changePassword($post);
    }

    /**
     * DELETE USER - SECURE
     */
    public function verifyDelete(array $post)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $id = (int)($post['user_id'] ?? 0);

        if ($id <= 0) {
            return ['success' => false, 'message' => 'Invalid user ID'];
        }

        return $this->userModel->deleteUser($id);
    }

    private function checkIsAdmin(int $userId): int
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT is_admin FROM employees
                 WHERE user_id = :user_id AND (end_date IS NULL OR end_date > NOW())
                 LIMIT 1"
            );
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch();
            return ($row && $row['is_admin'] == 1) ? 1 : 0;
        } catch (PDOException $e) {
            error_log("Check Admin Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * UPDATE PROFILE PICTURE - SECURE
     */
    public function verifyPictureChange(array $files, string $username)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== $username) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        if (!isset($files['upicture']) || $files['upicture']['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'No file uploaded'];
        }

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($files['upicture']['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type'];
        }

        $safeName = uniqid('profile_', true) . '.' . $extension;
        $targetPath = $this->userModel->target_dir . $safeName;

        if (!move_uploaded_file($files['upicture']['tmp_name'], $targetPath)) {
            return ['success' => false, 'message' => 'Upload failed'];
        }

        return $this->userModel->updatePicture($safeName, $username);
    }
}
