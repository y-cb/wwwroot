<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/nbc-tmview 显示所有线路和子通道
 * @apiName 显示所有线路和子通道
 * @apiGroup 流控策略
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *      {"egress_max": "102400", 
 * 		 "ingress_enable": "1", 
 *		 "ingress_guaran_true": "102400", 
 *		 "name": "AAAAA", 
 *		 "ingress_guaran": "102400", 
 *		 "level": "1", 
 * 		 "egress_enable": "1", 
 *		 "ingress_bps": "0", 
 *		 "priority": "L", 
 *		 "ingress_max": "102400", 
 *		 "enable": "1", 
 *		 "egress_guaran": "102400", 
 *		 "egress_bps": "0", 
 * 		 "children_num": "2", 
 *		 "egress_guaran_true": "102400"
 *		}, 
 * 		{"egress_max": "102400", 
 *		 "ingress_enable": "1", 
 *		 "ingress_guaran_true": "85333", 
 *		 "name": "aaa", 
 * 		 "ingress_guaran": "102400", 
 *		 "level": "2", 
 *		 "egress_enable": "0", 
 *		 "ingress_bps": "0", 
 *		 "priority": "H+", 
 *		 "ingress_max": "102400", 
 *		 "enable": "1", 
 * 		 "egress_guaran": "102400", 
 *	   	 "egress_bps": "0", 
 *	  	 "children_num": "0", 
 *		 "egress_guaran_true": "85333"
 *		}, 
 *		{"egress_max": "102400", 
 *		 "ingress_enable": "1", 
 * 		 "ingress_guaran_true": "17067", 
 *		 "name": "def_AAAAA", 
 *		 "ingress_guaran": "20480", 
 *		 "level": "2", 
 *		 "egress_enable": "0", 
 *		 "ingress_bps": "0", 
 *		 "priority": "L", 
 * 		 "ingress_max": "102400", 
 *		 "enable": "1", 
 *		 "egress_guaran": "20480", 
 *		 "egress_bps": "0", 
 *		 "children_num": "0", 
 *		 "egress_guaran_true": "17067"
 *		}]
 *	"total": 3
 *	}
 */



class NbcTmViewController extends mController {
	public $module = 'nbc_tm_policy_view';
}