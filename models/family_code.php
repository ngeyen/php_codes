<?php
class FamilyCode {
    public $id;
    public $code;
    public $is_registered;
    public $date_registered;
    
    public function __construct($id, $code, $is_registered, $date_registered) {
        $this->id = $id;
        $this->code = $code;
        $this->is_registered = $is_registered;
        $this->date_registered = $date_registered;
    }
}
?>