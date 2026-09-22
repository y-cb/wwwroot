<?php
use lib\FunInc;

class Conn {
    function getSysCmd($param, $xml, $module, $action = "submit") {
        global $global;
        $param['page'] = ($_GET['page'] || $_POST['page']) ? $_POST['page'] : 1;
        $param['count'] = ($_GET['count'] || $_POST['rows']) ? $_POST['rows'] : $global['count'];
        $param['page'] = ($param['page']) ? $param['page'] : $_GET['page'];
        $param['count'] = ($param['count']) ? $param['count'] : $_GET['count'];
        return '<?xml version="1.0" encoding="UTF-8" standalone="no"?><' . $module . ' action="' . $action . '" language="' . $GLOBALS['language_cmd'] . '"  page="' . $param['page'] . '" count="' . $param['count'] . '" total="0"><group>' . $xml . '</group></' . $module . '>';
    }

    function getResponse($module, $action, $param, $url = 0) {
        global $DEMO_DATA, $DEBUG_SWITCH, $RECORD_MODE, $OFFLINE_MODE;
        if ($DEMO_DATA == 1 || $OFFLINE_MODE == 1) {
            $sendCmd = self::requestXml($module, $action, $param, $url);
            $demo_send_file = "req_" . $url . ".xml";
            $demo_data_file = "./data/rsp_" . $module . "_" . $action . ".xml";
            if ($submit == null) {
                $handle = fopen($demo_data_file, 'rb');
                $xmlStr = @fread($handle, filesize($demo_data_file));
                @pclose($handle);
            }
            if ($DEBUG_SWITCH == 1) echo debugWindow('<h2 style="width:600px;">Send String:<input type="button" value="resend"></h2><textarea style="width:600px;height:80px;">' . $sendCmd . '</textarea><h2 style="width:600px;">Response File:<br>' . $demo_data_file . '</h2>' . htmlspecialchars($xmlStr));
        } else {
            //send to system
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            if (false == $socket) return false;
            $socketaddr = tempnam(DOMAIN_SOCKET_DIR, DOMAIN_SOCKET_PREFIX);
            unlink($socketaddr);
            if (!$socketaddr || !socket_bind($socket, $socketaddr) || !socket_connect($socket, DOMAIN_SOCKET_REMOTE)) {
                socket_close($socket);
                return false;
            }
            $api_key = $_GET['api_key'];
            if (!empty($api_key)) {
                $cmd = new utm_cmd(UCT_CMD, $api_key);
            } else {
                $cmd = new utm_cmd(UCT_CMD, session_id());
            }
            $sendCmd = self::requestXml($module, $action, $param, $url);
            $cmd->body->name = $module;
            $cmd->body->setdata($sendCmd);
            $send = $cmd->tobytes();
            $recv = transferpacket($socket, $send, strlen($send));
            $echo = new utm_echocmd();
            if (!$echo->frombytes($recv)) {
                throw new SocketException('echo bytes error!');
            }
            $code = $echo->body->errcode;
            if ($code == 30000) {
                $php_self = $_SERVER['PHP_SELF'];
                $api_key = $_GET['api_key'];
                if (substr($php_self, 0, 13) == '/api/api.php/') {
                    if (!empty($api_key)) {
                        $ret = array('code' => 30000, 'str' => 'api key invalid');
                        echo json_encode($ret);
                        break;
                    } else {
                        $ret = array('code' => 30000, 'str' => 'api key not exist');
                        echo json_encode($ret);
                        break;
                    }
                }
                header('Location:/logout.php');
                break;
            }
            $xmlStr = $echo->body->getdata();
            if ($DEBUG_SWITCH == 1) {
                echo debugWindow('<h2 style="width:600px;">Send String:</h2>' . htmlspecialchars($sendCmd) . '<h2 style="width:600px;">Response:</h2>' . htmlspecialchars($xmlStr));
            }
            if ($RECORD_MODE == 1) {
                $demo_data_file = "./data/rsp_" . $module . "_" . $action . ".xml";
                if ($fp = fopen($demo_data_file, 'w')) {
                    flock($fp, 4);
                    fwrite($fp, $xmlStr);
                    fclose($fp);
                }
            }
        }
        response_Socket_Close($socket, $socketaddr);
        $retarray = domXmlToArr($xmlStr);
        return $retarray;
    }

