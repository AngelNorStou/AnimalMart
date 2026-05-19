<?php

class EmpView
{
    private EmployeesModel $employeeModel;

    public function __construct(EmployeesModel $employeeModel)
    {
        $this->employeeModel = $employeeModel;
    }

    /**
     * Safely display a single employee field
     */
    public function displayItem(string $username, string $field): string
    {
        $employee = $this->employeeModel->getEmployeeByUsername($username);

        if (!$employee || !isset($employee[$field])) {
            return '';
        }

        return htmlspecialchars((string)$employee[$field], ENT_QUOTES, 'UTF-8');
    }

    /**
     * Display Admin / Non-admin radio options safely
     */
    public function displayAdminPower(string $username): string
    {
        $employee = $this->employeeModel->getEmployeeByUsername($username);

        if (!$employee) {
            return '';
        }

        $isAdmin = (int)$employee['is_admin'];

        return '
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="adminOption" value="0" ' . ($isAdmin === 0 ? 'checked' : '') . '> No
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="adminOption" value="1" ' . ($isAdmin === 1 ? 'checked' : '') . '> Yes
            </label>
        </div>';
    }

    /**
     * Display employee table rows
     */
    public function getAllEmployees(string $adminUsername): string
    {
        $employees = $this->employeeModel->getAllEmployees();
        $html = '';

        foreach ($employees as $emp) {
            $username   = htmlspecialchars($emp['username'], ENT_QUOTES, 'UTF-8');
            $firstName  = htmlspecialchars($emp['first_name'], ENT_QUOTES, 'UTF-8');
            $lastName   = htmlspecialchars($emp['last_name'], ENT_QUOTES, 'UTF-8');
            $startDate  = htmlspecialchars($emp['start_date'], ENT_QUOTES, 'UTF-8');
            $endDate    = htmlspecialchars((string)$emp['end_date'], ENT_QUOTES, 'UTF-8');

            $html .= "
            <tr>
                <td>{$firstName}</td>
                <td>{$lastName}</td>
                <td>{$startDate}</td>
                <td>{$endDate}</td>
                <td>
                    <a href=\"editEmp.php?editUser={$username}\" class=\"btn btn-sm btn-primary\">Edit</a>

                    <form method=\"POST\" action=\"deleteEmp.php\" style=\"display:inline\">
                        <input type=\"hidden\" name=\"username\" value=\"{$username}\">
                        <button type=\"submit\" class=\"btn btn-sm btn-danger\"
                            onclick=\"return confirm('Are you sure you want to remove this employee?')\">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>";
        }

        return $html;
    }
}
