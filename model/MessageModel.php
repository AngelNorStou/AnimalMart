<?php
/**
 * MessageModel - Secure version with PDO prepared statements
 * All SQL injection vulnerabilities fixed
 */

class MessageModel {

    private $conn;
    private $table = "messages";
    
    /**
     * Constructor - Accept PDO connection
     * @param PDO $db - Database connection from Database class
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Display all messages - SECURE
     * Returns all messages with optional user info
     */
    public function displayMessages() {
        try {
            $query = "
                SELECT m.*, u.username
                FROM {$this->table} m
                LEFT JOIN users u ON m.user_id = u.user_id
                ORDER BY m.created_at DESC
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Display Messages Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Insert new message - SECURE
     * Supports both registered users (userId) and guests
     */
    public function insertMessage($postData, $userId = null) {
        try {
            $name    = trim($postData['name'] ?? '');
            $email   = trim($postData['email'] ?? '');
            $phone   = trim($postData['phone'] ?? '');
            $subject = trim($postData['subject'] ?? '');
            $message = trim($postData['message'] ?? '');

            // Validate required fields
            if (empty($subject) || empty($message)) {
                return ['success' => false, 'message' => 'Subject and message are required'];
            }

            // Guest users must provide contact info
            if ($userId === null && (empty($name) || empty($email))) {
                return ['success' => false, 'message' => 'Name and email are required for guests'];
            }

            $query = "
                INSERT INTO {$this->table} 
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
                return ['success' => true, 'message' => 'Message sent successfully'];
            }

            return ['success' => false, 'message' => 'Message not sent'];

        } catch (PDOException $e) {
            error_log("Insert Message Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error sending message'];
        }
    }

    /**
     * Delete message by ID - SECURE
     */
    public function deleteMessage($id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                return ['success' => false, 'message' => 'Invalid message ID'];
            }

            $query = "DELETE FROM {$this->table} WHERE message_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute() && $stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Message deleted'];
            }

            return ['success' => false, 'message' => 'Message not found'];

        } catch (PDOException $e) {
            error_log("Delete Message Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Delete failed'];
        }
    }

    /**
     * Get single message by ID - SECURE
     */
    public function getMessageById($id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                return null;
            }

            $query = "
                SELECT m.*, u.username
                FROM {$this->table} m
                LEFT JOIN users u ON m.user_id = u.user_id
                WHERE m.message_id = :id
                LIMIT 1
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Get Message By ID Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Optional: Search messages by keyword in subject or message - SECURE
     */
    public function searchMessages($keyword) {
        try {
            if (empty($keyword)) return [];

            $search = '%' . $keyword . '%';
            $query = "
                SELECT m.*, u.username
                FROM {$this->table} m
                LEFT JOIN users u ON m.user_id = u.user_id
                WHERE m.subject LIKE :keyword OR m.message LIKE :keyword
                ORDER BY m.created_at DESC
                LIMIT 50
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':keyword', $search);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Search Messages Error: " . $e->getMessage());
            return [];
        }
    }
}
