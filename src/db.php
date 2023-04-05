<?php

class DBHandler {
    private $db;

    function __construct($db_path) {
        $this->db = new SQLite3($db_path);
        $this->createTable();
    }

    function __destruct() {
        $this->db->close();
    }

    private function createTable() {
        $this->db->exec('CREATE TABLE IF NOT EXISTS reports (id INTEGER PRIMARY KEY, report_id TEXT, company_name TEXT, project_name TEXT, project_type TEXT, test_type TEXT, test_date DATE, next_checkDate DATE)');
    }

    public function insertRecord($report_id, $company_name, $project_name, $project_type, $test_type, $test_date, $next_checkDate) {
        $stmt = $this->db->prepare("INSERT INTO reports (report_id, company_name, project_name, project_type, test_type,test_date,next_checkDate) VALUES (:report_id, :company_name, :project_name, :project_type, :test_type, :test_date, :next_checkDate)");
        $stmt->bindValue(':report_id', $report_id, SQLITE3_TEXT);
        $stmt->bindValue(':company_name', $company_name, SQLITE3_TEXT);
        $stmt->bindValue(':project_name', $project_name, SQLITE3_TEXT);
        $stmt->bindValue(':project_type', $project_type, SQLITE3_TEXT);
        $stmt->bindValue(':test_type', $test_type, SQLITE3_TEXT);
        $stmt->bindValue(':test_date', $test_date, SQLITE3_TEXT);
        $stmt->bindValue(':next_checkDate', $next_checkDate, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkDuplicate($report_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM reports WHERE report_id=:report_id");
        $stmt->bindValue(':report_id', $report_id, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        if($row['count'] > 0){
            return true;
        }else{
            return false;
        }
    }
}

?>
