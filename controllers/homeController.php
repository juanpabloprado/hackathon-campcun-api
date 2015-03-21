<?php class homeController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->enforcedFunctions();
        $this->m = $this->loadModel("home");
    }

    public function index() {
        $this->view->render("home/index");
    }

}
