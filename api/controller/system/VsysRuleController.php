<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/vsys-rule 获取虚拟系统相关的最大支持规格信息
 * @apiName 获取虚拟系统最大规格
 * @apiGroup 系统设置
 *
 * @apiSuccess {Number} vsysSecDomainMaxNumber  虚拟系统安全域最大可配置规格
 * @apiSuccess {Number} vsysCTFlowMaxNumber  虚拟系统连接数量最大可配置规格
 * @apiSuccess {Number} vsysPolicyMaxNumber  虚拟系统策略数量最大可配置规格
 * @apiSuccess {Number} vsysAddrPoolMaxNumber  虚拟系统地址池最大可配置规格
 * @apiSuccess {Number} vsysObjectMaxNumber  虚拟系统对象最大可配置规格
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	data: [{"vsysSecDomainMaxNumber": "128", "vsysCTFlowMaxNumber": "30000", "vsysPolicyMaxNumber": "128", "vsysAddrPoolMaxNumber": "128", "vsysObjectMaxNumber": "128"}]
 *	 "total": 1
 *	}
 */
class VsysRuleController extends mController{	
	public $module = 'vsys_spec_get_info';
}