    function response_Socket_Close($socket, $socketaddr) {
        if (isset($socket)) {
            socket_close($socket);
            unset($socket);
        }
        if (file_exists($socketaddr)) {
            unlink($socketaddr);
        }
    }

    function getRespXML($module, $action, $param, $submit = 0) {
    }

    function requestXml($module, $action, $param, $submit = 0) {
        return self::getSysCmd($param, arr2DomXml($param), $module, $action);
    }

    function sendReqXml($xml) {
        return ($xml) ? domXmlToArr($xml) : null;
    }

    function getAssign($array, $module_name, $json = 1, $list = 0) {
        if (array_key_exists($module_name, $array)) {
            $array = $array[$module_name];
            if ($array == null) return $array;
            if ($json == false) {
                if ($array['group'][0] == null) {
                    if ($array[group]) $retArr['group'][0] = $array['group'];
                    else $retArr['group'] = array();
                    if ($array['page']) $retArr['page'] = $array['page'];
                }
                if ($array['group'][0]) $retArr = $array;
                return $retArr;
            }
            $array = $array['group'];
            if (is_array($array[0]) && sizeof($array) > 1) {
                $retArr = array();
                foreach ($array as $index => $item) {
                    foreach ($item as $i => $e) {
                        if (is_array($e)) $item[$i] = json_encode($e);
                    }
                    $retArr[$index] = $item;
                }
            } else {
                if ($array) {
                    foreach ($array as $i => $e) {
                        $Arr[$i] = (is_array($e)) ? json_encode($e) : $e;
                    }
                    if ($list) {
                        $retArr[0] = $Arr;
                    } else $retArr = $Arr;
                }
            }
            return $retArr;
        } else {
            return $array[return_code][group];
        }
    }

    function getAssignExpand($array, $json = 1, $list = 0) {
        $array = $array['response-list'];
        if ($array == null) return $array;
        if ($json == false) {
            if ($array['group'][0] == null) {
                if ($array[group]) $retArr['group'][0] = $array['group'];
                else $retArr['group'] = array();
                if ($array['page']) $retArr['page'] = $array['page'];
            }
            if ($array['group'][0]) $retArr = $array;
            return $retArr;
        }
        $array = $array['group'];
        if (is_array($array[0]) && sizeof($array) > 1) {
            $retArr = array();
            foreach ($array as $index => $item) {
                foreach ($item as $i => $e) {
                    if (is_array($e)) $item[$i] = json_encode($e);
                }
                $retArr[$index] = $item;
            }
        } else {
            if ($array) {
                foreach ($array as $i => $e) {
                    $Arr[$i] = (is_array($e)) ? json_encode($e) : $e;
                }
                if ($list) {
                    $retArr[0] = $Arr;
                } else $retArr = $Arr;
            }
        }
        return $retArr;
    }

    function getTotal($array) {
        if ($array['response-list']) return $array['response-list']['page']['total'];
        else return 0;
    }

    function fmtRetParam($array) {
        return $array;
    }

