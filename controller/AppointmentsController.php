<?php

require_once '../model/AppointmentModel.php';

class AppointmentController
{
    private AppointmentModel $appointmentModel;
    private PDO $conn;

    public function __construct(AppointmentModel $appointmentModel, $conn)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
                
        $this->appointmentModel = $appointmentModel;
        $this->conn = $conn;

    }

    /**
     * GET appointments for a user (SECURE)
     */
    public function getAppointments(string $username): array
    {
        if (empty($username)) {
            return [];
        }

        return $this->appointmentModel->getAppointmentsByUsername($username);
    }

    /**
     * CREATE appointment (SECURE)
     */
    public function create(array $post): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        return $this->appointmentModel->createAppointment($post);
    }

    /**
     * GET appointment by ID (SECURE)
     */
    public function getById(int $appointmentId): ?array
    {
        if ($appointmentId <= 0) {
            return null;
        }

        return $this->appointmentModel->getAppointmentsById($appointmentId);
    }

    /**
     * UPDATE appointment (SECURE)
     */
    public function update(array $post): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        return $this->appointmentModel->updateAppointment($post);
    }

    /**
     * DELETE appointment (SECURE)
     * Uses POST — NOT GET (prevents CSRF & URL abuse)
     */
    public function delete(array $post): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $appointmentId = (int)($post['appointment_id'] ?? 0);

        if ($appointmentId <= 0) {
            return ['success' => false, 'message' => 'Invalid appointment ID'];
        }

        return $this->appointmentModel->deleteAppointment($appointmentId);
    }
}
