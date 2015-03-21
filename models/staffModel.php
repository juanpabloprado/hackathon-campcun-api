<?php class staffModel extends Model {

    public $mod = "staff";
    public $table = '`staff`';

    public function __construct() {
        parent::__construct();
    } 
    
    public function login($email, $pass){
        $password = Tool::getHash("sha256", $pass, HASH_KEY);
        $sql = "SELECT * FROM staff WHERE email = '{$email}' AND password = '{$password}'";
        $sth = $this->db->select($sql);
        $data = $sth->fetch(2);
        return $data;
    }

}