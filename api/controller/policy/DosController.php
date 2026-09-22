<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/dos 获取DOS防护策略
 * @apiName dos
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {Number} jolt2 防DOS攻击
 * @apiSuccess {Number} smurf 防DOS攻击
 * @apiSuccess {Number} land_base 防DOS攻击
 * @apiSuccess {Number} ping_of_death 防DOS攻击
 * @apiSuccess {Number} syn_flag 防DOS攻击
 * @apiSuccess {Number} tear_drop 防DOS攻击
 * @apiSuccess {Number} winnuke 防DOS攻击
 * @apiSuccess {Number} ip_spoof 防DOS攻击
 * @apiSuccess {Number} tcp_scan TCP协议扫描
 * @apiSuccess {Number} udp_scan UDP协议扫描
 * @apiSuccess {Number} ping_scan PING扫描
 * @apiSuccess {Number} scan_threshold 扫描识别阈值
 * @apiSuccess {Number} flood_enable 启用ipv4防Flood攻击
 * @apiSuccess {Array} item 指定保护主机的IP地址对象信息:"startIP" 起始IP  "endIP" 结束IP,
 * @apiSuccess {Number} tcp_flood_threshold TCP Flood识别阈值
 * @apiSuccess {Number} udp_flood_threshold UDP Flood阈值
 * @apiSuccess {Number} icmp_flood_threshold ICMP Flood阈值
 * @apiSuccess {Number} dns_flood_threshold DNS Flood阈值
 * @apiSuccess {Number} http_flood_threshold HTTP Flood阈值
 * @apiSuccess {Number} flood_enable_v6 启用ipv6防Flood攻击
 * @apiSuccess {String} start_ip_v6 指定保护主机的起始ipv6地址
 * @apiSuccess {String} end_ip_v6 指定保护主机的结束ipv6地址
 * @apiSuccess {Number} udp_flood_threshold_v6 UDP Flood阈值
 * @apiSuccess {Number} icmp_flood_threshold_v6 ICMP Flood阈值
 * @apiSuccess {Number} dns_flood_threshold_v6 DNS Flood阈值
 * @apiSuccess {Number} http_flood_threshold_v6 HTTP Flood阈值
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"jolt2": "1",
 *			"smurf": "0",
 *			"arp_attack": "0",
 *			"arp_block_time": "60",
 *			"arp_threshold": "300",
 *			"tcp_scan": "1",
 *			"scan_block_time_enable": "1",
 *			"scan_block_time": "20",
 *			"scan_threshold_enable": "0",
 *			"scan_threshold": "0",
 *			"flood_enable": "1",
 *			"item":{"group":[{"startIP":"3.3.3.3","endIP":"3.3.3.31"},{"startIP":"10.1.1.1","endIP":"10.1.1.10"}]},
 *			"tcp_flood": "0",
 *			"tcp_flood_threshold": "10000",
 *			"udp_flood": "1",
 *			"udp_flood_threshold": "10000",
 *			"icmp_flood": "0",
 *			"icmp_flood_threshold": "10000",
 *			"dns_flood": "0",
 *			"dns_flood_threshold": "10000",
 *			"http_flood": "0",
 *			"http_flood_threshold": "10000",
 *			"flood_enable_v6": "0",
 *			"start_ip_v6": "::",
 *			"end_ip_v6": "::",
 *			"tcp_flood_v6": "0",
 *			"tcp_flood_threshold_v6": "10000",
 *			"udp_flood_v6": "0",
 *			"udp_flood_threshold_v6": "10000",
 *			"icmp_flood_v6": "0",
 *			"icmp_flood_threshold_v6": "10000",
 *			"dns_flood_v6": "0",
 *			"dns_flood_threshold_v6": "10000",
 *			"http_flood_v6": "0",
 *			"http_flood_threshold_v6": "10000"
 *		}
 *	],
 *	}
 */

