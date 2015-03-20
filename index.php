<? 
 /* Ultima Actializacion: 30/JUL/2014
 * -------------------------------------
 * MVC-ACATL 
 * ------------------------------------- */

ini_set('display_errors', 1); // 0 para no mostrar errores

define('VER', "0.2");
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)).DS);
define('ROOT_R', str_replace(DS, "/", ROOT));
define('PATH', "/");
define('APP_PATH', ROOT.'libs'.DS);

try {
    require_once APP_PATH.'Config.php';
    require_once APP_PATH.'Request.php';
    require_once APP_PATH.'Boot.php';
    require_once APP_PATH.'Controller.php';
    require_once APP_PATH.'Model.php';
    require_once APP_PATH.'View.php';
    require_once APP_PATH.'Database.php';
    require_once APP_PATH.'Session.php';
    require_once APP_PATH.'Tool.php';
    require_once APP_PATH.'PHPMailer.php';

    Session::init();

    Boot::run(new Request);
}
catch(Exception $e){
    include_once '404.html';
    echo '<br />';
    echo $e->getMessage();
}
?>