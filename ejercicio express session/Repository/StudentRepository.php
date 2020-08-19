<?php
namespace Repository;

use Model\Student as Student;
use Repository\IStudentRepository as IStudentRepository;

class StudentRepository implements IStudentRepository
{
    private $studentList= array();

    public function AddStudent(Student $student)
    {
        array_push($this->studentList, $student); //no estoy seguro si va el $this->
    }

    public function GetAll()
    {
        return $this->studentList; //no estoy seguro si va el $this->
        //no se si esto funciona
    }
}

?>