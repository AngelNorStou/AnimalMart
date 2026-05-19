<?php
require_once '../model/EmployeesModel.php';
class EmployeeController
{

    private EmployeesModel $employeeModel;
    private PDO $conn;

    public function __construct(EmployeesModel $employeeModel, $conn)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->employeeModel = $employeeModel;
        $this->conn = $conn;

    }

    /**
     * DELETE EMPLOYEE – SECURE
     */
    public function verifyDelete(array $get, string $adminUsername): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return ['success' => false, 'message' => 'Invalid request method'];
        }

        if (empty($adminUsername)) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $username = trim($get['deleteUser'] ?? '');

        if ($username === '') {
            return ['success' => false, 'message' => 'Username required'];
        }

        $emp = $this->employeeModel->getEmployeeByUsername($username);
        if (!$emp) {
            return ['success' => false, 'message' => 'Employee not found'];
        }

        return $this->employeeModel->deleteEmployee($emp['user_id']);
    }

    /**
     * ADD EMPLOYEE – SECURE
     */
    public function verifyAddEmployee(array $post, string $adminUsername): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request method'];
        }

        if (empty($adminUsername)) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $username   = trim($post['emp_username'] ?? '');
        $start_date = trim($post['emp_date'] ?? '');
        $isAdmin    = (int)($post['adminOption'] ?? 0);

        if ($username === '') {
            return ['success' => false, 'message' => 'Username is required'];
        }

        $userId = $this->employeeModel->getUserIdByUsername($username);

        if (!$userId) {
            return ['success' => false, 'message' => 'User does not exist'];
        }

        return $this->employeeModel->createEmployee($userId, $start_date, $isAdmin);
    }

    /**
     * UPDATE EMPLOYEE – SECURE
     */
    public function verifyEditEmployee(array $post, string $adminUsername): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request method'];
        }

        if (empty($adminUsername)) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $username   = trim($post['emp_editusername'] ?? '');
        $start_date = trim($post['emp_date_start'] ?? '');
        $end_date   = trim($post['emp_date_end'] ?? '') ?: null;
        $isAdmin    = (int)($post['adminOption'] ?? 0);

        if (empty($username)) {
            return ['success' => false, 'message' => 'Username is required'];
        }

        $emp = $this->employeeModel->getEmployeeByUsername($username);
        if (!$emp) {
            return ['success' => false, 'message' => 'Employee not found'];
        }

        return $this->employeeModel->updateEmployee($emp['user_id'], $start_date, $end_date, $isAdmin);
    }
}
