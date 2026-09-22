<?php
namespace lib;
use DOMDocument;

class Arr2Xml{

    /*function arrayToXml($arr,$dom=null,$node=null,$root='logs',$cdata=false){  
        if (!$dom){  
            $dom = new DOMDocument('1.0','utf-8');  
        }  
        if(!$node){  
            $node = $dom->createElement($root);  
            $dom->appendChild($node);  
        }  
        foreach ($arr as $key=>$value){  
            $child_node = $dom->createElement(is_string($key) ? $key : 'log');  
            $node->appendChild($child_node);  
            if (!is_array($value)){  
                if (!$cdata) {  
                    $data = $dom->createTextNode($value);  
                }else{  
                    $data = $dom->createCDATASection($value);  
                }  
                $child_node->appendChild($data);  
            }else {  
                self::arrayToXml($value,$dom,$child_node,$root,$cdata);  
            }  
        } 
        //$dom->preserveWhiteSpace = FALSE; 
        $dom->formatOutput = true;
        return $dom->saveXML();  
    }*/
    public static $root = 'logs';
    public static $indentation = '    ';
    public static $list = '';
    // TODO: private $this->addtypes = false; // type="string|int|float|array|null|bool"

    function export($data)
    {
        $data = array(self::$root => $data);
        self::$list = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
        self::recurse($data, 0);
        self::$list .= PHP_EOL;
        return self::$list;
    }

    function recurse($data, $level)
    {
        $indent = str_repeat(self::$indentation, $level);
        foreach ($data as $key => $value) {
            self::$list .= PHP_EOL . $indent;
            if ($value === null) {
                self::$list .=  "<".$key."/>";
            } else {
                self::$list .= "<".$key.">";
                if (is_array($value)) {
                    if ($value) {
                        $temporary = self::getArrayName($key);
                        foreach ($value as $entry) {
                            if($entry->level && is_numeric($entry->level)){
                                $entry->level = t('log.level'.$entry->level);
                            }
                            self::recurse(array($temporary => $entry), $level + 1);
                        }
                        self::$list .= PHP_EOL . $indent;
                    }
                } else if (is_object($value)) {
                    if ($value) {
                        self::recurse($value, $level + 1);
                        self::$list .= PHP_EOL . $indent;
                    }
                } else {
                    if (is_bool($value)) {
                        $value = $value ? 'true' : 'false';
                    }
                    self::$list .= self::escape($value);
                }
                self::$list .= "</" . $key . ">";
            }
        }
    }
    function escape($value)
    {
        // TODO:
        return htmlspecialchars($value);
    }
    function getArrayName($parentName)
    {
        // TODO: special namding for tag names within arrays
        if ($parentName == 'logs') {
            return 'log';
        }
        return $parentName;
    }
}
    
?>