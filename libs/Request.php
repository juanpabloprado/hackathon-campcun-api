<? class Request {

    private $controller;
    private $method;
    private $args;
    private $lang;
    
    /* Class Request
     * Se corre automáticamente cuando corre la aplicación, para dividir la URL en:
     * 1. Controlador
     * 2. Metodo 
     * 3. n Variables divididas todas con SLASH [/]
     */

    public function __construct() {
        if (isset($_GET["url"])) {
            $url0 = rtrim($_GET["url"], '/');
            $url00 = explode("/", $url0);
            $url = array_filter($url00);
            
            $controller = Tool::slugify(array_shift($url));
            $method = Tool::slugify(array_shift($url));
            $args = $url;
        } else {
            $controller = DEFAULT_CONTROLLER;
            $method = "index";
            $args = array();
        }

        $this->controller = (!$controller) ? DEFAULT_CONTROLLER : $controller;
        $this->method = (!$method) ? "index" : $method;
        $this->args = (!isset($args)) ? array() : $args;
        
        $lang = Session::getKey("lang");
        if(!$lang){
            $lang = DEFAULT_LANG;
        }
        $this->lang = $lang;
        
    }

    public function getController() {
        return $this->controller;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getArgs() {
        return $this->args;
    }
    
    public function getLang(){
        return $this->lang;
    }

}