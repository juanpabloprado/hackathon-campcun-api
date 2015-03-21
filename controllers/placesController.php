<?php class placesController extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->enforcedFunctions();
        $this->m = $this->loadModel("place");
        $this->permissions = array(
            "admin" => array("*"),
            "staff" => array("*"),
            "user" => array("get", "add", "edit")
        );
        $this->actionFields = array(
            "get" => array(),
            "add" => array("place" => $this->m->setterFields),
            "remove" => array("place_id"),
            "edit" => array("place" => $this->m->setterFields, "place_id")
        );
    }

    public function index() {
        $this->view->places = $this->m->getEm();
        $this->view->render("places/index");
    }
    
    public function addNew(){
        if(isset($_POST) && !empty($_POST)){
            $clean = $this->clean($_POST);
            $userModel = $this->loadModel("user");
            $user = $userModel->get($clean["user_id"]);
            $params = array(
                "place" => array(
                    "name" => $clean["name"],
                    "address" => $clean["address"],
                    "company" => $user["company"],
                    "phone" => $clean["phone"],
                    "latitude" => $clean["latitude"],
                    "longitude" => $clean["longitude"],
                    "email" => $user["email"],
                    "url" => $clean["url"],
                    "img_url" => $clean["img_url"],
                    "pets" => (isset($clean["pets"]) && $clean["pets"] == "on") ? 1 :  0
                )
            );
            $this->m->add($params);
            $this->redirect("places/index");
        }
        $this->view->render("places/add");
    }
    
    public function viewEdit($id) {
        $userModel = $this->loadModel("user");
        $this->view->users = $userModel->getEm();
        $this->view->place = $this->m->get($id);
        if(isset($_POST) && !empty($_POST)){
            $clean = $this->cleanArray($_POST);
            $userModel = $this->loadModel("user");
            $user = $userModel->get($clean["user_id"]);
            $params = array(
                "place" => array(
                    "name" => $clean["name"],
                    "address" => $clean["address"],
                    "company" => $user["company"],
                    "phone" => $clean["phone"],
                    "latitude" => $clean["latitude"],
                    "longitude" => $clean["longitude"],
                    "email" => $user["email"],
                    "url" => $clean["url"],
                    "img_url" => $clean["img_url"],
                    "pets" => (isset($clean["pets"]) && $clean["pets"] == "on") ? 1 :  0
                ),
                "place_id" => $id
            );
            $this->m->edit($params);
            $this->redirect("places/index");
        }
        $this->view->render("places/view-edit");
    }
    
    public function removeOne($id){
        $params = array(
            "place_id" => $id
        );
        $this->m->remove($params);
        $this->redirect("places/index");
    }

}
