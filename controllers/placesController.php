<?php class placessController extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->enforcedFunctions();
        $this->m = $this->loadModel("places");
        $this->permissions = array(
            "admin" => array("*"),
            "staff" => array("*"),
            "user" => array("get", "add", "edit")
        );
        $this->actionFields = array(
            "get" => array(),
            "add" => array("places" => $this->m->setterFields),
            "remove" => array("places_id"),
            "edit" => array("places" => $this->m->setterFields, "places_id")
        );
    }

    public function index() {}

}
