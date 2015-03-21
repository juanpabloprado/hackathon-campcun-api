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
                $isvalid = $this->m->login($email,$pass);
                if($isvalid){
                    Session::setKey("loggedIn",1);
                    Session::setKey("user",$email);
                    $this->redirect();
                } else {
                    $this->view->flash("Sus credenciales no son validas","danger");
                }
            }
        } else {
            $this->redirect();
        }
        
    }
    
    public function logout(){
        Session::destroyKey();
        $this->redirect("login/index");
    }

}
