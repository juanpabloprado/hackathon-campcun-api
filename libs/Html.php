<?php

/**
 * Description of Html
 * Functions for HTML Wrapping
 *
 * @author ceacatl
 */
class Html {
    
    /*
     * ListArray:
     * crea una lista a partir de un arreglo
     * default: ul
     * si tiene arreglos el arreglo, lo toma en cuenta infinitamente
     * 
     */
    public static function ListArray($array,$type = "ul"){
        $parent = array("<{$type}>","</{$type}>");
        $child = array("<li>","</li>");
        $list = "";
        if(!empty($array)){
            $list .= $parent[0];
            for($i=0;$i<count($array);$i++){
                $list .= $child[0];
                    if(is_array($array[$i])){
                        $list .= ListArray($array[$i]);
                    } else {
                        $list .= $array[$i];
                    }
                $list .= $child[1];
            }
            $list .= $parent[1];
        }
        return $list;
    }
}
