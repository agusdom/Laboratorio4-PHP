<?php
namespace Repository;

use Model\Student as Student;
use Repository\IStudentRepository as IStudentRepository;

class StudentRepository implements IStudentRepository{

    private $studentList=array();

    public function Add(Student $student)
    {
        array_push($this->studentList,$student);
    }

    public function Getall()
    {
        return $this->studentList;
    }
}
?>