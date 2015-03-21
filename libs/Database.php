<? class Database extends PDO {

    public function __construct() {
       parent::__construct(
            'mysql:host=' . DB_HOST .
            ';dbname=' . DB_NAME,
            DB_USER, 
            DB_PASS//, 
            //array(
                //PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHAR
                //)
            );
    }

    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @return mixed
     */
    public function select($sql, $array = array()) {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute();
        return $sth;
    }

    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */
    public function insert($table, $data) {
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        if($sth->execute()){
            return PDO::lastInsertId();
        } else {
            return $sth->errorInfo();
        }
        
        
    }

    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data, $where) {
        $fD = NULL; 
        $f = 1;
        foreach ($data as $key => $value) {
            if($value === 0 || $value === "0"){
                $fD .= ($f <> count($data)) ? "`{$key}`= 0," : "`{$key}`= 0";
            } else if($value <> ""){
                $val = "'{$value}'";
                $fD .= ($f <> count($data)) ? "`{$key}`= {$val}," : "`{$key}`= {$val}";
            } else if($value == ""){
                $fD .= ($f <> count($data)) ? "`{$key}`= ''," : "`{$key}`= ''";
            } 
            $f++;
        }
        $sql = "UPDATE {$table} SET {$fD} WHERE {$where}";
        $sth = $this->sql($sql);
        return $sth;
    }

    /**
     * delete
     * 
     * @param string $table
     * @param string $where
     * @param integer $limit
     * @return integer Affected Rows
     */
    public function delete($table, $where, $limit = 1) {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

    public function sql($sql) {
        $sth = $this->prepare($sql);
        $sth->execute();
        return $sth;
    }

}