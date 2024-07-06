<?php
class db{
    protected $db_name = "mysql:host=127.0.0.1;dbname=sopwater_watercourse";
    protected $username ="root";
    protected $pass ="";
    protected $con = false;
    protected $mysqli = "";
    public function __construct(){
        if(!$this->con){
            $this->mysqli = new PDO($this->db_name,$this->username,$this->pass);
            if($this->mysqli){
            }else{
                echo "errr while establishing connection";
                $this->con=false;
            }
            
        }
    }
    
}

?>
