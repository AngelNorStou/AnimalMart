<?php
require_once '../model/MessageModel.php';  // Use require_once to ensure it's loaded only once
date_default_timezone_set("America/New_York");  // sets timezone for timestamp

class MessageController {

    private MessageModel $messageObj;
    private PDO $conn;

    public function __construct(MessageModel $messageObj, $dbConnection)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // safer session start
        }

        // Use the secure MessageModel
        $this->messageObj = $messageObj;
        $this->conn = $dbConnection;
        
    }

    /**
     * Get all messages
     */
    public function display(): array {
        return $this->messageObj->displayMessages();
    }

    /**
     * Insert a new message securely
     */
    public function insertMessage($postData, $userId = null) {
        try {
            // Trim input
            $name    = trim($postData['name'] ?? '');
            $email   = trim($postData['email'] ?? '');
            $phone   = trim($postData['phone'] ?? '');
            $subject = trim($postData['subject'] ?? '');
            $message = trim($postData['message'] ?? '');

            // Validate required fields
            if (empty($subject) || empty($message)) {
                return ['success' => false, 'message' => 'Subject and message are required'];
            }

            // Guests must provide name & email
            if ($userId === null && (empty($name) || empty($email))) {
                return ['success' => false, 'message' => 'Name and email are required for guests'];
            }

            $query = "
                INSERT INTO messages
                (user_id, name, email, phone_number, subject, message, created_at)
                VALUES (:user_id, :name, :email, :phone, :subject, :message, NOW())
            ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(':user_id', $userId, $userId ? PDO::PARAM_INT : PDO::PARAM_NULL);
            $stmt->bindValue(':name', $name ?: null);
            $stmt->bindValue(':email', $email ?: null);
            $stmt->bindValue(':phone', $phone ?: null);
            $stmt->bindValue(':subject', $subject);
            $stmt->bindValue(':message', $message);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Message sent successfully!'];
            }

            return ['success' => false, 'message' => 'Message could not be sent. Please try again.'];

        } catch (PDOException $e) {
            error_log("Insert Message Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred while sending your message.'];
        }
    }

    /**
     * Delete a message securely
     */
    public function delete(int $messageId): array {
        if (empty($_SESSION['user']['isAdmin']) || $_SESSION['user']['isAdmin'] != 1) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        // Validate message ID
        if ($messageId <= 0) {
            return ['success' => false, 'message' => 'Invalid message ID'];
        }

        $result = $this->messageObj->deleteMessage($messageId);

        if ($result['success']) {
            header("Location: admin_profile.php");
            exit();
        }

        return $result;
    }
}
?>
