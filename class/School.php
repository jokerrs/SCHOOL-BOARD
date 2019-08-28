<?php


class School{
    /**
     * @var PDO $conn
     */
    protected $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * @param $StudentId
     * @return float|int
     */
    public function getAverageStudentGrade($StudentId){
        $StudentData = new Students($this->conn);
        $StudentGradesData = $StudentData->getStudentGrades($StudentId);
        $TotalSumOfGrades = 0;
        $TotalCountOfGrades = $StudentGradesData->rowCount();
        foreach ($StudentGradesData->fetchAll() as $Grade){
            $TotalSumOfGrades += $Grade[ 'grade' ];
        }
        return $TotalSumOfGrades / $TotalCountOfGrades;
    }

    /**
     * @param $StudentId
     * @return string
     */
    public function getStudentFinalResult($StudentId){
        $GetStudentData = new Students($this->conn);
        $StudentData = $GetStudentData->getStudent($StudentId);

        if($StudentData->rowCount() < 1){
            http_response_code(404);
            die();
        }

        foreach ($StudentData as $Data){
            $School = (int)$Data['studentSchool'];
        }

        $AverageStudentGrade = $this->getAverageStudentGrade($StudentId);

        $return = 'Fail';

        if($School === 1) {
            if ( $AverageStudentGrade >= 7 ) {
                $return = 'Pass';
            }
        }
        if($School === 2){
            $AllStudentGradesData = new Students($this->conn);
            $GradesData = $AllStudentGradesData->getStudentGrades($StudentId);
            $TotalGradesNumber = $GradesData->rowCount();
            if($TotalGradesNumber > 1 /*Arrays starts from 0*/) {
                $Grades = array();
                foreach ($GradesData as $Data) {
                    $Grades[] = $Data[ 'grade' ];
                }
                $LowestStudentGrade = min($Grades);
                $Total = array_sum($Grades) - $LowestStudentGrade;
                $AverageStudentGrade = $Total / ($TotalGradesNumber - 1);
            }
                $return = 'Fail (' . $AverageStudentGrade.')';

            if ( $AverageStudentGrade > 8 ) {
                $return = 'Pass (' . $AverageStudentGrade.')';
            }
        }
        return $return;
    }
}