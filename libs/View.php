<? class View {
    
    public $lang;
    public $jsRoute;
    public $cssRoute;
    public $imgRoute;
    public $tools;
    
    public function __construct(Request $r) {
        $this->lang = $r->getLang();
		$this->tools = new Tool;
    }
    
    public function flash($flash,$type){
        echo "<div class='alert alert-{$type}' role='alert'>";
        echo $flash;
        echo "</div>";
    }
    
    public function renderFlash($view,$flash,$type,$skin=false){
        $view = explode("/", $view);
        
        $routeView = (!$skin) ? VIEWSPATH.$view[0].DS.$view[1].".php" : VIEWSPATH.$skin.DS.$view[0].DS.$view[1].".php"; 
        $this->jsRoute = (!$skin) ? SKINROUTE."js/" : SKINROUTE.$skin."/js/";
        $this->cssRoute = (!$skin) ? SKINROUTE."css/" : SKINROUTE.$skin."/css/";
        $this->imgRoute = (!$skin) ? SKINROUTE."images/" : SKINROUTE.$skin."/images/";
        $skinRoute = (!$skin) ? SKINPATH : SKINPATH.$skin.DS;
        $skinPath = (!$skin) ? VIEWSPATH : VIEWSPATH.$skin.DS;
        
        if(is_readable($routeView) && is_readable($skinPath)){
            include_once $skinPath."includes/head.php";
            echo "<div class='row'><span class='message dismissible one third centered block {$type}'>{$flash}</span></div>";
            include_once $routeView;
            include_once $skinPath."includes/foot.php";
        } else {
            throw new Exception("> No existe vista en RENDER {$routeView}"); 
        }
    }
    
    public function render($view, $skin = false) {        
        $view = explode("/", $view);
        $routeView = (!$skin) ? VIEWSPATH.$view[0].DS.$view[1].".php" : VIEWSPATH.$skin.DS.$view[0].DS.$view[1].".php"; 
        $this->jsRoute = (!$skin) ? SKINROUTE."js/" : SKINROUTE.$skin."/js/";
        $this->cssRoute = (!$skin) ? SKINROUTE."css/" : SKINROUTE.$skin."/css/";
        $this->imgRoute = (!$skin) ? SKINROUTE."img/" : SKINROUTE.$skin."/img/";
        $skinRoute = (!$skin) ? SKINPATH : SKINPATH.$skin.DS;
        $skinPath = (!$skin) ? VIEWSPATH : VIEWSPATH.$skin.DS;
        if(is_readable($routeView)){
            if(is_readable($skinRoute)){
                include_once VIEWSPATH.DS."includes".DS."head.php";
                include_once $routeView;
                include_once VIEWSPATH.DS."includes".DS."foot.php";
            } else {
                throw new Exception("> No existe vista en RENDER {$skinRoute}"); 
            }
        } else {
            throw new Exception("> No existe vista en RENDER {$routeView}"); 
        }
    }
    
    /* RENDER PARTIAL
    *  Renderea especificamente una vista con datos sin template
    *  Ex:
    *  $view = "S/space/home/_header" => Invocando al archivo _home.php dentro de la carpeta home de vistas
    *  Si la primera variable no es S, se toma el espacio default;
    */  
    public function renderPartial($view, $dataArray = false){
        $views = explode("/", $view);
        $folder = array_shift($views);
        $viewFile = array_shift($views).".php";
        
        $routeView = VIEWSPATH.$folder.DS.$viewFile;
        if(is_readable($routeView)){
            if($dataArray){
                echo $this->includeContents($routeView, $dataArray);
            } else {
                include_once $routeView;
            }
        } else {
            throw new Exception("> No existe vista en RENDER PARTIAL {$routeView}"); 
        }
    }
    
    /* T > TRANSLATE
    *  Traduce un string
    *  Si no haya el string en el arreglo del idioma adecuado, muestra el string sin cambios
    */ 
    public function t($defaultString){
        if($this->lang == DEFAULT_LANG){
            return $defaultString;
        } else {
            $routeLang = ROOT."translations".DS.$this->lang.".php";
            if(is_readable($routeLang)){
                $langArray = include $routeLang;
                if(array_key_exists($defaultString, $langArray)){
                    return $langArray[$defaultString];
                } else {
                    return $defaultString;
                }
            } else {
                throw new Exception("> No existe archivo de traduccion o no es legible en T {$routeLang}"); 
            }
        }        
    }
    
    public function dirtyArray($clean){
        $dirty = array();
        foreach ($clean as $key => $value):
            $dirty[$key] = utf8_encode(html_entity_decode($value));
        endforeach;
        return $dirty;
    }
    
    private function includeContents($filename, $variablesToMakeLocal) {
        extract($variablesToMakeLocal);
        if (is_file($filename)) {
            ob_start();
            require_once $filename;
            return ob_get_clean();
        } else {
            return false;
        }
    }
}