<? class Tool {
    // For a multi-dimensional array
    public static function array2object($array) {
        $object = (object) $array;

        foreach ($object as $key) {
            if (is_array($key)) { $object = (object) $key; }
        }
        return $object;
    }
    /* Get Next Empty Spot
     *  -> Searchs in $array for the next logical id (starts at 1)
     *  Ex: array(1,2,4,5) must return 3
     *  Ex2: array(1,2,3,4) must return 5
     */
    public static function getNextEmptySpot($array, $prefix = "T", $suffix = ""){
        if(is_array($array) && !empty($array)){
            for($a=0;$a<count($array);$a++){
                $mustBe = $prefix.($a+1).$suffix;
                if($mustBe<>$array[$a]){
                    return $mustBe;
                }
            }
            return $prefix.(count($array)+1).$suffix;
        } else {
            return $prefix."1".$suffix;
        }
    }
    /* Fill Next Empty Spot
     *  -> Searchs in $array for the next logical id (starts at 1)
     *  Ex: array(1,2,4,5) must return array(1,2,3,4,5)
     *  Ex2: array(1,2,3,4) must return array(1,2,3,4,5)
     */
    public static function fillNextEmptySpot($array, $withWhat = false, $prefix = "T", $suffix = ""){
        if(is_array($array) && !empty($array)){
            $newArray = array();
            $done = false;
            for($a=0;$a<(count($array)+1);$a++){
                if(!$done){
                    $mustBe = $prefix.($a+1).$suffix;
                    if($mustBe==$array[$a]){
                        $newArray[] = $array[$a];
                    } else {
                        $newArray[] = ($withWhat) ? $withWhat : $mustBe;
                        $done = true;
                    }
                } else {
                    $newArray[] = $array[$a-1];
                }
            }
            return $newArray;
        } else {
            return array($prefix."1".$suffix);
        }
    }
    public static function convertFileType($fileShema){
        switch ($fileShema) {
            case "image/jpg": $return = ".jpg"; break;
            case "image/jpeg": $return = ".jpg"; break;
            case "image/gif": $return = ".gif"; break;
            case "image/png": $return = ".png"; break;

            default: $return = ".jpg"; break;
        }
        return $return;
    }
    public static function removeFromArray($array,$what){
        $clean = array_diff($array,[$what]);
        return $clean;
    }
    public static function removeFromString($string,$what){
        return str_replace($what, "", $string);
    }
    public static function removeAllFromList($delimiter,$what,$listString){
        $array = explode($delimiter, $listString);
        $clean = Tool::removeFromArray($array, $what);
        if(empty($clean)){
            return false;
        } else {
            $newList = implode(",", $clean);
            return $newList;
        }   
    }
    // Hace lo mismo que removeAllFromList pero tambien elimina lo que siga despues de $what en cada string
    public static function removeAllFromListC($delimiter,$what,$listString){
        $array = explode($delimiter, $listString);
        $string = array();
        $clean = array();
        for($i=0;$i<count($array);$i++){
            if(!Tool::haveString($what, $array[$i])){
                $string[] = $array[$i];
            } else {
                $clean[] = $array[$i];
            }
        }
        $return = array(
            "string" => (empty($string)) ? false : implode(",",$string),
            "array" => (empty($clean)) ? false : $clean
        );
        return $return;
    }
    public static function howManyOccurrenciesInArray($what,$array){
        $count = 0;
        for($i=0;$i<count($array);$i++){
            if($array[$i] == $what){
                $count++;
            }
        }
        return $count;
    }
    public static function howManyOcurrenciesInList($delimeter,$what,$list){
        $array = explode($delimeter, $list);
        $count = Tool::howManyOccurrenciesInArray($what, $array);
        return $count;
    }
    // Hace lo mismo que how Many Ocurrencies In List, pero toma en cuenta strings que solo inician con $what
    public static function howManyOcurrenciesInListC($delimeter,$what,$list){
        $array = explode($delimeter, $list);
        $newArray = array();
        for($i=0;$i<count($array);$i++){
            if(Tool::haveString($what, $array[$i])){ 
                $newArray[] = $array[$i];
            }
        }
        return count($newArray);
    }
    public static function actualUrl($secure = false){
        $host = $_SERVER[HTTP_HOST];
        $uri = $_SERVER[REQUEST_URI];
        $server = ($secure) ? "https//" : "http://";
        $actualUrl = $server.$host.$uri;
        return $actualUrl;
    }
    public static function makeList($separatedBy,$array){
        $list = "";
        for($o=0;$o<count($array);$o++){
            $list .= ($o==(count($array)-1)) ? 
                $array[$o] : 
                $array[$o].$separatedBy; 
        }
        return $list;
    }
    
    // Remplaza los caracteres mayores que el $lenght en $text por ...
    public static function grapText($lenght, $text) {
		if (strlen($text)>$lenght) {
			echo substr($text, -strlen($text), $lenght).'...';
		} else {
			echo $text;
		}
    }
    public static function formatMoney($int) {
        $result = number_format($int);
        return $result;
    }
    public static function capitalize($text) {
        $newText = strtoupper($text);
        return $newText;
    }
    public static function replaceSpace($string) {
        $newString = str_replace(" ","_",$string);
        return $newString;
    }
    public static function slugify($text){
        $nospaces = Tool::replaceSpace($text);
        $lowercase = strtolower($nospaces);
        return $lowercase;
    }
    public static function capitalizeFirst($text) {
        $newText = ucfirst($text);
        return $newText;
    }
    public static function replaceUnder($string) {
        $newString = str_replace("_"," ",$string);
        return $newString;
    }
    public static function makeUrl($string) {
        $borrar = array("!", ",", ".", ":", "'", "=");
        $remplazar = array(
            " "=>"-",
            "&aacute;"=>"a",
            "&eacute;"=>"e",
            "&iacute;"=>"i",
            "&oacute;"=>"o",
            "&uacute;"=>"u",
            "&ntilde;"=>"n",
        );
        $cleanStr = strtolower($string);
        foreach($remplazar as $remplazado => $por) {
            $cleanStr = str_replace($remplazado,$por,$cleanStr);
        }
        foreach($borrar as $borrado) {
            $cleanStr = str_replace($borrado,"",$cleanStr);
        }
        //$newString4 = str_replace ("", "", $newString3);
        return $cleanStr;
    }
	public static function lowerCase($string){
		$lowered = strtolower($string);
		return $lowered;
	}
    public static function cleanText($text) {
        $t = htmlspecialchars_decode($text, ENT_NOQUOTES);
        $output = str_replace('\&quot;', '&quot;', $t);
        $output2 = str_replace("\&#039;", "&#039;", $output);
        $output3 = str_replace("\'", "'", $output2);
        $output4 = str_replace('\"', '"', $output3);
        return $output4;
    }
    
    public static function getHash($algoritmo, $data, $key) {
        $hash = hash_init($algoritmo, HASH_HMAC, $key);
        hash_update($hash, $data);
        
        return hash_final($hash);
    }
    
    public static function stripNum($num) {
	$new_num = $num;
        if ($num == "00") { $new_num = '0'; }
	if ($num == "01") { $new_num = str_replace ("0", "", $num); }
	if ($num == "02") { $new_num = str_replace ("0", "", $num); }
	if ($num == "03") { $new_num = str_replace ("0", "", $num); }
	if ($num == "04") { $new_num = str_replace ("0", "", $num); }
	if ($num == "05") { $new_num = str_replace ("0", "", $num); }
	if ($num == "06") { $new_num = str_replace ("0", "", $num); }
	if ($num == "07") { $new_num = str_replace ("0", "", $num); }
	if ($num == "08") { $new_num = str_replace ("0", "", $num); }
	if ($num == "09") { $new_num = str_replace ("0", "", $num); }
	return $new_num;
    }
    
    public static function cleanString($string){
        $new_string = str_replace ("&", "&amp;", $string);
        $new_string2 = str_replace ('"', "&quot;", $new_string);
        $new_string3 = str_replace (chr(151), "&#8212;", $new_string2); //em dash
        $new_string4 = str_replace (chr(150), "&#8211;", $new_string3); //en dash
        $new_string5 = str_replace (chr(145), "'", $new_string4); // Left single quote
        $new_string6 = str_replace (chr(146), "'", $new_string5); // Right single quote
        $new_string7 = str_replace ("ñ", "&ntilde;", $new_string6); // Right single quote
        $new_string8 = htmlentities($new_string7, ENT_NOQUOTES, 'UTF-8');
        if (substr($new_string8, -1, 1) == ' ') { $last_string = substr($new_string8, 0, -1); return $last_string;} 
        else { return $new_string8; }
    }
    
    public static function zipFolder($source_dir,$zip_file){
        $file_list = scandir($source_dir);

        $zip = new ZipArchive();
        $opened = $zip->open($zip_file, ZIPARCHIVE::CREATE);
        if ($opened === true) {
            foreach ($file_list as $file) {
                if ($file !== $zip_file) {
                    $zip->addFile($file, substr($file, strlen($source_dir)));
                }
            }
            $zip->close();
            return 1;
        } else {
            return $opened;
        }
    }
    
    public static function haveString($search, $string){
        if(strpos($string,$search) !== false){
            return true;
        } else {
            return false;
        }
    }
    
    // Validate Exact Fields
    // $needed = array(id,name)
    // $fields = array(id,name,someOther) = false
    // $fields = array(id,name) = true
    public static function validateExactFields($exact,$fields){
        $valid = array();
        for($n=0;$n<count($exact);$n++){
            $valid[] = (in_array($exact[$n], $fields)) ? true : false;
            $valid[] = (in_array($fields[$n], $exact)) ? true : false;
        }
        return (in_array(false,$valid)) ? true : false;
    }
    
    public static function objectToArray ($data) {
        if(is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[$key] = Tool::objectToArray($value);
            }
            return $result;
	}
	return $data;
    }
    
    public static function isJson($string) {
        $a = json_decode($string);
        return (!is_null($a));
    }
    
    public static function returnJustThisFields($justThese,$fields){
        $params = array();
        if(is_array($justThese)){
            foreach ($justThese as $key => $value) {
                if(is_array($justThese[$key])){
                    $field = $fields[$key];
                    $object = json_decode($field);
                    $array =  (array) $object;
                    for($o=0;$o<=count($value)-1;$o++){
                        $fieldInArray = $value[$o];
                        if(isset($array[$fieldInArray])){
                            $params[$key][$fieldInArray] = $array[$fieldInArray];
                        }
                    }
                } else {
                    $field = $fields[$value];
                    $params[$value] = $field;
                }
            }
        } 
        return $params;
        
    }

    // Validate At Least Fields
    // $required = array(1,2,5)
    // $fields = array(1,2,3,4)
    public static function validateAtLeastFields($required,$fields){
        $error = array();
        foreach($required as $key => $value){
            if(is_array($value)){
                $object = json_decode($fields[$key]);
                $array = (array) $object;
                $keys = array_keys($array);
                for($n=0;$n<=count($value)-1;$n++){
                    if(!in_array($value[$n],$keys)){
                        $error[] = $value[$n];
                    }
                }
            } else {
                $keys = array_keys($fields);
                if(!in_array($required[$key],$keys)){
                    $error[] = $required[$key];
                }
            }
        }
        if(empty($error)){
            return true;
        } else {
            return $error;
        }
    }
    
    // Validate No More Fields
    // $justThisFields = array(1,2,3)
    // $fields = array(1)
    // return false
    public function validateNoMoreFields($justThisFields,$fields){
        $valid = array();
        for($n=0;$n<=count($fields)-1;$n++){
            if(in_array($fields[$n], $justThisFields)){
                $valid[] = true;
            } else {
                $valid[] = false;
            }
        }
        return (in_array(false,$valid)) ? true : false;
    }
    
}
