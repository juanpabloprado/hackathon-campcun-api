<?php class todoModel extends Model {

     public $mod = "todo";
    public $table = '`todo`';

    public function __construct() {
        parent::__construct();
        $this->getterFields = array("id","todo");
        $this->setterFields = array("todo");
        $this->requiredFields = array();
        $this->arrayFields = array();
        $this->idFields = array();
    } 


     public function getEm($where = false) {
         $todos = $this->getAll($where);

         return $todos;
    }

}