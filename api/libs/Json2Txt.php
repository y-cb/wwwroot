<?php

namespace lib;

class Json2Txt
{

    public static function json_txt($data = [], $module = '') {

        if (!is_array($data) && is_string($data)) {
            if ($data[0] == "{") {
                $data = "[" . $data;
            }
            if ($data[strlen($data) - 1] == "}") {
                $data .= "]";
            }
            $data = json_decode($data, 1);
        }

        switch ($module) {

            case 'defense': { //威胁情报
                if(is_array($data) && !empty($data)) {
                    $temp = [];
                    foreach ($data as $row) {
                        $temp[] = [
                            'id' => $row['id'],
                            'srcip' => $row['srcip'],
                            'dstip' => $row['dstip'],
                            'srcport' => $row['srcport'] ? : '-',
                            'dstport' => $row['dstport'] ? : '-',
                            'protocol' => $row['protocol'],
                            'action' => $row['action'],
                            'object' => $row['object'],
                            'loglevel' => $row['loglevel'],
                            'source' => $row['source'],
                            'ioctype' => $row['ioctype'],
                            'confidence' => $row['confidence'],
                            'risk' => $row['risk'],
                            'threattype' => $row['threattype'],
                            'iocid' => $row['iocid'],
                            'iochash' => $row['iochash'],
                            'hotid' => $row['hotid'],
                            'query' => $row['query'],
                            'level' => t('log.level'.$row['level']),
                            'create_at' => $row['create_at'],
                        ];
                    }
                    $data = $temp;
                    unset($temp);
                }
                return self::line_map($data, function ($mask, $row) {
                    extract($row);
                    return sprintf($mask, $id, $srcip, $dstip, $srcport, $dstport, $protocol, $action, $object, $loglevel, $source, $ioctype, $confidence, $risk, $threattype, $iocid, $iochash, $hotid, $query, $level, $create_at);
                });
            }

            case 'web_access': { //web访问日志
                if(is_array($data) && !empty($data)) {
                    $temp = [];
                    foreach ($data as $row) {
                        $temp_row = $row;
                        $temp_row['level'] = t('log.level'.$row['level']);
                        $temp[] = $temp_row;
                    }
                    $data = $temp;
                    unset($temp);
                }
                return self::line_map($data, function ($mask, $row) {
                    extract($row);
                    return sprintf($mask, $id, $userid, $username, $srcip, $dstip, $protocol, $srcport, $dstport, $srcmac, $dstmac, $appname, $appnameen, $appcatename, $appaction, $host, $url, $title, $category, $action, $count, $level, $create_at);
                });
            }

            default: { //其它
                $csvString = "\xEF\xBB\xBF";
                $tmp = array_keys($data[0]);
                foreach ($tmp as $row) {
                    $keys[] = t('log.' . $row);
                }
                $row1 = implode("\t", $keys);
                $csvString .= $row1 . "\r\n";
                foreach ($data as $row) {
                    if($row['level'] && is_numeric($row['level'])){
                       $row['level'] = t('log.level'.$row['level']); 
                    }
                    $rowString = implode("\t", $row);
                    $csvString .= $rowString . "\r\n";
                }
                return $csvString;
            }
        }
    }

    private static function line_map($data, $cb_func) {

        $title_info = [
            'title' => array_map(function ($v) {
                return t('log.' . $v);
            }, array_combine(array_keys($data[0]), array_keys($data[0]))),
            'data' => $data,
            'col_size' => array_map(function () {
                return 0;
            }, array_flip(array_keys($data[0]))),
        ];

        $final_data = array_merge([$title_info['title']], $title_info['data']);
        foreach ($final_data as $row) {
            foreach ($row as $title => $text) {
                if ($title_info['col_size'][$title] < mb_strwidth($text)) {
                    $title_info['col_size'][$title] = mb_strwidth($text);
                }
            }
        }

        $final_str = '';
        foreach ($final_data as $row) {
            $mask = '|';
            foreach ($row as $title => $text) {
                $append = (self::ch_count($text) ? intval(self::ch_count($text)) : 0);
                $size = $title_info['col_size'][$title] + $append;
                $mask .= " %-{$size}s |";
            }
            $mask .= "\r\n";
            $final_str .= $cb_func($mask, $row);
        }
        return $final_str;
    }

    private function ch_count($str = NULL) {
        if (empty($str)) {
            return false;
        }
        preg_match_all("/([\x{4e00}-\x{9fa5}]){1}/u", $str, $arrCh);
        return count($arrCh[0]);
    }
}
