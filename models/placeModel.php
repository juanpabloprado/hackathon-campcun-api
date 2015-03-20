<?php class placeModel extends Model {

     public $mod = "place";
    public $table = '`place`';

    public function __construct() {
        parent::__construct();
        $this->getterFields = array("id","name","address","x","y","company","user_id","phone","email","url","img_url","pets");
        $this->setterFields = array("name","address","x","y","company","user_id","phone","email","url","img_url","pets");
        $this->requiredFields = array();
        $this->arrayFields = array();
        $this->idFields = array();
    } 


     public function getEm($where = false) {
        $data = $this->getAll($where);
        return $places;
    }

}