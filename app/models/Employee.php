<?php
namespace App\Models;

use App\Lib\Model;

class Employee extends Model
{
    public function findEmployee($id)
    {
        $query = "
          SELECT 
            e.*, 
            GROUP_CONCAT(DISTINCT et.experience) as experience, 
            GROUP_CONCAT(DISTINCT et.education) as education, 
            GROUP_CONCAT(DISTINCT et.introduction) as introduction, 
            GROUP_CONCAT(DISTINCT ep.phone) as phone
          FROM 
            employees as e
          INNER JOIN employees_translations as et ON et.employee_id = e.id
          LEFT JOIN employees_phones as ep ON ep.employee_id = e.id
          WHERE e.id = ?
          GROUP BY e.id";

        $stmt = $this->_db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);

        return $row;
    }
}
