<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/ips-rule 获取入侵防护策略
 * @apiName ips-rule
 * @apiGroup 获取防护策略
 *
 *
 * @apiSuccess {String} name 策略名称
 * @apiSuccess {String} src_zone 入接口
 * @apiSuccess {String} dst_zone 出接口
 * @apiSuccess {String} src 源地址
 * @apiSuccess {String} dst 目的地址
 * @apiSuccess {String} set 事件集
 * @apiSuccess {Number} id 策略ID
 * @apiSuccess {Number} enable 启用状态
 * @apiSuccess {Number} log 是否记录日志
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"src_zone": "any",
 *			"dst_zone": "any",
 *			"src": "any",
 *			"dst": "any",
 *			"set": "All",
 *			"id": "1",
 *			"enable": "1",
 *			"log": "1"
 *		},
 *		{
 *			"name": "test1",
 *			"src_zone": "any",
 *			"dst_zone": "ge0/0",
 *			"src": "any",
 *			"dst": "any",
 *			"set": "All",
 *			"id": "2",
 *			"enable": "1",
 *			"log": "1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/ips-rule 添加入侵防护策略
 * @apiName ips-rule
 * @apiGroup 添加防护策略
 *
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 移动参考目标策略id
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "All",
 *		"id": "1",
 *		"refer_id": "0",
 *		"enable": "1",
 *		"log": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/ips-rule 修改入侵防护策略
 * @apiName ips-rule
 * @apiGroup 修改防护策略
 *
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 引用计数，固定为0
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "Common",
 *		"id": "1",
 *		"refer_id": "0",
 *		"enable": "1",
 *		"log": "1"
 *	}
 *
 * @apiParam {String} name 策略名称
 * @apiParam {String} src_zone 入接口
 * @apiParam {String} dst_zone 出接口
 * @apiParam {String} src 源地址
 * @apiParam {String} dst 目的地址
 * @apiParam {String} set 事件集
 * @apiParam {Number} id 策略ID
 * @apiParam {Number} refer_id 引用计数，固定为0
 * @apiParam {Number} move_type 策略移动类型
 * @apiParam {Number} enable 启用状态
 * @apiParam {Number} log 是否记录日志
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"src_zone": "any",
 *		"dst_zone": "any",
 *		"src": "any",
 *		"dst": "any",
 *		"set": "Common",
 *		"id": "1",
 *		"refer_id": "1",
 *		"move_type": "3",
 *		"enable": "1",
 *		"log": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/ips-rule 删除入侵防护策略
 * @apiName ips-rule
 * @apiGroup 删除防护策略
 *
 *
 * @apiParam {Number} id 策略id
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */


class IpsCustomImportController extends mController{
	public $module = 'ips_sig_custom_import';
	public $in_file = '/tmp/custom_ips_sig_in.xml';
	public $out_file = '/tmp/custom_ips_sig_out.xml';

	function get(){
		$params=get_inputs();
		$readBuffer = 1024;
		$rspString = getResponse($this->module, "show_one" ,$params);
		$ret = getAssign($rspString, $this->module);

		if ($ret['code']==0) {
			header('Content-Type: application/octet-stream');
		    //声明浏览器返回大小是按字节进行计算
		    header('Accept-Ranges:bytes');
		    //告诉浏览器文件的总大小
		    $fileSize = filesize($this->out_file);//坑 filesize 如果超过2G 低版本php会返回负数
		    header('Content-Length:' . $fileSize); //注意是'Content-Length:' 非Accept-Length
		    //声明下载文件的名称
		    header('Content-Disposition:attachment;filename=' . basename($this->out_file));//声明作为附件处理和下载后文件的名称
		    //获取文件内容
		    $handle = fopen($this->out_file, 'rb');//二进制文件用‘rb’模式读取
		    while (!feof($handle) ) { //循环到文件末尾 规定每次读取（向浏览器输出为$readBuffer设置的字节数）
		        echo fread($handle, $readBuffer);
		    }
		    fclose($handle);//关闭文件句柄
		    // $rspString = getResponse($this->module, "show_one" ,$params);
		    exit;
		}else{
			//$ret = array('code'=>'-1111','str' => t('cert.not_exist'));
			echo json_encode($ret);
		}
		
	}

	function post(){
		$updatefile = $_FILES['file'];

        if (0 == $updatefile['size']) {
            $ret = array('code'=>'-1','str'=>t('update.file_empty'));
            echo json_encode($ret);
            exit(0);
        } else {
            if (UPLOAD_ERR_OK == $updatefile['error']) {
                $tmp_dir = $updatefile['tmp_name'];
                $dirs = explode('/', $tmp_dir);
                $dir = $this->in_file;
                move_uploaded_file($updatefile['tmp_name'], $dir);
                $rspString = getResponse($this->module, "add" ,$params);
                $ret = getAssign($rspString, $this->module, false, true);
                if($ret['code'] != 0){
                    $res = array('code'=>'-1','str'=> t('update.import_failed'));
                    echo json_encode($res);
                }else{
					echo "ok";
                }
            }else{
                $ret = array('code'=>'-50000','str'=>t('update.update_error_50000'));
                echo json_encode($ret);
            }
        }

	}
}

?>
