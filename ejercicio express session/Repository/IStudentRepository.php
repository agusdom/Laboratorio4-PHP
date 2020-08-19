<?php
namespace Repository;

use Model\Student as Student;

interface IStudentRepository
{
    public function AddStudent(Student $student);
}

?>