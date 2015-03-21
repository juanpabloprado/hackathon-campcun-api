<?php class homeController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->enforcedFunctions();
        $this->m = $this->loadModel("home");
    }

    public function index() {
        $userModel = $this->loadModel("user");
        $placeModel = $this->loadModel("place");
        $todoModel = $this->loadModel("todo");
        $this->view->users = $userModel->getEm();
        $this->view->places = $placeModel->getEm();
        $this->view->todos = $todoModel->getEm();
        $this->view->render("home/index");
    }

}
