<?php
namespace lib;

class Json2Csv {

    function json_csv($json, $module = '') {

        $risk = [
            -1 => '未知',
            0 => '安全',
            1 => '可疑',
            2 => '低',
            3 => '中',
            4 => '高',
            5 => '严重',
        ];

        $csvString = "\xEF\xBB\xBF";
        $keys = array();

        if ($json[0] == "{") {
            $json = "[" . $json;
        }

        if ($json[strlen($json)-1] == "}") {
            $json .= "]";
        }

        $rowsArray = json_decode($json,1);
        $tmp = array_keys($rowsArray[0]);
        foreach ($tmp as $key => $row) {
            if($module == 'defense') {
                if($key == 8 || $key == 17) {
                    continue;
                }
            }
            $keys[] = t('log.'.$row);
        }
        $row1 = implode(",", $keys);

        $csvString .= $row1 . "\n";

        foreach ($rowsArray as $row) {
            if($module == 'defense') {
                unset($row['loglevel']);
                unset($row['query']);
                if(strpos($row['source'], 'Cloud') !== false) {
                    $row['confidence'] = $row['confidence'] * 10;
                }
                $row['risk'] = $risk[$row['risk']];
            }
            if(is_numeric($row['level'])) {
                $row['level'] = t('log.level'.$row['level']);
            }
            $row = str_replace(",","，",$row);
            $row = str_replace("\n", "", $row);
            $rowString = implode(",",$row);
            $csvString .= $rowString . "\n";
        }
        return $csvString;

    }
}
