<? class Model {

    protected $db;
    protected $es;

    public function __construct() {
        // Database
        if(DB_NAME && DB_HOST){
            $this->db = new Database();
        }
    }

    /* LOAD MODEL
     *  Carga el modelo, necesita el nombre del modelo
     *  Ex:  $model = "something" carga somethingModel
     */

    public function loadModel($model) {
        $modelName = $model . "Model";
        $modelRoute = ROOT . "models" . DS . $modelName . ".php";

        if (is_readable($modelRoute)) {
            require_once $modelRoute;
            $model = new $modelName;
            return $model;
        } else {
            throw new Exception("{$modelRoute} > Error de modelo");
        }
    }
    
    public function nextId(){
        $sql = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '{$this->mod}'";
        $sth = $this->db->select($sql);
        $row = $sth->fetch(2);
        $nextId = $row['AUTO_INCREMENT']; 
        return $nextId;
    }
    
    public function getBlanc($setter = false){
        $fields = ($setter) ? $this->setterFields : $this->getterFields;
        $blancFull = $this->getEmpty();
        $blanc = array();
        foreach($blancFull as $key => $value){
            if(in_array($key, $fields)){
                $blanc[$key] = $value;
            }
        }
        return $blanc;
    }
    
    public function isUnique($what,$data){
        $sql = "SELECT `{$what}` FROM `{$this->table}` WHERE `{$what}` = '{$data}' ";
        $sth = $this->db->select($sql);
        $data = $sth->fetchAll(2);
        return (!$data) ? 0 : 1;
    }

    public function getEmpty($model = false) {
        $sql = (!$model) ? "SHOW COLUMNS FROM {$this->table}" : "SHOW COLUMNS FROM {$model->table}";
        $sth = $this->db->select($sql);
        $columns = $sth->fetchAll(2);
        $empty = array();
        if(!$model) $model = $this;
        foreach ($columns as $column) {
            if(in_array($column['Field'], $model->getterFields)){
                $empty[$column['Field']] = '';
            }
        }
        return $empty;
    }
    
    public function getParamsByIds($table,$idsArray,$params){
        $list = Tool::makeList(",",$idsArray);
        $query = "SELECT {$params} FROM ´{$table}´ WHERE id in ({$list})";
        $sth = $this->db->select($query);
        $names = $sth->fetchAll(2);
        return $names;
    }
    
    public function getNecessaryData($fields,$arrays,$idsArray,$dato){
        $response = array();
        if($dato){
            for ($f=0;$f<=(count($fields)-1);$f++){ // necesary fields
                $field = $fields[$f];
                if(in_array($field, $arrays)){ // field should be an array?
                    if(Tool::haveString(";",$dato[$field])){ //some values
                        $response[$field] = explode(";", $dato[$field]);
                    } else { // one value
                        $response[$field] = array($dato[$field]);
                    }
                } else if(in_array($field, $idsArray)){
                    $detail = array();
                    if(Tool::haveString("T", $dato[$field])){ // tiene ceros el arreglo de ids?
                        $list = Tool::removeAllFromListC(",","T",$dato[$field]);
                        $howManyEmptys = Tool::howManyOcurrenciesInListC(",","T",$dato[$field]);
                        $subModel = $this->loadModel($field);
                        if(!$list["string"] == false){
                            $detail = $subModel->getEm("id in ({$list})");
                        }
                        for($h=0;$h<$howManyEmptys;$h++){
                            $detail[$h] = $this->getEmpty($subModel);
                            $detail[$h]["id"] = $list["array"][$h];
                        }
                    } else if($dato[$field] <> "" || $dato[$field] <> NULL) { // Its empty?
                        $subModel = $this->loadModel($field);
                        $where = (Tool::haveString(",", $dato[$field])) ? "id in ({$dato[$field]})" : "id = '{$dato[$field]}'";
                        $detail = $subModel->getEm($where);
                    }
                    $response[$field] = $detail;
                } else { // is not an array
                    $response[$field] = $dato[$field];
                }
            }
        }
        return $response;
    }
    
    public function getComplexData($data,$fields,$arrays = array(),$idsArray = array()){
        $response = array();
        if(!empty($data)){
            if(isset($data[0])){
                foreach ($data as $key => $dato) { 
                    $response[$key] = $this->getNecessaryData($fields,$arrays,$idsArray,$dato);
                }
            } else {
                $response = $this->getNecessaryData($fields, $arrays, $idsArray, $data);
            }
        } else {
            $response = $data;
        }
        return $response;
    }

    public function getAll($where = false) {
        $sql = ($where) ? "SELECT * FROM {$this->table} WHERE {$where}" : "SELECT * FROM {$this->table}";
        $sth = $this->db->select($sql);
        $data = $sth->fetchAll(2);
        return $data;
    }

    public function getLast($howMany = false, $where = false, $order = 'DESC'){
        if(!$howMany) $howMany = 1;
        $sql = ($where) ? "SELECT * FROM {$this->table} WHERE {$where} ORDER {$order} LIMIT {$howMany}" : 
                "SELECT * FROM {$this->table} ORDER {$order} LIMIT {$howMany}";
        $sth = $this->db->select($sql);
        $data = $sth->fetchAll(2);
        return $data;
    }

    public function get($where = false) {
        $sql = ($where) ? "SELECT * FROM {$this->table} WHERE {$where}" : "SELECT * FROM {$this->table}";
        $sth = $this->db->select($sql);
        $data = $sth->fetch(2);
        return $data;
    }
    
    // Get Own get only owned info of What_ID
    public function getOwn($params){
        $credentials = $params["credendials"];
        $model = $credentials["model"];
        $userId = $credentials["id"];
        $where = "{$model}_id = '{$userId}'";
        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        $sth = $this->db->select($sql);
        $data = $sth->fetch(2);
        return $data;
    }

    public function getParam($id, $param) {
        $sql = "SELECT `{$param}` FROM {$this->table} WHERE id = '{$id}'";
        $sth = $this->db->select($sql);
        $data = $sth->fetch(2);
        return $data[$param];
    }
    
    public function addOwn($params){
        $credentials = $params["credendials"];
        $model = $credentials["model"];
        $userId = $credentials["id"];
        $oneD = $params[$this->mod];
        $new = array();
        foreach ($oneD as $key => $value){
            if($value <> null){
                $new[$key] = $value;
            } else if($value === 0){
                $new[$key] = 0;
            } else if($value === ""){
                $new[$key] = "";
            }
        }
        $new[$model."_id"] = $userId;
        $inserted = $this->db->insert($this->table, $new);
        return (int)$inserted;
    }
    
    public function add($one) {
        $oneD = $one[$this->mod];
        $new = array();
        foreach ($oneD as $key => $value){
            if($value <> null){
                $new[$key] = $value;
            } else if($value === 0){
                $new[$key] = 0;
            } else if($value === ""){
                $new[$key] = "";
            }
        }
        $inserted = $this->db->insert($this->table, $new);
        return (int)$inserted;
    }

    public function remove($one) {
        $id = $one[$this->mod."_id"];
        return $this->db->delete($this->table, "id = '{$id}'");
    }
    
    public function deleteOwn($params){
        $credentials = $params["credendials"];
        $model = $credentials["model"];
        $userId = $credentials["id"];
        $id = $params[$this->mod."_id"];
        return $this->db->delete($this->table, "id = '{$id}' AND {$model}_id = '{$userId}'");
    }
    
    public function removeAll($where){
        return $this->db->delete($this->table, $where);
    }
    
    public function edit($one) {
        $oneD = $one[$this->mod];
        $new = array();
        foreach ($oneD as $key => $value){
            if($value <> null){
                $new[$key] = $value;
            } else if($value === 0){
                $new[$key] = 0;
            } else if($value === ""){
                $new[$key] = "";
            }
        }
        $whatId = $this->mod."_id";
        $id = $one[$whatId];
        $edited = $this->db->update($this->table, $new, "id = '{$id}'");
        return $edited;
    }
    
    public function editOwn($params){
        $credentials = $params["credendials"];
        $model = $credentials["model"];
        $userId = $credentials["id"];
        $oneD = $params[$this->mod];
        $new = array();
        foreach ($oneD as $key => $value){
            if($value <> null){
                $new[$key] = $value;
            } else if($value === 0){
                $new[$key] = 0;
            } else if($value === ""){
                $new[$key] = "";
            }
        }
        $editedId = $this->mod."_id";
        $id = $params[$editedId];
        $edited = $this->db->update($this->table, $new, "id = '{$id}' AND {$model}_id = '{$userId}'");
        return $edited;
    }

    public function getMyCount($where = false) {
        $data = $this->getAll($where);
        return count($data);
    }
    
    public function validateFields($justThisFields,$fields){
        $valid = array();
        for($n=1;$n<(count($fields));$n++){
            $valid[] = (in_array($fields[$n], $justThisFields)) ? true : false;
        }
        return (in_array(false,$valid)) ? true : false;
    }
    
    public function upload(){
        $what = $_REQUEST["modelName"];
        if (!empty($_FILES['file'])) {
            $nextId = (isset($_REQUEST["nextId"]) && $_REQUEST["nextId"] <> "") ? $_REQUEST["nextId"] : $this->nextId();
            $fileName = $nextId.Tool::convertFileType($_FILES["file"]["type"]);
            $filePath = APU_ROOT."img/".$what."/".$fileName;
            if ($_FILES['file']['error'] == 0 && move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) { 
//                if(isset($_REQUEST["nextId"]) && $_REQUEST["nextId"] <> ""){ // Ya existe
//                    $whatId = $what."_id";
//                    $edited = array(
//                        $what => array(
//                            "img"=> $fileName
//                        ),
//                        $whatId => $nextId
//                    );
//                    $this->edit($edited);
//                } else { // Aun no existe
//                    $new = array(
//                        $what => array(
//                            "img"=> $fileName
//                        )
//                    );
//                    $this->add($new);
//                }
                return array("nextId" => $nextId,"src" => $fileName);
            } else {
                $return["error"] = $_FILES['file']['error'];
            }
        } else {
            $return["error"] = "Falta la Imagen en ".$what;
        }
        return $return;
    }

}
