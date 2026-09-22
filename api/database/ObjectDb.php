<?php
namespace database;
use database\Medoo;
use PDO;
class ObjectDb{
	public $database;
	public $path;
	function getDb(){
		return new Medoo([
			// 必填
			'database_type' => 'sqlite',
			'database_name' => 'obj_show',
			'database_file' => $this->path,
		 
			// 连接参数可参考官方手册： http://www.php.net/manual/en/pdo.setattribute.php
			'option' => [
				PDO::ATTR_CASE => PDO::CASE_NATURAL
			]
		]);
	}

	function __construct(){
		$this->path = '/tmp/obj_show.db';
	}
	
	function org_select($module,$col, $where=array())
	{

		$this->database = self::getDb();
		$data = $this->database->select($module, $col, $where);
		return $data;
	}
	function org_query($sql)
	{

		$this->database = self::getDb();
		$data = $this->database-> query($sql) -> fetch();
		return $data;
	}
}

?>
