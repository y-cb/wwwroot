<?php
namespace lib;
use database\MysqlDb;

class AuditlogSession{
	function create_searcher($start, $end)
	{
		$cur = time();
		$num = 0;

		$tz = timezone_open(date_default_timezone_get());
		$dateTimeOslo = date_create("now",timezone_open("Europe/Oslo"));
		$tz_offset = timezone_offset_get($tz,$dateTimeOslo);

		if ($end - $start > 30 * 24 * 60 * 60) {
			$delta = 24 * 60 * 60;
		} else if ($end - $start > 15 * 24 * 60 * 60) {
			$delta = 12 * 60 * 60;
		} else if ($end - $start > 7 * 24 * 60 * 60) {
			$delta = 3 * 60 * 60;
		} else if ($end - $start > 3 * 24 * 60 * 60) {
			$delta = 2 * 60 * 60;
		} else if ($end - $start > 1 * 24 * 60 * 60) {
			/* 一小一天的情况,以一小时为单位进行展示 */
			$delta = 1 * 60 * 60;
		} else if ($end - $start > 12 * 60 * 60) {
			$delta = 60 * 30;
		} else if ($end - $start  > 6 * 60 * 60) {
			$delta = 60 * 15;
		} else if ($end - $start > 3 * 60 * 60) {
			$delta = 60 * 5;
		} else if ($end - $start > 60 * 60) {
			$delta = 60;
		} else if ($end - $start > 30 * 60) {
			$delta = 30;
		} else if ($end - $start > 10 * 60) {
			$delta = 20;
		} else if ($end - $start > 5 * 60) {
			$delta = 10;
		} else if ($end - $start > 2 * 60) {
			$delta = 5;
		} else {
			$delta = 1;
		}

		$ret_data['cursor_time'] = $start;
		$ret_data['is_time_cursored'] = false;

		if (MysqlDb::is_same_day($start, $end)) {
			$first_delta = ($end + $tz_offset) % $delta;
			$ret_data['cross_day'] = 0;
		} else {
			$date = localtime($end, true);
			/* 确保查询的时间段中，不会出现跨天的情况 */
			$first_delta = ($date['tm_hour'] * 60 * 60 + $date['tm_min'] * 60 + $date['tm_sec']) % $delta;
			$ret_data['cross_day'] = 1;
		}

		if ($first_delta == 0) {
			$first_delta = $delta;
		}

		$t_s = $end - $first_delta;
		$t_e = $end;

		while ($t_e > $t_s && $t_s >= $start) {
			$count = 0;

			$ret_data['buckets'][$num]['total_count'] = $count;
			$ret_data['buckets'][$num]['available_count'] = $count;
			$ret_data['buckets'][$num]['is_finalized'] = false;
			$ret_data['buckets'][$num]['duration'] = $t_e - $t_s;
			$ret_data['buckets'][$num]['earliest_strftime'] = date(DATE_ATOM, $t_s);
			$ret_data['buckets'][$num]['earliest_time'] = $t_s;
			$ret_data['buckets'][$num]['earliest_time_offset'] = $tz_offset;
			$ret_data['buckets'][$num]['latest_time_offset'] = $tz_offset;

			$total += $count;
			$num++;

			$t_e = $t_s;
			if ($t_s - $delta > $start) {
				$t_s -= $delta;
			} else {
				$t_s = $start;
			}
		}
		$ret_data['buckets'] = array_reverse($ret_data['buckets']);
		$ret_data['event_count'] = 0;
		return $ret_data;
	}

	function get_searcher($module, $start, $end, $sid, $where)
	{
		$ret;

		if ($_SESSION['scache_time'] === $start 
			&& $module === $_SESSION['scache_module'] 
			&& count($where) === count($_SESSION['scache_find']) 
			&& $_SESSION['scache_expire'] > time()) {
		    $diff = array_diff($where, $_SESSION['scache_find']);

		    if (empty($diff)) {
	                return $_SESSION['scache'];
	            }
	        }


		if ($_SESSION['search_id'] == $sid) {
			return $_SESSION['scache'];
		}

		if (!isset($sid)) {
			$sid = time();
		}

		unset($_SESSION['scache']);
		unset($_SESSION['scache_items']);
		$ret = self::create_searcher($start, $end);
		$_SESSION['scache'] = $ret;
		$_SESSION['search_id'] = $sid;
		return $ret;
	}

	function get_query_param($get_input)
	{
//		$vars = ['username', 'srcip', 'dstip', 'category', 'host', 'account', 'appname', 'appaction', 'action','ioctype','risk','level','threattype','daemon','sip','dip'];
        $vars = ['username', 'srcip', 'dstip', 'category', 'host', 'account', 'appname', 'appaction', 'action','ioctype','risk','level', 'threattype','daemon','sip','dip','time','Proto','result','defense_query_str','srcport','dstport','fwpolicyid'];
        $vars2 = ['url', 'title', 'content', 'subject', 'filename', 'sender', 'receiver', 'eventname', 'virusname', 'virusfilename','object'];
		foreach ($vars as $key => $val) {
			if (isset($get_input[$val]) && $get_input[$val] != '') {
				$param[$val] = $get_input[$val];
			}
		}

		foreach ($vars2 as $key => $val) {
			if (isset($get_input[$val]) && $_GET[$val] != '') {
				$param[$val.'[~]'] = $get_input[$val];
			}
		}
		return $param;
	}
}
