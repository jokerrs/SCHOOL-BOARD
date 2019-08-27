<?php


class Fetcher{
    /**
     * @var PDO $conn
     */
    protected $conn;

    /**
     * Builder constructor.
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
     * @param $StudentId
     * @return string|array|null
     */
    public function getStudentApiResult($StudentId){
        $Student = new Students($this->conn);
        $StudentData = $Student->getStudent($StudentId);
        foreach ($StudentData->fetchAll() as $Data){
            if((int)$Data['studentSchool'] === 1){
                $OutPutType = 'JSON';
            }
            if((int)$Data['studentSchool'] === 2){
                $OutPutType = 'XML';
            }
        }
        if(!isset($OutPutType)) {
            $OutPutType = null;
        }
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

        $StudentArr = array();
        $StudentArr['data'] = array();
        foreach ($StudentData->fetchAll() as $Data){
            $Student = array(
                'id' => $Data['id'],
                'StudentName' => $Data['studentName'],
                'StudentSchool' => 'CSM',
                'StudentGrades' => $ListGrades,
                'StudentAverageGrade' => $this->getAverageStudentGrade($StudentId),
                'FinalResult' => $this->getStudentFinalResult($StudentId)
            );
            $StudentArr['data'][] = $Student;
        }
        $OutPutData =  $StudentArr['data'];
        if ( $OutPutType === 'JSON' ) {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json; charset=UTF-8');
            $return = json_encode($OutPutData, JSON_PRETTY_PRINT);

        }

        if ( $OutPutType === 'XML' ) {
            header('Content-Type: application/xml; charset=utf-8');
            function array_xml($array, $root='student'){
                $xml = '';
                $xml .= "<?xml version=\"1.0\"?>\n";
                if($root!=null){
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
            $return = array_xml($OutPutData, 'student');
        }
        if ( ($OutPutType !== 'XML' && $OutPutType !== 'JSON') || $OutPutType === null ) {
            $return = NULL;
        }
        return $return;
    }
}
