<?php class userModel extends Model {

    public $mod = "user";
    public $table = '`user`';

    public function __construct() {
        parent::__construct();
        $this->getterFields = array();
        $this->setterFields = array();
        $this->requiredFields = array();
        $this->arrayFields = array();
        $this->idFields = array();
    } 


     public function getEm($where = false) {
         $users = $this->getAll($where);
         return $users;
    }

}