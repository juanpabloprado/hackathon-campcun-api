<?php class usersController extends Controller {

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
                    "password" => $clean["password"],
                    "state" => $clean["state"],
                    "city" => $clean["city"],
                    "company" => $clean["company"],
                    "confirmed" => (int)$clean["confirmed"]
                )
            );
            $this->m->add($params);
            $this->redirect("users/index");
        }
        $this->view->render("users/add");
    }
    
    public function viewEdit($id) {
        $this->view->user = $this->m->get($id);
        echo "<pre>";
        var_dump($this->view->user);
        die();
        if(isset($_POST) && !empty($_POST)){
            $clean = $this->clean($_POST);
            $params = array(
                "user" => array(
                    "name" => $clean["name"],
                    "password" => $clean["password"],
                    "state" => $clean["state"],
                    "city" => $clean["city"],
                    "company" => $clean["company"],
                    "confirmed" => (int)$clean["confirmed"]
                ),
                "user_id" => $clean["id"]
            );
            $this->m->edit($params);
            $this->redirect("users/index");
        }
        $this->view->render("users/view-edit");
    }
    
    public function removeOne($id){
        
    }

}
