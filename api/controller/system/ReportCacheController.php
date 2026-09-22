<?php
namespace controller\system;
use database\ReportCache;

Class ReportCacheController {
    function get() {
        // ini_set('display_errors', 'On');
        // ini_set("error_reporting", E_ALL);

        if (file_exists('/mnt1/mysql/') && file_exists('/mnt/boot/report_file.json')) {
            $obj = new ReportCache();
            $obj->run();

            unset($obj);
        }
    }
}
