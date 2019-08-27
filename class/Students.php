<?php


class Students {

    /**
     * @var PDO $conn
     */
    private  $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getStudent($StudentId){
        $StudentData = $this->conn->prepare('SELECT * FROM students where id = ?');
        $StudentData->execute([$StudentId]);
        return $StudentData;
    }

    public function getStudentGrades($StudentId){
        $StudentData = $this->conn->prepare('SELECT * FROM grades where studendID = ?');
        $StudentData->execute([$StudentId]);
        return $StudentData;
    }





}