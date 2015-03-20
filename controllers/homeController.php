<?php class homeController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->enforcedFunctions();
        $this->m = $this->loadModel("home");
    }

    public function index() {
        echo "Hello World";
        $this->view = array("home/index");
    }

}
