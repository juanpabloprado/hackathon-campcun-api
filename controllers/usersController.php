<?php  class usersController extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->enforcedFunctions();
        $this->m = $this->loadModel("user");
        $this->permissions = array(
            "admin" => array("*"),
            "staff" => array("*"),
            "user" => array("get", "add", "edit")
        );
        $this->actionFields = array(
            "get" => array(),
            "add" => array("user" => $this->m->setterFields),
            "remove" => array("user_id"),
            "edit" => array("user" => $this->m->setterFields, "user_id")
        );
    }

    public function index() {
        $this->view->users = $this->m->getEm();
        $this->view->render("users/index");
    }
    
    public function addNew(){
        if(isset($_POST) && !empty($_POST)){
            $clean = $this->clean($_POST);
            $params = array(
                "user" => array(
                    "name" => $clean["name"],
                    "email" => $clean["email"],
                    "password" => Tool::getHash("sha256", $clean["password"], HASH_KEY),
                    "state" => $clean["state"],
                    "city" => $clean["city"],
                    "company" => $clean["company"],
                    "confirmed" => (isset($clean["confirmed"]) && $clean["confirmed"] == "on") ? 1 :  0
                )
            );
            $this->m->add($params);
            $this->redirect("users/index");
        }
        $this->view->render("users/add");
    }
    
    public function viewEdit($id) {
        $this->view->user = $this->m->get($id);
        if(isset($_POST) && !empty($_POST)){
            $clean = $this->cleanArray($_POST);
            $params = array(
                "user" => array(
                    "name" => $clean["name"],
                    "email" => $clean["email"],
                    "state" => $clean["state"],
                    "city" => $clean["city"],
                    "company" => $clean["company"],
                    "confirmed" => (isset($clean["confirmed"]) && $clean["confirmed"] == "on") ? 1 :  0
                ),
                "user_id" => $id
            );
            if($clean["password"] <> ""){
                $params["user"]["pasword"] = Tool::getHash("sha256", $clean["password"], HASH_KEY);
            }
            $this->m->edit($params);
            $this->redirect("users/index");
        }
        $this->view->render("users/view-edit");
    }
    
    public function removeOne($id){
        $params = array(
            "user_id" => $id
        );
        $this->m->remove($params);
        $this->redirect("users/index");
    }

}
