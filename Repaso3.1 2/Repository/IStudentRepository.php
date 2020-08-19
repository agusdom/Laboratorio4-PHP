<?php

namespace Repository;
use Model\Student as Student;

interface IStudentRepository{

    public function Add(Student $student);
    public function Getall();
}
?>