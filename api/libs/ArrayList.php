<?php
namespace lib;
use ArrayObject;
use lib\ArrayMap;

class ArrayList extends ArrayObject {

	/**
	 * 判断两个list是否一样
	 */
	function equals($other) {
		if (!($other instanceof ArrayList))
			return false;
	
		if (count($this) != count($other))
			return false;

		foreach ($this as $k => $v) {
			if (($v instanceof ArrayMap) 
			|| ($v instanceof ArrayList)) {
				if (!$v->equals($other[$k]))
					return false;
			} else {
				if ($v !== $other[$k])
					return false;
			}
		}
		
		return true;
	}

	/**
	 * 无法实现，禁止使用
	 */
	private function __clone() {
	}
	
	function copy() {
		$n = new ArrayList();
		foreach ($this as $k => $v) {
			if (($v instanceof ArrayMap) 
			|| ($v instanceof ArrayList)) {
				$n[$k] = $v->copy();
			} else {
				$n[$k] = $v;
			}
		}
		return $n;
	}
}
