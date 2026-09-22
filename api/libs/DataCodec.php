<?php
namespace lib;
use DOMElement;
use DOMText;
use DOMDocument;
use lib\ArrayMap;
use lib\ArrayList;


class DataCodec{

	function toelement(&$parent, &$data) {
		if (is_null($data))
			return;

		if ($data instanceof ArrayMap) {
			foreach($data as $key => $value) {
				$ele = new DOMElement($key);
				$parent->appendChild($ele);
				
				self::toelement($ele, $value);
			}
		} else if ($data instanceof ArrayList) {
			foreach($data as $value) {
				$ele = new DOMElement("group");
				$parent->appendChild($ele);
				
				self::toelement($ele, $value);
			}
		} else {
			if(empty($data)&&$data!=0){return;}
			$ele = new DOMText($data);
			$parent->appendChild($ele);
		}
	}

	/**
	 * 从XML节点生成数据节点
	 */
	function fromelement(&$parent, $data) {
		if ($data instanceof ArrayMap) {
			$child = $parent->firstChild;
			$childList = new ArrayList();

			while ($child) {
				 if (XML_ELEMENT_NODE == $child->nodeType) {
					self::fromelement($child, $childList);
				 }
				$child = $child->nextSibling;
			}
			if (count($childList)) {
				$data[$parent->nodeName] = $childList;
			}
		} else if ($data instanceof ArrayList) {
			$child = $parent->firstChild;
			$childMap = new ArrayMap();
			
			while ($child) {
				if (XML_ELEMENT_NODE == $child->nodeType) {
					if ($child->firstChild && XML_TEXT_NODE == $child->firstChild->nodeType) {
						$childMap[$child->nodeName] = $child->firstChild->nodeValue;
					} else {
						self::fromelement($child, $childMap);
					}
				}
				$child = $child->nextSibling;
			}
			if (count($childMap)) {
				$data[] = $childMap;
			}
		}
	}

	/**
	 * 把业务数据结构转换成XML字符串
	 */
	function todom(&$input, $optype) {

		$dom = new DOMDocument('1.0', 'utf-8');
		self::toelement($dom, $input);
		
		//在根节点中增加action属性
		$root = $dom->documentElement;
		$root->setAttribute('action', $optype);

		$dom->normalize();
		$xml = $dom->saveXML();
		
		return $xml;
	}

	/**
	 * 从XML字符串生成业务数据结构
	 */
	function fromdom($dom) {
		if (is_null($dom))
			return NULL;

		$doms = new DOMDocument();
		$doms->preserveWhiteSpace = false;
		$result = $doms->loadXML($dom);
		if ($result == false) {
			return NULL;
		}

		$doms->normalize();
		$data = new ArrayMap();
		self::fromelement($doms->documentElement, $data);

		return $data;
	}

}