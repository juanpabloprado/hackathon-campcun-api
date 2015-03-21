<?php class todosController extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->enforcedFunctions();
        $this->m = $this->loadModel("todo");
        $this->permissions = array(
            "admin" => array("*"),
            "staff" => array("*"),
            "user" => array("get", "add", "edit")
        );
        $this->actionFields = array(
            "get" => array(),
            "add" => array("todo" => $this->m->setterFields),
            "remove" => array("todo_id"),
            "edit" => array("todo" => $this->m->setterFields, "todo_id")
        );
    }

    public function index() {
        $this->view->todos = $this->m->getEm();
        $this->view->render("todos/index");
    }
    
    public function addNew(){
        if(isset($_POST) && !empty($_POST)){
            $clean = $this->clean($_POST);
            $params = array(
                "todo" => array(
                    "todo" => $clean["todo"]
                )
            );
            $this->m->add($params);
            $this->redirect("todos/index");
        }
        $this->view->render("todos/add");
    }
    
    public function viewEdit($id) {
        $this->view->place = $this->m->get($id);
        if(isset($_POST) && !empty($_POST)){
            $clean = $this->cleanArray($_POST);
            $userModel = $this->loadModel("user");
            $user = $userModel->get($clean["user_id"]);
            $params = array(
                "todo" => array(
                    "todo" => $clean["todo"]
                ),
                "todo_id" => $id
            );
            $this->m->edit($params);
            $this->redirect("todos/index");
        }
        $this->view->render("todos/view-edit");
    }
    
    public function removeOne($id){
        $params = array(
            "todo_id" => $id
        );
        $this->m->remove($params);
        $this->redirect("todos/index");
    }

}
