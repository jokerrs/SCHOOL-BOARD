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
        $AverageStudentGrade = $this->getAverageStudentGrade($StudentId);
        $return = 'Fail';
        if($AverageStudentGrade >= 7){
            $return = 'Pass';
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
        $StudentArr = array();
        $StudentArr['data'] = array();
        foreach ($StudentData->fetchAll() as $Data){
            $Student = array(
                'id' => $Data['id'],
                'StudentName' => $Data['studentName'],
                'StudentSchool' => 'CSM',
                'StudentGrades' => '',
                'StudentAverageGrade' => $this->getAverageStudentGrade($StudentId),
                'FinalResult' => $this->getStudentFinalResult($StudentId)
            );
            $StudentArr['data'][] = $Student;
        }
        $OutPutData = array(
            'success' => array(
                'data' => $StudentArr['data']
            )
        );
        if ( $OutPutType === 'JSON' ) {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json; charset=UTF-8');
            return json_encode($OutPutData, JSON_PRETTY_PRINT);

        }

        if ( $OutPutType === 'XML' ) {
            header('Content-Type: application/xml; charset=utf-8');
            $xml = new SimpleXMLElement('<root/>');
            array_walk_recursive($OutPutData, array ($xml, 'addChild'));
            return $xml->asXML();
        }

        if ( ($OutPutType !== 'XML' && $OutPutType !== 'JSON') || $OutPutType === null ) {
            $return = NULL;
        }
        return $return;
    }


}
