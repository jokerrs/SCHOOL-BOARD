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
     * @param array $Data
     * @return false|string
     */
    public function getJsonData(Array $Data){
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($Data, JSON_PRETTY_PRINT);
    }

    /**
     * @param array $Data
     * @param string $root
     * @return string
     */
    public function getXmlData(Array $Data, $root = 'student'){
        header('Content-Type: application/xml; charset=utf-8');
        $xml = '';
        $xml .= "<?xml version=\"1.0\"?>\n";
        if($root!==null){
            $xml .= "<{$root}>\n";
        }
        foreach ($Data as $key=>$value){
            $xml .= "<{$key}>". htmlspecialchars(trim($value))."</{$key}>\n";
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

        $return = null;

        $Student = new Students($this->conn);
        $School = new School($this->conn);
        $StudentData = $Student->getStudent($StudentId)->fetchAll();
        foreach ($StudentData as $Data){
            $StudentArr = array(
                'id' => $Data['id'],
                'StudentName' => $Data['studentName'],
                'StudentSchool' => $Student->getStudentSchool($StudentId),
                'StudentGrades' => $Student->getStudentListOfGrades($StudentId),
                'StudentAverageGrade' => $School->getAverageStudentGrade($StudentId),
                'FinalResult' => $School->getStudentFinalResult($StudentId)
            );

            if((int)$Data['studentSchool'] === 1){
                $return = $this->getJsonData($StudentArr);
            }
            if((int)$Data['studentSchool'] === 2) {
                $return =  $this->getXmlData($StudentArr);
            }
        }

        return $return;
    }
}
