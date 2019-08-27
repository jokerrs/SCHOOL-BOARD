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


    public function getStudentSchool($StudentId){
        $StudentData = $this->conn->prepare('SELECT studentSchool FROM students WHERE id = ?');
        $StudentData->execute([$StudentId]);
        foreach ($StudentData->fetchAll() as $School){
            $School = $School['studentSchool'];
        }
        $GetSchoolName = $this->conn->prepare('SELECT schoolBoard FROM school where id = ?');
        $GetSchoolName->execute([$School]);
        foreach ($GetSchoolName->fetchAll() as $School){
            $School = $School['schoolBoard'];
        }
        return $School;
    }


}