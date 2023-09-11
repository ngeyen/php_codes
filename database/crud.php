<?php
class FamilyCodeCRUD {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function fetchByCode($code) {
        $stmt = $this->db->prepare("SELECT * FROM familycodes WHERE code = :code");
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateIsRegistered($code) {
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $this->db->prepare("UPDATE familycodes SET is_registered = true, date_registered = :date_registered WHERE code = :code");
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':date_registered', $currentDateTime, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function fetchAll() {
        $stmt = $this->db->prepare("SELECT * FROM familycodes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create( $code) {
        $currentDateTime = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO familycodes (code, is_registered, date_registered) VALUES (:code, :is_registered, :date_registered)");
    
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':is_registered', false, PDO::PARAM_BOOL);
        $stmt->bindParam(':date_registered', $currentDateTime, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
}
?>