    function getResponseArr($xmlStr, $operation_name = "") {
        global $debugModule;
        require_once ("./libs/XmlParser.class.php");
        $xml = new XmlParser();
        $xml->parseData($xmlStr);
        $tree = $xml->getTree();
        $ret[ErrorCode] = $tree[0][attrs][ERRORCODE];
        $ret[ErrorString] = $tree[0][attrs][ERRORSTRING];
        $ret[Total] = $tree[0][attrs][RESPONSE_GET_COUNT];
        $ret[Content] = $tree[0][child];
        return $tree;
    }
    function getArrAttrs($arr) {
        return $arr = $arr[0][attrs];
    }
    function getPageTotal($arr) {
        $array = getArrAttrs($arr);
        return $array['TOTAL'];
    }
    function getPageAttr($isPage = true) {
        global $global;
        $page = Array();
        $page['page'] = ($_GET['page'] || $_POST['page']) ? $_POST['page'] : 1;
        $page['count'] = ($_GET['count'] || $_POST['rows']) ? $_POST['rows'] : $global['count'];
        return $page;
    }
    function getPageLink($url, $total = 0, $count = 20) {
        global $global;
        $page = Array();
        $page['page'] = ($_GET['page']) ? $_GET['page'] : 1;
        $page['count'] = ($_GET['count']) ? $_GET['count'] : $global['count'];
        $page['total'] = $total;
        $page['link'] = $url;
        if ($count) $page['count'] = $count;
        $_SESSION['link'] = ($_GET['page']) ? "&page=" . $page['page'] . "&count=" . $page['count'] : '';
        return json_encode($page);
    }
    function getAssignArr($arr, $arrKey = - 1, $childDeep = 2) {
        if (is_array($arr) && sizeof($arr) > 0) {
            $arr = $arr[0][child];
            $retArr = array();
            if (is_array($arr) && sizeof($arr) > 0) foreach ($arr as $index => $item) {
                $retArr[$index] = $item[attrs];
                if (isset($item[child])) {
                    for ($i = 0, $length = sizeof($item[child]);$i < $length;$i++) {
                        if ($childDeep == 1) $retArr[$index][$item[child][$i][name]] = getChildArr($item);
                        else if ($childDeep == 2) $retArr[$index][$item[child][$i][name]] = getChildArr($item[child][$i]);
                    }
                }
            }
        }
        return ($arrKey == - 1) ? $retArr : $retArr[$arrKey];
    }
    function getChildArr($arr) {
        return ($arr[child]) ? json_encode($arr[child]) : json_encode($arr);
    }
    function getNameArr($arr, $key = '') {
        for ($i = 0, $l = sizeof($arr);$i < $l;$i++) {
            $array[$i]['id'] = $arr[$i]['NAME'];
            $array[$i]['text'] = $arr[$i]['NAME'];
            if ($key) {
                if (in_array($array[$i]['text'], explode(",", $key))) $array[$i]['checked'] = "true";
            }
        }
        return $array;
    }

    function getItemArrOption($arr, $item = '', $key = '') {
        $str = "";
        for ($i = 0, $l = sizeof($arr);$i < $l;$i++) {
            if ($key) {
                if (in_array($arr[$i][$item], explode(",", $key))) {
                    $str.= "<option value=\"" . $arr[$i][$item] . "\" checked>" . $arr[$i][$item] . "</option>";
                } else {
                    $str.= "<option value=\"" . $arr[$i][$item] . "\">" . $arr[$i][$item] . "</option>";
                }
            }
        }
        return $str;
    }

    function getArrChild($array) {
        if (sizeof($array) == 1) {
            if (sizeof(array_keys($array[0]['attrs'])) == 1) return $array[0]['attrs']['NAME'];
            else return $array[0]['attrs'];
        } else {
            for ($i = 0, $l = sizeof($array);$i < $l;$i++) {
                $Arr[$i] = $array[$i]['attrs']['NAME'];
            }
            return json_encode($Arr);
        }
    }

    function setArrXmlAtt($Arr, $key = "param") {
        if (is_array($Arr)) {
            $setParamStr = "<$key ";
            foreach ($Arr as $index => $item) {
                $setParamStr.= $index . "=\"" . $item . "\" ";
            }
            $setParamStr.= "/>";
            return $setParamStr;
        } else return "<$key name=\"" . $Arr . "\" /> ";
    }

    function getMessageResponse($utc_type, $cmd_body_name, $fname) {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (false == $socket) {
            echo "socket failure\n";
            return false;
        }
        $socketaddr = tempnam(DOMAIN_SOCKET_DIR, DOMAIN_SOCKET_PREFIX);
        unlink($socketaddr);
        if (!$socketaddr || !socket_bind($socket, $socketaddr) || !socket_connect($socket, DOMAIN_SOCKET_REMOTE)) {
            socket_close($socket);
            echo "socket close\n";
            return false;
        }
        $api_key = $_GET['api_key'];
        if (!empty($api_key)) {
            $cmd = new utm_cmd(UCT_CMD, $api_key);
        } else {
            $cmd = new utm_cmd(UCT_CMD, session_id());
        }
        $cmd->body->name = $cmd_body_name;
        $cmd->body->setdata($fname);
        $send = $cmd->tobytes();
        $recv = transferpacket($socket, $send, strlen($send));
        $echo = new utm_echocmd();
        if (!$echo->frombytes($recv)) {
            throw new SocketException('echo bytes error!');
        }
        $code = $echo->body->errcode;
        if ($code == 30000) {
            header('Location:/logout.php');
            break;
        }
        $data = $echo->body->getdata();
        return $code;
    }
}
?>
