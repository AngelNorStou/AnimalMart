<?php


class ViewEmp
{
    public $empObj ;

    public function __construct(Employees $emp_obj)
    {
        //Set connection

        $this->empObj = $emp_obj;
        
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
            		 "<a href=\"edit_emp.php?editId=".$emp['username'] ."\">Edit?</a>".

            		"<a href=\"admin_profile.php?login=".$admin."&deleteId=". $emp['username'] ."\" style=\"color:red;margin-left:2%;\" onclick=\"confirm('Are you sure want to remove this employee ?')\">DELETE</a>".

            		"</td>".

            		"</tr>";

        }

        return $html;
   
    }    

  




}




?>

