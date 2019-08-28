<?php

/**
 * if is app not started this will throw a error
 */
if ( !defined('RUN')) {
    http_response_code(403);
    die();
}



class Students {

    /**
     * @var PDO $conn
     */
    private  $conn;

    /**
     * Students constructor.
     * @param $conn
     */
    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * @param $StudentId
     * @return bool|PDOStatement
     */
    public function getStudent($StudentId){
        $StudentData = $this->conn->prepare('SELECT * FROM students where id = ?');
        $StudentData->execute([$StudentId]);

        if($StudentData->rowCount() < 1){
            http_response_code(404);
            die();
        }

        return $StudentData;
    }

    /**
     * @param $StudentId
     * @return bool|PDOStatement
     */
    public function getStudentGrades($StudentId){
        $StudentData = $this->conn->prepare('SELECT * FROM grades where studendID = ?');
        $StudentData->execute([$StudentId]);
        return $StudentData;
    }

    /**
     * @param $StudentId
     * @return string
     */
    public function getStudentListOfGrades($StudentId){
        $ListOfGrades = $this->getStudentGrades($StudentId);
        $ListGrades = '';
        foreach ($ListOfGrades->fetchAll() as $Grades){
            $ListGrades .= ','.$Grades['grade'];
        }
        return  ltrim($ListGrades, ',');
    }
    /**
     * @param $StudentId
     * @return mixed
     */
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