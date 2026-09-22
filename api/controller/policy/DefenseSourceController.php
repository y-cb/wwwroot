<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/defense-source 获取威胁情报库来源
 * @apiName defense-source
 * @apiGroup 威胁情报
 *
 *
 * @apiSuccess {String} source 威胁情报库来源
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    	"source": "local_coo_def,source1,source2"
    }
 */

class DefenseSourceController extends mController{
	public $module = 'coo_def_source';
}

?>