/**
 * @api {PUT}  /api/dos 修改DOS防护策略
 * @apiName dos
 * @apiGroup 防护策略
 *
 *
 * @apiParam {Number} jolt2 防DOS攻击
 * @apiParam {Number} smurf 防DOS攻击
 * @apiParam {Number} land_base 防DOS攻击
 * @apiParam {Number} ping_of_death 防DOS攻击
 * @apiParam {Number} syn_flag 防DOS攻击
 * @apiParam {Number} tear_drop 防DOS攻击
 * @apiParam {Number} winnuke 防DOS攻击
 * @apiParam {Number} ip_spoof 防DOS攻击
 * @apiParam {Number} arp_attack 防DOS攻击
 * @apiParam {Number} arp_block_time 防DOS攻击
 * @apiParam {Number} arp_threshold 防DOS攻击
 * @apiParam {Number} sys_cookie_enable 防DOS攻击
 * @apiParam {Number} tcp_half 防DOS攻击
 * @apiParam {Number} tcp_scan TCP协议扫描
 * @apiParam {Number} udp_scan UDP协议扫描
 * @apiParam {Number} ping_scan PING扫描
 * @apiParam {Number} scan_block_time_enable 防扫描
 * @apiParam {Number} scan_block_time 防扫描
 * @apiParam {Number} scan_threshold_enable 防扫描
 * @apiParam {Number} scan_threshold 扫描识别阈值 
 * @apiParam {Number} flood_enable 启用
 * @apiParam {Array} item 指定保护主机的IP地址对象信息:"startIP" 起始IP  "endIP" 结束IP,
 * @apiParam {String} tcp_flood_threshold TCP Flood识别阈值
 * @apiParam {Number} udp_flood_threshold UDP Flood阈值
 * @apiParam {Number} icmp_flood_threshold ICMP Flood阈值
 * @apiParam {Number} dns_flood_threshold DNS Flood阈值
 * @apiParam {Number} http_flood_threshold HTTP Flood阈值
 * @apiParam {Number} flood_enable_v6 启用ipv6防Flood攻击
 * @apiParam {String} start_ip_v6 指定保护主机的起始ipv6地址
 * @apiParam {String} end_ip_v6 指定保护主机的结束ipv6地址
 * @apiParam {Number} udp_flood_threshold_v6 UDP Flood阈值
 * @apiParam {Number} icmp_flood_threshold_v6 ICMP Flood阈值
 * @apiParam {Number} dns_flood_threshold_v6 DNS Flood阈值
 * @apiParam {Number} http_flood_threshold_v6 HTTP Flood阈值
 *

 * @apiParamExample {json} Request-Example:
 *	{ 
 *			"jolt2": "1",
 *			"smurf": "0",
 *			"land_base": "0",
 *			"ping_of_death": "0",
 *			"syn_flag": "0",
 *			"tear_drop": "0",
 *			"winnuke": "0",
 *			"ip_spoof": "0",
 *			"arp_attack": "0",
 *			"arp_block_time": "60",
 *			"arp_threshold": "300",
 *			"sys_cookie_enable": "0",
 *			"tcp_half": "300",
 *			"tcp_scan": "1",
 *			"udp_scan": "0",
 *			"ping_scan": "0",
 *			"scan_block_time_enable": "1",
 *			"scan_block_time": "20",
 *			"scan_threshold_enable": "0",
 *			"scan_threshold": "100",
 *			"flood_enable": "1",
 *			"item": [{"startIP":"1.1.1.1", "endIP":"1.1.1.2"}],
 *			"tcp_flood": "0",
 *			"tcp_flood_threshold": "10000",
 *			"udp_flood": "1",
 *			"udp_flood_threshold": "10000",
 *			"icmp_flood": "0",
 *			"icmp_flood_threshold": "10000",
 *			"dns_flood": "0",
 *			"dns_flood_threshold": "10000",
 *			"http_flood": "0",
 *			"http_flood_threshold": "10000",
 *			"flood_enable_v6": "0",
 *			"start_ip_v6": "::",
 *			"end_ip_v6": "::",
 *			"tcp_flood_v6": "0",
 *			"tcp_flood_threshold_v6": "10000",
 *			"udp_flood_v6": "0",
 *			"udp_flood_threshold_v6": "10000",
 *			"icmp_flood_v6": "0",
 *			"icmp_flood_threshold_v6": "10000",
 *			"dns_flood_v6": "0",
 *			"dns_flood_threshold_v6": "10000",
 *			"http_flood_v6": "0",
 *			"http_flood_threshold_v6": "10000"
 *	}
 *
 *
 * @apiSuccess {Number} jolt2 防DOS攻击
 * @apiSuccess {Number} smurf 防DOS攻击
 * @apiSuccess {Number} land_base 防DOS攻击
 * @apiSuccess {Number} ping_of_death 防DOS攻击
 * @apiSuccess {Number} syn_flag 防DOS攻击
 * @apiSuccess {Number} tear_drop 防DOS攻击
 * @apiSuccess {Number} winnuke 防DOS攻击
 * @apiSuccess {Number} ip_spoof 防DOS攻击
 * @apiSuccess {Number} tcp_scan TCP协议扫描
 * @apiSuccess {Number} udp_scan UDP协议扫描
 * @apiSuccess {Number} ping_scan PING扫描
 * @apiSuccess {Number} scan_threshold 扫描识别阈值
 * @apiSuccess {Number} flood_enable 启用ipv4防Flood攻击
 * @apiSuccess {String} start_ip 指定保护主机的起始IP地址
 * @apiSuccess {String} end_ip 指定保护主机的结束IP地址
 * @apiSuccess {Number} tcp_flood_threshold TCP Flood识别阈值
 * @apiSuccess {Number} udp_flood_threshold UDP Flood阈值
 * @apiSuccess {Number} icmp_flood_threshold ICMP Flood阈值
 * @apiSuccess {Number} dns_flood_threshold DNS Flood阈值
 * @apiSuccess {Number} http_flood_threshold HTTP Flood阈值
 * @apiSuccess {Number} flood_enable_v6 启用ipv6防Flood攻击
 * @apiSuccess {String} start_ip_v6 指定保护主机的起始ipv6地址
 * @apiSuccess {String} end_ip_v6 指定保护主机的结束ipv6地址
 * @apiSuccess {Number} udp_flood_threshold_v6 UDP Flood阈值
 * @apiSuccess {Number} icmp_flood_threshold_v6 ICMP Flood阈值
 * @apiSuccess {Number} dns_flood_threshold_v6 DNS Flood阈值
 * @apiSuccess {Number} http_flood_threshold_v6 HTTP Flood阈值
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"land_base": "1",
 *			"tear_drop": "0",
 *			"arp_attack": "0",
 *			"arp_block_time": "60",
 *			"arp_threshold": "300",
 *			"tcp_scan": "1", 
 *			"scan_block_time_enable": "1",
 *			"scan_block_time": "20",
 *			"scan_threshold_enable": "0",
 *			"scan_threshold": "100",
 *			"flood_enable": "1",
 *			"item":{"group":[{"startIP":"3.3.3.3","endIP":"3.3.3.31"},{"startIP":"10.1.1.1","endIP":"10.1.1.10"}]},
 *			"tcp_flood": "0",
 *			"tcp_flood_threshold": "10000",
 *			"udp_flood": "1",
 *			"udp_flood_threshold": "10000",
 *			"icmp_flood": "0",
 *			"icmp_flood_threshold": "10000",
 *			"dns_flood": "0",
 *			"dns_flood_threshold": "10000",
 *			"http_flood": "0",
 *			"http_flood_threshold": "10000",
 *			"flood_enable_v6": "0",
 *			"start_ip_v6": "::",
 *			"end_ip_v6": "::",
 *			"tcp_flood_v6": "0",
 *			"tcp_flood_threshold_v6": "10000",
 *			"udp_flood_v6": "0",
 *			"udp_flood_threshold_v6": "10000",
 *			"icmp_flood_v6": "0",
 *			"icmp_flood_threshold_v6": "10000",
 *			"dns_flood_v6": "0",
 *			"dns_flood_threshold_v6": "10000",
 *			"http_flood_v6": "0",
 *			"http_flood_threshold_v6": "10000"
 *		}
 *	],
 *	}
 *
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


class DosController extends mController {
	public $module = 'anti_attack';
}

?>
