<?php
namespace App\Controllers;

use App\Lib\Controller;
use App\Models\Employee;

class EmployeeController extends Controller
{
    private $employee;

    public function __construct()
    {
        parent::__construct();
        $this->employee = new Employee();
    }

    public function getEmployee($id)
    {
        $employee = $this->employee->findEmployee($id);

        $response = [
            'employee' => $employee,
            'code' => 200
        ];

        return $this->_response->json($response);
    }
}
