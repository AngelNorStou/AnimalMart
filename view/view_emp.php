<?php


class ViewEmp
{
    public $empObj ;

    public function __construct(Employees $emp_obj)
    {
        //Set connection

        $this->empObj = $emp_obj;
        
    }

    public function displayItem($user,$item)
    {
        $emp = $this->empObj->selectEmployee($user,$item);

        return $emp[$item];

    }

     public function displayAdminPower($user)
    {
        $emp = $this->empObj->selectEmployee($user,'isAdmin');

        $html = "";

        if ($emp['isAdmin'] == 0)
        {
            $html = "<input type=\"radio\" class=\"form-check-input\" name=\"adminOption\"  value=\"0\" checked > No".
                    " </label>
                        </div>
                        <div class=\"form-check\">
                        <label class=\"form-check-label\">".
                        "<input type=\"radio\" class=\"form-check-input\" name=\"adminOption\"  value=\"1\"> YES </label></div>";
        }
        else
        {
            $html = "<input type=\"radio\" class=\"form-check-input\" name=\"adminOption\"  value=\"0\" > No".
                    " </label>
                        </div>
                        <div class=\"form-check\">
                        <label class=\"form-check-label\">".
                        "<input type=\"radio\" class=\"form-check-input\" name=\"adminOption\"  value=\"1\" checked > YES </label></div>";
        }
     

        return $html;
    }         

    public function getAllEmp($admin)
    {
        $empList = $this->empObj->displayEmployees();

        $html = "";

        foreach ($empList  as $emp) 
        {
           $html .= "<tr>".

            		"<td>". $emp['first_name']. "</td>".
            		"<td>". $emp['last_name']. "</td>".
             		"<td>". $emp['start_date']. "</td>".
             		"<td>". $emp['end_date']. "</td>".


             		"<td>".
            		 "<a href=\"edit_emp.php?editUser=".$emp['username'] ."\">Edit</a>".

            		"<a href=\"admin_profile.php?login=".$admin."&deleteUser=". $emp['username'] ."\" style=\"color:red;margin-left:2%;\" onclick=\"confirm('Are you sure want to remove this employee ?')\">Delete</a>".

            		"</td>".

            		"</tr>";

        }

        return $html;
   
    }    

  




}




?>

