<? abstract class Controller {
    
    protected $view;

    public function __construct() {
        $this->view = new View(new Request);
    }    
    
    /* 
    * CONTROLLER FUNCTIONS
    *  En ésta clase van todas las funciones que se quieran tener en todos los controladores
    *  Se invocan en los controladores llamando: $this->myFunction();
    */ 
    
    //abstract public function index();
    
    /* ENFORCED FUNCTIONS
    *  Sirve para poner funciones o variables que quieras tener en todos los controladores
    */ 
    public function enforcedFunctions($algo = false, $que = false){
        $this->view->flash = Session::getKey("flash"); // Flash data
        if ($algo) $this->view->title = $algo." de ".$que; // Generic title constructor
        if(LOGIN_NEEDED){ 
            if(!Session::getKey("loggedIn")){ 
                $actualUrl = Tool::actualUrl();
                $isLogin = Tool::haveString("login",$actualUrl);
                if(!$isLogin){ Session::setKey("lastUrl", $actualUrl); } // If is not login, remember url
                $this->redirect("login");
            }
        } // Forced Login
    }
    
    public function checkPermission($role,$action){
        $permissions = $this->permissions[$role];
        if($permissions[0] === "*"){ // full
            return true;
        } else {
            return (in_array($action, $permissions));
        }
    }

    public function isValidRequest($action, $withCredentials = 1){
        $return = array(
            "error" => array(),
            "params" => array()
        );
        if(API_MODE){
            $keyHashed = Tool::getHash("sha256", $_REQUEST["apiKey"], HASH_KEY);
            if($keyHashed != API_KEY) $return["error"][] = "Error de Conexi&oacute;n con API";
            //if(!$this->requestIsPost()) $return["error"][] = "M&eacute;todo Protegido";
            if($withCredentials){
                if(CREDENTIALS_NEEDED){
                    if(isset($_REQUEST["credentials"])){
                        $credentials = json_decode($_REQUEST["credentials"]);
                        $email = $credentials->email;
                        $pass = $credentials->password;
                        $staff = $this->checkCredentials($email,$pass);
                        if(!$staff){
                            $return["error"][] = "Credenciales de Staff No V&aacute;lidas";
                        } else {
                            if(!$this->checkPermission($staff["role"],$action)) $return["error"][] = "No tiene permiso";
                        }   
                    } else {
                        $staff = array();
                        $staff["role"] = "user";
                        if(!$this->checkPermission($staff["role"],$action)) $return["error"][] = "No tiene permiso";
                    }
                }
            }
            $request = $this->clean($_REQUEST);
            $actionFields = $this->actionFields[$action];
            if($action <> "edit" && $action <> "add" && $action <> "upload"){
                if($action == "getOwn" || $action == "addOwn" || $action == "editOwn" || $action == "deleteOwn"){
                    if(isset($request["credentials"])){
                        $validUser = $this->checkValidUser($request["credentials"]);
                        if(!$validUser){
                            $return["error"][] = "Credenciales Erroneas";
                        } 
                    } else {
                        $return["error"][] = "Credenciales No V&aacute;lidas";
                    }
                } else {
                    $requiredFields = Tool::validateAtLeastFields($actionFields, $request);
                    if(!empty($actionFields)) {
                        if(is_array($requiredFields)){
                            $return["error"][] = "Faltan Campos Requeridos: <br>".Html::ListArray($requiredFields);
                        }
                    }
                }
            }
            $return["params"] = Tool::returnJustThisFields($actionFields,$request);
        } else {
            $return["error"][] = "Error en API";
        }
        return $return;
    }
    
    // Check if user is valid
    public function checkValidUser($credentials){
        $model = $this->loadModel(USER_MODEL);
        $id = $credentials["id"];
        $pass = Tool::getHash("sha256", $credentials["password"], HASH_KEY);
        $where = "id = '{$id}' AND pass = '$pass'";
        $user = $model->get($where);
        return (!$user) ? false : true;
    }
    
    public function clean($requestArray){
        $newArray = array();
        foreach($requestArray as $key => $value){
            if(is_array($requestArray[$key])){
                $newArray[$key] = $this->clean($requestArray[$key]);
            } else {
                if(Tool::isJson($value)){
                    $object = json_decode($value);
                    $array = array();
                    if(is_object($object)){
                        foreach($object as $o => $e){
                            $array[$o] = htmlentities($e);
                        }
                        $newArray[$key] = json_encode($array);
                    } else {
                        $newArray[$key] = htmlentities($value);
                    }
                } else {
                    $newArray[$key] = htmlentities($value);
                }
            }
        }
        return $newArray;
    }
    
    public function checkCredentials($email,$password){
        $model = $this->loadModel(CREDENTIALS_MODEL);
        $params = array(
            "email" => $email,
            "password" => $password
        );
        $staff = $model->login($params);
        return (isset($staff["error"]) && !empty($staff["error"])) ? false : $staff;
    }
    
    /* IS AJAX
    *  Devuelve FALSE si no es un Request via ajax o TRUE si es.
    */ 
    protected function requestIsAjax(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function getBlancJson(){
        if($this->requestIsPost()){
            //echo Tool::getHash("sha256", 1546879, HASH_KEY);
            $keyHashed = Tool::getHash("sha256", $_REQUEST["apiKey"], HASH_KEY);
            if(isset($_REQUEST["apiKey"]) && $keyHashed == API_KEY){
                $data = $this->m->getBlanc();
            } else {
                $data = array("error","Método privado");
            }
    	} else {
            $data = array("error","Método privado");
    	}
    	print json_encode($this->cleanArrayForJson($data));
    }

    protected function requestIsPost(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            return 1;
        } else {
            return 0;
        }
    }
    
    /* LOAD MODEL
    *  Carga el modelo, necesita el nombre del modelo
    *  Ex:  $model = "something" carga somethingModel
    */ 
    protected function loadModel($model){
        $modelName = $model."Model";
        $modelRoute = ROOT."models".DS.$modelName.".php";
        
        if(is_readable($modelRoute)){
            require_once $modelRoute;
            $model = new $modelName;
            return $model;
        }
        else {
            throw new Exception("{$modelRoute} > Error de modelo");
        }
    }
    
    
    /* CLEAN ARRAY
    *  Convierte datos HTML y los caracteres especiales a un código más seguro.
    *  <> = &amp;gt;&amp;lt;
    */ 
    protected function cleanArray($dirty){
        $clean = array();
        foreach ($dirty as $key => $value){
            if(is_array($value)){
                foreach ($value as $keyA => $valueA) {
                    if(is_array($valueA)){
                        foreach ($valueA as $keyB => $valueB) {
                            $clean[$key][$keyA][$keyB] = htmlentities($valueB);
                        }
                    } else {
                        $clean[$key][$keyA] = htmlentities($valueA);
                    }
                }
            } else {
                $clean[$key] = htmlentities($value);
            }
        }
        return $clean;
    }
    
    protected function cleanArrayForJson($array){
        $clean = array();
        if(is_object($array)){
            $object = Tool::objectToArray($array);
            return $this->cleanArrayForJson($object);
        } elseif(is_array($array)){
            foreach ($array as $key => $value) {
                if(is_array($value)){
                    $clean[$key] = $this->cleanArrayForJson($value);
                } else {
                    $clean[$key] = html_entity_decode(stripslashes(utf8_encode($value)));
                }
            }
            return $clean;
        } else {
            return html_entity_decode(stripslashes(utf8_encode($array)));
        }
            
        
    }
    
    protected function getLibrary($library) {
        $routeLibrary = APP_PATH.$library.'.php';
        
        if(is_readable($routeLibrary)){
            require_once $routeLibrary;
        }
        else{
            throw new Exception('Error de libreria');
        }
    }
    
    protected function getText($clave) {
        if(isset($_REQUEST[$clave]) && !empty($_REQUEST[$clave])){
            $_REQUEST[$clave] = htmlentities(htmlspecialchars($_REQUEST[$clave]), ENT_NOQUOTES, 'UTF-8');
            return $_REQUEST[$clave];
        }
        
        return '';
    }
    
    protected function getInt($clave) {
        if(isset($_REQUEST[$clave]) && !empty($_REQUEST[$clave])){
            $_REQUEST[$clave] = filter_input($_REQUEST[$clave], $clave, FILTER_VALIDATE_INT);
            return $_REQUEST[$clave];
        }
        
        return 0;
    }
    
    /* REDIRECT
    *  Redirige a una ruta, si no se asignan, redirige a la URL del proyecto
    *  $route = "home/index" 
    */ 
    protected function redirect($route = false) {
        if($route){
            if(Tool::haveString("/",$route)){
                $routeBig = explode("/", $route);
                $actualRoute = $routeBig[0]."/".$routeBig[1];
            } else {
                $actualRoute = $route;
            }
            $actualUrl = URL.$actualRoute;
        } else{
            $actualUrl = URL;
        }
        header('location: '.$actualUrl);
    }
    
    protected function goToUrl($url){
        header('location: '.$url);
    }

    protected function filterInt($int) {
        $int = (int) $int;
        
        if(is_int($int)){
            return $int;
        }
        else{
            return 0;
        }
    }
    
    protected function getParam($clave) {
        if(isset($_REQUEST[$clave])){
            return $_REQUEST[$clave];
        }
    }
    
    protected function getSql($clave) {
        if(isset($_REQUEST[$clave]) && !empty($_REQUEST[$clave])){
            $_REQUEST[$clave] = strip_tags($_REQUEST[$clave]);
            
            if(!get_magic_quotes_gpc()){
                $_REQUEST[$clave] = mysql_escape_string($_REQUEST[$clave]);
            }
            
            return trim($_REQUEST[$clave]);
        }
    }
    
    protected function getAlphaNum($clave) {
        if(isset($_REQUEST[$clave]) && !empty($_REQUEST[$clave])){
            $_REQUEST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_REQUEST[$clave]);
            return trim($_REQUEST[$clave]);
        }        
    }
    
    public function validateEmail($email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        
        return true;
    }
    
    // Funciones comunes para api
    
    
    public function json() {
        $valid = $this->isValidRequest("get");
        if(method_exists($this->m, "getEm")){
            $data = (empty($valid["error"])) ? $this->m->getEm() : array("error" => $valid["error"]);
        } else {
            $data = array("error"=>"No est&aacute; permitida &eacute;sta acci&oacute;n.");
        }
        print json_encode($this->cleanArrayForJson($data));
    }

    public function add() {
        $valid = $this->isValidRequest("add");
        $data = (empty($valid["error"])) ? $this->m->add($valid["params"]) : array("error" => $valid["error"]);
        print json_encode($this->cleanArrayForJson($data));
    }

    public function edit() {
        $valid = $this->isValidRequest("edit");
        $data = (empty($valid["error"])) ? $this->m->edit($valid["params"]) : array("error" => $valid["error"]);
        print json_encode($this->cleanArrayForJson($data));
    }
    
    public function remove() {
        $valid = $this->isValidRequest("remove");
        $data = (empty($valid["error"])) ? $this->m->remove($valid["params"]) : array("error" => $valid["error"]);
        print json_encode($this->cleanArrayForJson($data));
    }
    
    public function upload(){
        $error = array();
        $keyHashed = Tool::getHash("sha256", $_REQUEST["apiKey"], HASH_KEY);
        if($keyHashed != API_KEY) $error[] = "Error de Conexi&oacute;n con API";
        if(CREDENTIALS_NEEDED){
            $email = $_REQUEST["email"];
            $pass = $_REQUEST["pass"];
            $staff = $this->checkCredentials($email,$pass);
            
            if(!$staff){
                $error[] = "Credenciales No V&aacute;lidas";
            } else {
                if(!$this->checkPermission($staff["role"],"upload")) $error[] = "No tiene permiso";
            }
        }
        if(empty($error)){
            $nextId = $this->m->upload();
            print json_encode($this->cleanArrayForJson($nextId));
        } else {
            print json_encode($this->cleanArrayForJson($error));
        }
    }
    
}
