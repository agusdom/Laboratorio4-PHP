<?php
    namespace Model;

    class Student
    {
        private $firstName;
        private $lastName;
        private $address;

        public function getFirstName()
        {
            return $this->firstName;
        }
        public function setFirstName($firstName)
        {
            $this->firstName = $firstName;
        }

        public function getLastName()
        {
            return $this->lastName;
        }
        public function setLastName($lastName)
        {
            $this->lastName = $lastName;
        }

        public function getAddress()
        {
            return $this->address;
        }
        public function setAddress($address)
        {
            $this->address = $address;
        }


    }
?>