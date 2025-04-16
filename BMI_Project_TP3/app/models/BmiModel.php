<?php
class BmiModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function saveBmiRecord($user_id, $name, $weight, $height, $bmi, $status) {
        $stmt = $this->db->prepare("INSERT INTO bmi_records 
                                  (user_id, name, weight, height, bmi, status) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("خطأ في إعداد الاستعلام: " . $this->db->error);
        }
        
        $stmt->bind_param("isddds", $user_id, $name, $weight, $height, $bmi, $status);
        
        if (!$stmt->execute()) {
            throw new Exception("خطأ في تنفيذ الاستعلام: " . $stmt->error);
        }
        
        return true;
    }

    public function getBmiHistory($user_id) {
        $stmt = $this->db->prepare("SELECT bmi, DATE(timestamp) as date 
                                   FROM bmi_records 
                                   WHERE user_id = ? 
                                   ORDER BY timestamp ASC");
        if (!$stmt) {
            throw new Exception("خطأ في إعداد الاستعلام: " . $this->db->error);
        }
        
        $stmt->bind_param("i", $user_id);
        
        if (!$stmt->execute()) {
            throw new Exception("خطأ في تنفيذ الاستعلام: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>