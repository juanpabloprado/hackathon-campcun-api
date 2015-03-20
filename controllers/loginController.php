<?php class loginController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->m = $this->loadModel("staff");
    }

    public function index() {
        
        if(!Session::getKey("loggedIn")){
            $this->view->render("login/index");
            if(isset($_REQUEST["email"]) && isset($_REQUEST["password"])){
                $email = $_REQUEST["email"];
                $pass = $_REQUEST["password"];
                echo "<pre>";
                var_dump($email,$pass);
                die();
            }
        } else {
            $this->controller->redirect();
        }
        
    }

}
