<?php
/**
 * if is app not started this will throw a error
 */
if ( !defined('RUN')) {
    http_response_code(403);
    die();
}



class Fetcher{
    /**
     * @var PDO $conn
     */
    protected $conn;

    /**
     * Fetcher constructor.
     * @param $conn
     */
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
            if($TotalGradesNumber < 1){
                $AverageStudentGrade = $this->getAverageStudentGrade($StudentId);
            }
            if ( $AverageStudentGrade > 8 ) {
                $return = 'Pass (' . $AverageStudentGrade.')';
            }
        }
        return $return;
    }

    /**
     * @param array $Data
     * @return false|string
     */
    public function getJsonData(Array $Data){
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($Data, JSON_PRETTY_PRINT);
    }

    public function getXmlData(Array $Data,$root = 'student'){
        header('Content-Type: application/xml; charset=utf-8');
        $xml = '';
        $xml .= "<?xml version=\"1.0\"?>\n";
        if($root!==null){
            $xml .= "<{$root}>\n";
        }
        foreach ($array as $key=>$value){
            if(is_array($value)){
                foreach ($value as $ChildKey=>$ChildValue){
                    $xml .= "<{$ChildKey}>". htmlspecialchars(trim($ChildValue))."</{$ChildKey}>\n";
                }
            }
        }
        if($root!==null){
            $xml .= "\n</{$root}>\n";
        }
        return $xml;
    }

    /**
     * @param $StudentId
     * @return string|array|null
     */
    public function getStudentResult($StudentId){
        $Student = new Students($this->conn);
        $StudentData = $Student->getStudent($StudentId);
        if($StudentData->rowCount() < 1){
            http_response_code(404);
            die();
        }

        $ListOfGradesData = new Students($this->conn);
        $ListOfGrades = $ListOfGradesData->getStudentGrades($StudentId);
        $ListGrades = '';
        foreach ($ListOfGrades->fetchAll() as $Grades){
            $ListGrades .= ','.$Grades['grade'];
        }
       $ListGrades =  ltrim($ListGrades, ',');

        $SchoolName = new Students($this->conn);

        $StudentArr = array();
        $StudentArr['data'] = array();
        foreach ($StudentData->fetchAll() as $Data){
            $Student = array(
                'id' => $Data['id'],
                'StudentName' => $Data['studentName'],
                'StudentSchool' => $SchoolName->getStudentSchool($StudentId),
                'StudentGrades' => $ListGrades,
                'StudentAverageGrade' => $this->getAverageStudentGrade($StudentId),
                'FinalResult' => $this->getStudentFinalResult($StudentId)
            );
            $StudentArr['data'][] = $Student;
        }

        $OutPutData =  $StudentArr['data'];

        foreach ($StudentData->fetchAll() as $Data){
            if($Data['studentSchool'] === 1){
                return $this->getJsonData($OutPutData);
            }
            if($Data['studentSchool'] === 2){
                return $this->getXmlData($OutPutData, 'student');
            }
        }
            return json_encode(array('Error' => 'Nothing found'), JSON_PRETTY_PRINT);
    }
}
