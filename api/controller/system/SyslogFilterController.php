<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/syslog-filter 获取日志过滤配置
 * @apiName syslog-filter
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {Number} ddos_memory_enable DDOS日志本地存储使能状态
 * @apiSuccess {Number} ddos_memory_level DDOS日志本地存储级别
 * @apiSuccess {Number} ddos_syslog_enable DDOS日志Syslog存储使能状态
 * @apiSuccess {Number} ddos_syslog_level DDOS日志Syslog存储级别
 * @apiSuccess {Number} ddos_email_enable DDOS日志E-mail报警使能状态
 * @apiSuccess {Number} ddos_email_level DDOS日志E-mail报警级别
 * @apiSuccess {Number} ddos_phone_enable DDOS日志短信报警使能状态
 * @apiSuccess {Number} ddos_phone_level apt日志短信报警级别
 * @apiSuccess {Number} interface_memory_enable interface日志本地存储使能状态
 * @apiSuccess {Number} interface_memory_level interface日志本地存储级别
 * @apiSuccess {Number} interface_syslog_enable interface日志Syslog存储使能状态
 * @apiSuccess {Number} interface_syslog_level interface日志Syslog存储级别
 * @apiSuccess {Number} interface_email_enable interface日志E-mail报警使能状态
 * @apiSuccess {Number} interface_email_level interface日志E-mail报警级别
 * @apiSuccess {Number} interface_phone_enable interface日志短信报警使能状态
 * @apiSuccess {Number} interface_phone_level interface日志短信报警级别
 * @apiSuccess {Number} nat_memory_enable nat日志本地存储使能状态
 * @apiSuccess {Number} nat_memory_level nat日志本地存储级别
 * @apiSuccess {Number} nat_syslog_enable nat日志Syslog存储使能状态
 * @apiSuccess {Number} nat_syslog_level nat日志Syslog存储级别
 * @apiSuccess {Number} nat_email_enable nat日志E-mail报警使能状态
 * @apiSuccess {Number} nat_email_level nat日志E-mail报警级别
 * @apiSuccess {Number} nat_phone_enable nat日志短信报警使能状态
 * @apiSuccess {Number} nat_phone_level nat日志短信报警级别
 * @apiSuccess {Number} ha_memory_enable ha日志本地存储使能状态
 * @apiSuccess {Number} ha_memory_level ha日志本地存储级别
 * @apiSuccess {Number} ha_syslog_enable ha日志Syslog存储使能状态
 * @apiSuccess {Number} ha_syslog_level ha日志Syslog存储级别
 * @apiSuccess {Number} ha_email_enable ha日志E-mail报警使能状态
 * @apiSuccess {Number} ha_email_level ha日志E-mail报警级别
 * @apiSuccess {Number} ha_phone_enable ha日志短信报警使能状态
 * @apiSuccess {Number} ha_phone_level ha日志短信报警级别
 * @apiSuccess {Number} system_memory_enable system日志本地存储使能状态
 * @apiSuccess {Number} system_memory_level system日志本地存储级别
 * @apiSuccess {Number} system_syslog_enable system日志Syslog存储使能状态
 * @apiSuccess {Number} system_syslog_level system日志Syslog存储级别
 * @apiSuccess {Number} system_email_enable system日志E-mail报警使能状态
 * @apiSuccess {Number} system_email_level system日志E-mail报警级别
 * @apiSuccess {Number} system_phone_enable system日志短信报警使能状态
 * @apiSuccess {Number} system_phone_level system日志短信报警级别
 * @apiSuccess {Number} ospf_memory_enable ospf日志本地存储使能状态
 * @apiSuccess {Number} ospf_memory_level ospf日志本地存储级别
 * @apiSuccess {Number} ospf_syslog_enable ospf日志Syslog存储使能状态
 * @apiSuccess {Number} ospf_syslog_level ospf日志Syslog存储级别
 * @apiSuccess {Number} ospf_email_enable ospf日志E-mail报警使能状态
 * @apiSuccess {Number} ospf_email_level ospf日志E-mail报警级别
 * @apiSuccess {Number} ospf_phone_enable ospf日志短信报警使能状态
 * @apiSuccess {Number} ospf_phone_level ospf日志短信报警级别
 * @apiSuccess {Number} rip_memory_enable rip日志本地存储使能状态
 * @apiSuccess {Number} rip_memory_level rip日志本地存储级别
 * @apiSuccess {Number} rip_syslog_enable rip日志Syslog存储使能状态
 * @apiSuccess {Number} rip_syslog_level rip日志Syslog存储级别
 * @apiSuccess {Number} rip_email_enable rip日志E-mail报警使能状态
 * @apiSuccess {Number} rip_email_level rip日志E-mail报警级别
 * @apiSuccess {Number} rip_phone_enable rip日志短信报警使能状态
 * @apiSuccess {Number} rip_phone_level rip日志短信报警级别
 * @apiSuccess {Number} qos_memory_enable qos日志本地存储使能状态
 * @apiSuccess {Number} qos_memory_level qos日志本地存储级别
 * @apiSuccess {Number} qos_syslog_enable qos日志Syslog存储使能状态
 * @apiSuccess {Number} qos_syslog_level qos日志Syslog存储级别
 * @apiSuccess {Number} qos_email_enable qos日志E-mail报警使能状态
 * @apiSuccess {Number} qos_email_level qos日志E-mail报警级别
 * @apiSuccess {Number} qos_phone_enable qos日志短信报警使能状态
 * @apiSuccess {Number} qos_phone_level qos日志短信报警级别
 * @apiSuccess {Number} bgp_memory_enable bgp日志本地存储使能状态
 * @apiSuccess {Number} bgp_memory_level bgp日志本地存储级别
 * @apiSuccess {Number} bgp_syslog_enable bgp日志Syslog存储使能状态
 * @apiSuccess {Number} bgp_syslog_level bgp日志Syslog存储级别
 * @apiSuccess {Number} bgp_email_enable bgp日志E-mail报警使能状态
 * @apiSuccess {Number} bgp_email_level bgp日志E-mail报警级别
 * @apiSuccess {Number} bgp_phone_enable bgp日志短信报警使能状态
 * @apiSuccess {Number} bgp_phone_level bgp日志短信报警级别
 * @apiSuccess {Number} scan_memory_enable scan日志本地存储使能状态
 * @apiSuccess {Number} scan_memory_level scan日志本地存储级别
 * @apiSuccess {Number} scan_syslog_enable scan日志Syslog存储使能状态
 * @apiSuccess {Number} scan_syslog_level scan日志Syslog存储级别
 * @apiSuccess {Number} scan_email_enable scan日志E-mail报警使能状态
 * @apiSuccess {Number} scan_email_level scan日志E-mail报警级别
 * @apiSuccess {Number} scan_phone_enable scan日志短信报警使能状态
 * @apiSuccess {Number} scan_phone_level scan日志短信报警级别
 * @apiSuccess {Number} filter_memory_enable filter日志本地存储使能状态
 * @apiSuccess {Number} filter_memory_level filter日志本地存储级别
 * @apiSuccess {Number} filter_syslog_enable filter日志Syslog存储使能状态
 * @apiSuccess {Number} filter_syslog_level filter日志Syslog存储级别
 * @apiSuccess {Number} filter_email_enable filter日志E-mail报警使能状态
 * @apiSuccess {Number} filter_email_level filter日志E-mail报警级别
 * @apiSuccess {Number} filter_phone_enable filter日志短信报警使能状态
 * @apiSuccess {Number} filter_phone_level filter日志短信报警级别
 * @apiSuccess {Number} ips_memory_enable ips日志本地存储使能状态
 * @apiSuccess {Number} ips_memory_level ips日志本地存储级别
 * @apiSuccess {Number} ips_syslog_enable ips日志Syslog存储使能状态
 * @apiSuccess {Number} ips_syslog_level ips日志Syslog存储级别
 * @apiSuccess {Number} ips_email_enable ips日志E-mail报警使能状态
 * @apiSuccess {Number} ips_email_level ips日志E-mail报警级别
 * @apiSuccess {Number} ips_phone_enable ips日志短信报警使能状态
 * @apiSuccess {Number} ips_phone_level ips日志短信报警级别
 * @apiSuccess {Number} av_memory_enable av日志本地存储使能状态
 * @apiSuccess {Number} av_memory_level av日志本地存储级别
 * @apiSuccess {Number} av_syslog_enable av日志Syslog存储使能状态
 * @apiSuccess {Number} av_syslog_level av日志Syslog存储级别
 * @apiSuccess {Number} av_email_enable av日志E-mail报警使能状态
 * @apiSuccess {Number} av_email_level av日志E-mail报警级别
 * @apiSuccess {Number} av_phone_enable av日志短信报警使能状态
 * @apiSuccess {Number} av_phone_level av日志短信报警级别
 * @apiSuccess {Number} ac_memory_enable ac日志本地存储使能状态
 * @apiSuccess {Number} ac_memory_level ac日志本地存储级别
 * @apiSuccess {Number} ac_syslog_enable ac日志Syslog存储使能状态
 * @apiSuccess {Number} ac_syslog_level ac日志Syslog存储级别
 * @apiSuccess {Number} ac_email_enable ac日志E-mail报警使能状态
 * @apiSuccess {Number} ac_email_level ac日志E-mail报警级别
 * @apiSuccess {Number} ac_phone_enable ac日志短信报警使能状态
 * @apiSuccess {Number} ac_phone_level ac日志短信报警级别
 * @apiSuccess {Number} instant_message_memory_enable instant_message日志本地存储使能状态
 * @apiSuccess {Number} instant_message_memory_level instant_message日志本地存储级别
 * @apiSuccess {Number} instant_message_syslog_enable instant_message日志Syslog存储使能状态
 * @apiSuccess {Number} instant_message_syslog_level instant_message日志Syslog存储级别
 * @apiSuccess {Number} instant_message_email_enable instant_message日志E-mail报警使能状态
 * @apiSuccess {Number} instant_message_email_level instant_message日志E-mail报警级别
 * @apiSuccess {Number} instant_message_phone_enable instant_message日志短信报警使能状态
 * @apiSuccess {Number} instant_message_phone_level instant_message日志短信报警级别
 * @apiSuccess {Number} search_engine_memory_enable search_engine日志本地存储使能状态
 * @apiSuccess {Number} search_engine_memory_level search_engine日志本地存储级别
 * @apiSuccess {Number} search_engine_syslog_enable search_engine日志Syslog存储使能状态
 * @apiSuccess {Number} search_engine_syslog_level search_engine日志Syslog存储级别
 * @apiSuccess {Number} search_engine_email_enable search_engine日志E-mail报警使能状态
 * @apiSuccess {Number} search_engine_email_level search_engine日志E-mail报警级别
 * @apiSuccess {Number} search_engine_phone_enable search_engine日志短信报警使能状态
 * @apiSuccess {Number} search_engine_phone_level search_engine日志短信报警级别
 * @apiSuccess {Number} social_network_memory_enable social_network日志本地存储使能状态
 * @apiSuccess {Number} social_network_memory_level social_network日志本地存储级别
 * @apiSuccess {Number} social_network_syslog_enable social_network日志Syslog存储使能状态
 * @apiSuccess {Number} social_network_syslog_level social_network日志Syslog存储级别
 * @apiSuccess {Number} social_network_email_enable social_network日志E-mail报警使能状态
 * @apiSuccess {Number} social_network_email_level social_network日志E-mail报警级别
 * @apiSuccess {Number} social_network_phone_enable social_network日志短信报警使能状态
 * @apiSuccess {Number} social_network_phone_level social_network日志短信报警级别
 * @apiSuccess {Number} email_memory_enable email日志本地存储使能状态
 * @apiSuccess {Number} email_memory_level email日志本地存储级别
 * @apiSuccess {Number} email_syslog_enable email日志Syslog存储使能状态
 * @apiSuccess {Number} email_syslog_level email日志Syslog存储级别
 * @apiSuccess {Number} email_email_enable email日志E-mail报警使能状态
 * @apiSuccess {Number} email_email_level email日志E-mail报警级别
 * @apiSuccess {Number} email_phone_enable email日志短信报警使能状态
 * @apiSuccess {Number} email_phone_level email日志短信报警级别
 * @apiSuccess {Number} file_transfer_memory_enable file_transfer日志本地存储使能状态
 * @apiSuccess {Number} file_transfer_memory_level file_transfer日志本地存储级别
 * @apiSuccess {Number} file_transfer_syslog_enable file_transfer日志Syslog存储使能状态
 * @apiSuccess {Number} file_transfer_syslog_level file_transfer日志Syslog存储级别
 * @apiSuccess {Number} file_transfer_email_enable file_transfer日志E-mail报警使能状态
 * @apiSuccess {Number} file_transfer_email_level file_transfer日志E-mail报警级别
 * @apiSuccess {Number} file_transfer_phone_enable file_transfer日志短信报警使能状态
 * @apiSuccess {Number} file_transfer_phone_level file_transfer日志短信报警级别
 * @apiSuccess {Number} online_shopping_memory_enable online_shopping日志本地存储使能状态
 * @apiSuccess {Number} online_shopping_memory_level online_shopping日志本地存储级别
 * @apiSuccess {Number} online_shopping_syslog_enable online_shopping日志Syslog存储使能状态
 * @apiSuccess {Number} online_shopping_syslog_level online_shopping日志Syslog存储级别
 * @apiSuccess {Number} online_shopping_email_enable online_shopping日志E-mail报警使能状态
 * @apiSuccess {Number} online_shopping_email_level online_shopping日志E-mail报警级别
 * @apiSuccess {Number} online_shopping_phone_enable online_shopping日志短信报警使能状态
 * @apiSuccess {Number} online_shopping_phone_level online_shopping日志短信报警级别
 * @apiSuccess {Number} app_others_memory_enable app_others日志本地存储使能状态
 * @apiSuccess {Number} app_others_memory_level app_others日志本地存储级别
 * @apiSuccess {Number} app_others_syslog_enable app_others日志Syslog存储使能状态
 * @apiSuccess {Number} app_others_syslog_level app_others日志Syslog存储级别
 * @apiSuccess {Number} app_others_email_enable app_others日志E-mail报警使能状态
 * @apiSuccess {Number} app_others_email_level app_others日志E-mail报警级别
 * @apiSuccess {Number} app_others_phone_enable app_others日志短信报警使能状态
 * @apiSuccess {Number} app_others_phone_level app_others日志短信报警级别
 * @apiSuccess {Number} web_access_memory_enable web_access日志本地存储使能状态
 * @apiSuccess {Number} web_access_memory_level web_access日志本地存储级别
 * @apiSuccess {Number} web_access_syslog_enable web_access日志Syslog存储使能状态
 * @apiSuccess {Number} web_access_syslog_level web_access日志Syslog存储级别
 * @apiSuccess {Number} web_access_email_enable web_access日志E-mail报警使能状态
 * @apiSuccess {Number} web_access_email_level web_access日志E-mail报警级别
 * @apiSuccess {Number} web_access_phone_enable web_access日志短信报警使能状态
 * @apiSuccess {Number} web_access_phone_level web_access日志短信报警级别
 * @apiSuccess {Number} persist_memory_enable persist日志本地存储使能状态
 * @apiSuccess {Number} persist_memory_level persist日志本地存储级别
 * @apiSuccess {Number} persist_syslog_enable persist日志Syslog存储使能状态
 * @apiSuccess {Number} persist_syslog_level persist日志Syslog存储级别
 * @apiSuccess {Number} persist_email_enable persist日志E-mail报警使能状态
 * @apiSuccess {Number} persist_email_level persist日志E-mail报警级别
 * @apiSuccess {Number} persist_phone_enable persist日志短信报警使能状态
 * @apiSuccess {Number} persist_phone_level persist日志短信报警级别
 * @apiSuccess {Number} httpswitch_memory_enable httpswitch日志本地存储使能状态
 * @apiSuccess {Number} httpswitch_memory_level httpswitch日志本地存储级别
 * @apiSuccess {Number} httpswitch_syslog_enable httpswitch日志Syslog存储使能状态
 * @apiSuccess {Number} httpswitch_syslog_level httpswitch日志Syslog存储级别
 * @apiSuccess {Number} httpswitch_email_enable httpswitch日志E-mail报警使能状态
 * @apiSuccess {Number} httpswitch_email_level httpswitch日志E-mail报警级别
 * @apiSuccess {Number} httpswitch_phone_enable httpswitch日志短信报警使能状态
 * @apiSuccess {Number} httpswitch_phone_level httpswitch日志短信报警级别
 * @apiSuccess {Number} httperrcode_memory_enable httperrcode日志本地存储使能状态
 * @apiSuccess {Number} httperrcode_memory_level httperrcode日志本地存储级别
 * @apiSuccess {Number} httperrcode_syslog_enable httperrcode日志Syslog存储使能状态
 * @apiSuccess {Number} httperrcode_syslog_level httperrcode日志Syslog存储级别
 * @apiSuccess {Number} httperrcode_email_enable httperrcode日志E-mail报警使能状态
 * @apiSuccess {Number} httperrcode_email_level httperrcode日志E-mail报警级别
 * @apiSuccess {Number} httperrcode_phone_enable httperrcode日志短信报警使能状态
 * @apiSuccess {Number} httperrcode_phone_level httperrcode日志短信报警级别
 * @apiSuccess {Number} httpcache_memory_enable httpcache日志本地存储使能状态
 * @apiSuccess {Number} httpcache_memory_level httpcache日志本地存储级别
 * @apiSuccess {Number} httpcache_syslog_enable httpcache日志Syslog存储使能状态
 * @apiSuccess {Number} httpcache_syslog_level httpcache日志Syslog存储级别
 * @apiSuccess {Number} httpcache_email_enable httpcache日志E-mail报警使能状态
 * @apiSuccess {Number} httpcache_email_level httpcache日志E-mail报警级别
 * @apiSuccess {Number} httpcache_phone_enable httpcache日志短信报警使能状态
 * @apiSuccess {Number} httpcache_phone_level httpcache日志短信报警级别
 * @apiSuccess {Number} sslaccelerate_memory_enable sslaccelerate日志本地存储使能状态
 * @apiSuccess {Number} sslaccelerate_memory_level sslaccelerate日志本地存储级别
 * @apiSuccess {Number} sslaccelerate_syslog_enable sslaccelerate日志Syslog存储使能状态
 * @apiSuccess {Number} sslaccelerate_syslog_level sslaccelerate日志Syslog存储级别
 * @apiSuccess {Number} sslaccelerate_email_enable sslaccelerate日志E-mail报警使能状态
 * @apiSuccess {Number} sslaccelerate_email_level sslaccelerate日志E-mail报警级别
 * @apiSuccess {Number} sslaccelerate_phone_enable sslaccelerate日志短信报警使能状态
 * @apiSuccess {Number} sslaccelerate_phone_level sslaccelerate日志短信报警级别
 * @apiSuccess {Number} httpcompress_memory_enable httpcompress日志本地存储使能状态
 * @apiSuccess {Number} httpcompress_memory_level httpcompress日志本地存储级别
 * @apiSuccess {Number} httpcompress_syslog_enable httpcompress日志Syslog存储使能状态
 * @apiSuccess {Number} httpcompress_syslog_level httpcompress日志Syslog存储级别
 * @apiSuccess {Number} httpcompress_email_enable httpcompress日志E-mail报警使能状态
 * @apiSuccess {Number} httpcompress_email_level httpcompress日志E-mail报警级别
 * @apiSuccess {Number} httpcompress_phone_enable httpcompress日志短信报警使能状态
 * @apiSuccess {Number} httpcompress_phone_level httpcompress日志短信报警级别
 * @apiSuccess {Number} httpfirewall_memory_enable httpfirewall日志本地存储使能状态
 * @apiSuccess {Number} httpfirewall_memory_level httpfirewall日志本地存储级别
 * @apiSuccess {Number} httpfirewall_syslog_enable httpfirewall日志Syslog存储使能状态
 * @apiSuccess {Number} httpfirewall_syslog_level httpfirewall日志Syslog存储级别
 * @apiSuccess {Number} httpfirewall_email_enable httpfirewall日志E-mail报警使能状态
 * @apiSuccess {Number} httpfirewall_email_level httpfirewall日志E-mail报警级别
 * @apiSuccess {Number} httpfirewall_phone_enable httpfirewall日志短信报警使能状态
 * @apiSuccess {Number} httpfirewall_phone_level httpfirewall日志短信报警级别
 * @apiSuccess {Number} httpcc_memory_enable httpcc日志本地存储使能状态
 * @apiSuccess {Number} httpcc_memory_level httpcc日志本地存储级别
 * @apiSuccess {Number} httpcc_syslog_enable httpcc日志Syslog存储使能状态
 * @apiSuccess {Number} httpcc_syslog_level httpcc日志Syslog存储级别
 * @apiSuccess {Number} httpcc_email_enable httpcc日志E-mail报警使能状态
 * @apiSuccess {Number} httpcc_email_level httpcc日志E-mail报警级别
 * @apiSuccess {Number} httpcc_phone_enable httpcc日志短信报警使能状态
 * @apiSuccess {Number} httpcc_phone_level httpcc日志短信报警级别
 * @apiSuccess {Number} oneconnect_memory_enable oneconnect日志本地存储使能状态
 * @apiSuccess {Number} oneconnect_memory_level oneconnect日志本地存储级别
 * @apiSuccess {Number} oneconnect_syslog_enable oneconnect日志Syslog存储使能状态
 * @apiSuccess {Number} oneconnect_syslog_level oneconnect日志Syslog存储级别
 * @apiSuccess {Number} oneconnect_email_enable oneconnect日志E-mail报警使能状态
 * @apiSuccess {Number} oneconnect_email_level oneconnect日志E-mail报警级别
 * @apiSuccess {Number} oneconnect_phone_enable oneconnect日志短信报警使能状态
 * @apiSuccess {Number} oneconnect_phone_level oneconnect日志短信报警级别
 * @apiSuccess {Number} hm_memory_enable hm日志本地存储使能状态
 * @apiSuccess {Number} hm_memory_level hm日志本地存储级别
 * @apiSuccess {Number} hm_syslog_enable hm日志Syslog存储使能状态
 * @apiSuccess {Number} hm_syslog_level hm日志Syslog存储级别
 * @apiSuccess {Number} hm_email_enable hm日志E-mail报警使能状态
 * @apiSuccess {Number} hm_email_level hm日志E-mail报警级别
 * @apiSuccess {Number} hm_phone_enable hm日志短信报警使能状态
 * @apiSuccess {Number} hm_phone_level hm日志短信报警级别
 * @apiSuccess {Number} vs_memory_enable vs日志本地存储使能状态
 * @apiSuccess {Number} vs_memory_level vs日志本地存储级别
 * @apiSuccess {Number} vs_syslog_enable vs日志Syslog存储使能状态
 * @apiSuccess {Number} vs_syslog_level vs日志Syslog存储级别
 * @apiSuccess {Number} vs_email_enable vs日志E-mail报警使能状态
 * @apiSuccess {Number} vs_email_level vs日志E-mail报警级别
 * @apiSuccess {Number} vs_phone_enable vs日志短信报警使能状态
 * @apiSuccess {Number} vs_phone_level vs日志短信报警级别
 * @apiSuccess {Number} vlink_memory_enable vlink日志本地存储使能状态
 * @apiSuccess {Number} vlink_memory_level vlink日志本地存储级别
 * @apiSuccess {Number} vlink_syslog_enable vlink日志Syslog存储使能状态
 * @apiSuccess {Number} vlink_syslog_level vlink日志Syslog存储级别
 * @apiSuccess {Number} vlink_email_enable vlink日志E-mail报警使能状态
 * @apiSuccess {Number} vlink_email_level vlink日志E-mail报警级别
 * @apiSuccess {Number} vlink_phone_enable vlink日志短信报警使能状态
 * @apiSuccess {Number} vlink_phone_level vlink日志短信报警级别
 * @apiSuccess {Number} lcin_memory_enable lcin日志本地存储使能状态
 * @apiSuccess {Number} lcin_memory_level lcin日志本地存储级别
 * @apiSuccess {Number} lcin_syslog_enable lcin日志Syslog存储使能状态
 * @apiSuccess {Number} lcin_syslog_level lcin日志Syslog存储级别
 * @apiSuccess {Number} lcin_email_enable lcin日志E-mail报警使能状态
 * @apiSuccess {Number} lcin_email_level lcin日志E-mail报警级别
 * @apiSuccess {Number} lcin_phone_enable lcin日志短信报警使能状态
 * @apiSuccess {Number} lcin_phone_level lcin日志短信报警级别
 * @apiSuccess {Number} gtm_memory_enable gtm日志本地存储使能状态
 * @apiSuccess {Number} gtm_memory_level gtm日志本地存储级别
 * @apiSuccess {Number} gtm_syslog_enable gtm日志Syslog存储使能状态
 * @apiSuccess {Number} gtm_syslog_level gtm日志Syslog存储级别
 * @apiSuccess {Number} gtm_email_enable gtm日志E-mail报警使能状态
 * @apiSuccess {Number} gtm_email_level gtm日志E-mail报警级别
 * @apiSuccess {Number} gtm_phone_enable gtm日志短信报警使能状态
 * @apiSuccess {Number} gtm_phone_level gtm日志短信报警级别
 * @apiSuccess {Number} dns_memory_enable dns日志本地存储使能状态
 * @apiSuccess {Number} dns_memory_level dns日志本地存储级别
 * @apiSuccess {Number} dns_syslog_enable dns日志Syslog存储使能状态
 * @apiSuccess {Number} dns_syslog_level dns日志Syslog存储级别
 * @apiSuccess {Number} dns_email_enable dns日志E-mail报警使能状态
 * @apiSuccess {Number} dns_email_level dns日志E-mail报警级别
 * @apiSuccess {Number} dns_phone_enable dns日志短信报警使能状态
 * @apiSuccess {Number} dns_phone_level dns日志短信报警级别
 * @apiSuccess {Number} httpxssql_memory_enable httpxssql日志本地存储使能状态
 * @apiSuccess {Number} httpxssql_memory_level httpxssql日志本地存储级别
 * @apiSuccess {Number} httpxssql_syslog_enable httpxssql日志Syslog存储使能状态
 * @apiSuccess {Number} httpxssql_syslog_level httpxssql日志Syslog存储级别
 * @apiSuccess {Number} httpxssql_email_enable httpxssql日志E-mail报警使能状态
 * @apiSuccess {Number} httpxssql_email_level httpxssql日志E-mail报警级别
 * @apiSuccess {Number} httpxssql_phone_enable httpxssql日志短信报警使能状态
 * @apiSuccess {Number} httpxssql_phone_level httpxssql日志短信报警级别
 * @apiSuccess {Number} linkthreshold_memory_enable linkthreshold日志本地存储使能状态
 * @apiSuccess {Number} linkthreshold_memory_level linkthreshold日志本地存储级别
 * @apiSuccess {Number} linkthreshold_syslog_enable linkthreshold日志Syslog存储使能状态
 * @apiSuccess {Number} linkthreshold_syslog_level linkthreshold日志Syslog存储级别
 * @apiSuccess {Number} linkthreshold_email_enable linkthreshold日志E-mail报警使能状态
 * @apiSuccess {Number} linkthreshold_email_level linkthreshold日志E-mail报警级别
 * @apiSuccess {Number} linkthreshold_phone_enable linkthreshold日志短信报警使能状态
 * @apiSuccess {Number} linkthreshold_phone_level linkthreshold日志短信报警级别
 * @apiSuccess {Number} dnsproxy_memory_enable dnsproxy日志本地存储使能状态
 * @apiSuccess {Number} dnsproxy_memory_level dnsproxy日志本地存储级别
 * @apiSuccess {Number} dnsproxy_syslog_enable dnsproxy日志Syslog存储使能状态
 * @apiSuccess {Number} dnsproxy_syslog_level dnsproxy日志Syslog存储级别
 * @apiSuccess {Number} dnsproxy_email_enable dnsproxy日志E-mail报警使能状态
 * @apiSuccess {Number} dnsproxy_email_level dnsproxy日志E-mail报警级别
 * @apiSuccess {Number} dnsproxy_phone_enable dnsproxy日志短信报警使能状态
 * @apiSuccess {Number} dnsproxy_phone_level dnsproxy日志短信报警级别
 * @apiSuccess {Number} vrrp_memory_enable vrrp日志本地存储使能状态
 * @apiSuccess {Number} vrrp_memory_level vrrp日志本地存储级别
 * @apiSuccess {Number} vrrp_syslog_enable vrrp日志Syslog存储使能状态
 * @apiSuccess {Number} vrrp_syslog_level vrrp日志Syslog存储级别
 * @apiSuccess {Number} vrrp_email_enable vrrp日志E-mail报警使能状态
 * @apiSuccess {Number} vrrp_email_level vrrp日志E-mail报警级别
 * @apiSuccess {Number} vrrp_phone_enable vrrp日志短信报警使能状态
 * @apiSuccess {Number} vrrp_phone_level vrrp日志短信报警级别
 * @apiSuccess {Number} httpredirect_memory_enable httpredirect日志本地存储使能状态
 * @apiSuccess {Number} httpredirect_memory_level httpredirect日志本地存储级别
 * @apiSuccess {Number} httpredirect_syslog_enable httpredirect日志Syslog存储使能状态
 * @apiSuccess {Number} httpredirect_syslog_level httpredirect日志Syslog存储级别
 * @apiSuccess {Number} httpredirect_email_enable httpredirect日志E-mail报警使能状态
 * @apiSuccess {Number} httpredirect_email_level httpredirect日志E-mail报警级别
 * @apiSuccess {Number} httpredirect_phone_enable httpredirect日志短信报警使能状态
 * @apiSuccess {Number} httpredirect_phone_level httpredirect日志短信报警级别
 * @apiSuccess {Number} flood_memory_enable flood日志本地存储使能状态
 * @apiSuccess {Number} flood_memory_level flood日志本地存储级别
 * @apiSuccess {Number} flood_syslog_enable flood日志Syslog存储使能状态
 * @apiSuccess {Number} flood_syslog_level flood日志Syslog存储级别
 * @apiSuccess {Number} flood_email_enable flood日志E-mail报警使能状态
 * @apiSuccess {Number} flood_email_level flood日志E-mail报警级别
 * @apiSuccess {Number} flood_phone_enable flood日志短信报警使能状态
 * @apiSuccess {Number} flood_phone_level flood日志短信报警级别
 * @apiSuccess {Number} apt_memory_enable apt日志本地存储使能状态
 * @apiSuccess {Number} apt_memory_level apt日志本地存储级别
 * @apiSuccess {Number} apt_syslog_enable apt日志Syslog存储使能状态
 * @apiSuccess {Number} apt_syslog_level apt日志Syslog存储级别
 * @apiSuccess {Number} apt_email_enable apt日志E-mail报警使能状态
 * @apiSuccess {Number} apt_email_level apt日志E-mail报警级别
 * @apiSuccess {Number} apt_phone_enable apt日志短信报警使能状态
 * @apiSuccess {Number} apt_phone_level apt日志短信报警级别
 * @apiSuccess {Number} defense_memory_enable defense日志本地存储使能状态
 * @apiSuccess {Number} defense_memory_level defense日志本地存储级别
 * @apiSuccess {Number} defense_syslog_enable defense日志Syslog存储使能状态
 * @apiSuccess {Number} defense_syslog_level defense日志Syslog存储级别
 * @apiSuccess {Number} defense_email_enable defense日志E-mail报警使能状态
 * @apiSuccess {Number} defense_email_level defense日志E-mail报警级别
 * @apiSuccess {Number} defense_phone_enable defense日志短信报警使能状态
 * @apiSuccess {Number} defense_phone_level defense日志短信报警级别
 * @apiSuccess {Number} config_memory_enable config日志本地存储使能状态
 * @apiSuccess {Number} config_memory_level config日志本地存储级别
 * @apiSuccess {Number} config_syslog_enable config日志Syslog存储使能状态
 * @apiSuccess {Number} config_syslog_level config日志Syslog存储级别
 * @apiSuccess {Number} config_email_enable config日志E-mail报警使能状态
 * @apiSuccess {Number} config_email_level config日志E-mail报警级别
 * @apiSuccess {Number} config_phone_enable config日志短信报警使能状态
 * @apiSuccess {Number} config_phone_level config日志短信报警级别
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 * 			"ddos_memory_enable": "1",
 * 			"ddos_memory_level": "1",
 * 			"ddos_syslog_enable": "1",
 * 			"ddos_syslog_level": "1",
 * 			"ddos_email_enable": "1",
 * 			"ddos_email_level": "1",
 * 			"ddos_phone_enable": "1",
 * 			"ddos_phone_level": "1",
 * 			"interface_memory_enable": "1",
 * 			"interface_memory_level": "1",
 * 			"interface_syslog_enable": "1",
 * 			"interface_syslog_level": "1",
 * 			"interface_email_enable": "1",
 * 			"interface_email_level": "1",
 * 			"interface_phone_enable": "1",
 * 			"interface_phone_level": "1",
 * 			"nat_memory_enable": "1",
 * 			"nat_memory_level": "1",
 * 			"nat_syslog_enable": "1",
 * 			"nat_syslog_level": "1",
 * 			"nat_email_enable": "1",
 * 			"nat_email_level": "1",
 * 			"nat_phone_enable": "1",
 * 			"nat_phone_level": "1",
 * 			"ha_memory_enable": "1",
 * 			"ha_memory_level": "1",
 * 			"ha_syslog_enable": "1",
 * 			"ha_syslog_level": "1",
 * 			"ha_email_enable": "1",
 * 			"ha_email_level": "1",
 * 			"ha_phone_enable": "1",
 * 			"ha_phone_level": "1",
 * 			"system_memory_enable": "1",
 * 			"system_memory_level": "1",
 * 			"system_syslog_enable": "1",
 * 			"system_syslog_level": "1",
 * 			"system_email_enable": "1",
 * 			"system_email_level": "1",
 * 			"system_phone_enable": "1",
 * 			"system_phone_level": "1",
 * 			"ospf_memory_enable": "1",
 * 			"ospf_memory_level": "1",
 * 			"ospf_syslog_enable": "1",
 * 			"ospf_syslog_level": "1",
 * 			"ospf_email_enable": "1",
 * 			"ospf_email_level": "1",
 * 			"ospf_phone_enable": "1",
 * 			"ospf_phone_level": "1",
 * 			"rip_memory_enable": "1",
 * 			"rip_memory_level": "1",
 * 			"rip_syslog_enable": "1",
 * 			"rip_syslog_level": "1",
 * 			"rip_email_enable": "1",
 * 			"rip_email_level": "1",
 * 			"rip_phone_enable": "1",
 * 			"rip_phone_level": "1",
 * 			"qos_memory_enable": "1",
 * 			"qos_memory_level": "1",
 * 			"qos_syslog_enable": "1",
 * 			"qos_syslog_level": "1",
 * 			"qos_email_enable": "1",
 * 			"qos_email_level": "1",
 * 			"qos_phone_enable": "1",
 * 			"qos_phone_level": "1",
 * 			"bgp_memory_enable": "1",
 * 			"bgp_memory_level": "1",
 * 			"bgp_syslog_enable": "1",
 * 			"bgp_syslog_level": "1",
 * 			"bgp_email_enable": "1",
 * 			"bgp_email_level": "1",
 * 			"bgp_phone_enable": "1",
 * 			"bgp_phone_level": "1",
 * 			"scan_memory_enable": "1",
 * 			"scan_memory_level": "1",
 * 			"scan_syslog_enable": "1",
 * 			"scan_syslog_level": "1",
 * 			"scan_email_enable": "1",
 * 			"scan_email_level": "1",
 * 			"scan_phone_enable": "1",
 * 			"scan_phone_level": "1",
 * 			"filter_memory_enable": "1",
 * 			"filter_memory_level": "1",
 * 			"filter_syslog_enable": "1",
 * 			"filter_syslog_level": "1",
 * 			"filter_email_enable": "1",
 * 			"filter_email_level": "1",
 * 			"filter_phone_enable": "1",
 * 			"filter_phone_level": "1",
 * 			"ips_memory_enable": "1",
 * 			"ips_memory_level": "1",
 * 			"ips_syslog_enable": "1",
 * 			"ips_syslog_level": "1",
 * 			"ips_email_enable": "1",
 * 			"ips_email_level": "1",
 * 			"ips_phone_enable": "1",
 * 			"ips_phone_level": "1",
 * 			"av_memory_enable": "1",
 * 			"av_memory_level": "1",
 * 			"av_syslog_enable": "1",
 * 			"av_syslog_level": "1",
 * 			"av_email_enable": "1",
 * 			"av_email_level": "1",
 * 			"av_phone_enable": "1",
 * 			"av_phone_level": "1",
 * 			"ac_memory_enable": "1",
 * 			"ac_memory_level": "1",
 * 			"ac_syslog_enable": "1",
 * 			"ac_syslog_level": "1",
 * 			"ac_email_enable": "1",
 * 			"ac_email_level": "1",
 * 			"ac_phone_enable": "1",
 * 			"ac_phone_level": "1",
 * 			"instant_message_memory_enable": "1",
 * 			"instant_message_memory_level": "1",
 * 			"instant_message_syslog_enable": "1",
 * 			"instant_message_syslog_level": "1",
 * 			"instant_message_email_enable": "1",
 * 			"instant_message_email_level": "1",
 * 			"instant_message_phone_enable": "1",
 * 			"instant_message_phone_level": "1",
 * 			"search_engine_memory_enable": "1",
 * 			"search_engine_memory_level": "1",
 * 			"search_engine_syslog_enable": "1",
 * 			"search_engine_syslog_level": "1",
 * 			"search_engine_email_enable": "1",
 * 			"search_engine_email_level": "1",
 * 			"search_engine_phone_enable": "1",
 * 			"search_engine_phone_level": "1",
 * 			"social_network_memory_enable": "1",
 * 			"social_network_memory_level": "1",
 * 			"social_network_syslog_enable": "1",
 * 			"social_network_syslog_level": "1",
 * 			"social_network_email_enable": "1",
 * 			"social_network_email_level": "1",
 * 			"social_network_phone_enable": "1",
 * 			"social_network_phone_level": "1",
 * 			"email_memory_enable": "1",
 * 			"email_memory_level": "1",
 * 			"email_syslog_enable": "1",
 * 			"email_syslog_level": "1",
 * 			"email_email_enable": "1",
 * 			"email_email_level": "1",
 * 			"email_phone_enable": "1",
 * 			"email_phone_level": "1",
 * 			"file_transfer_memory_enable": "1",
 * 			"file_transfer_memory_level": "1",
 * 			"file_transfer_syslog_enable": "1",
 * 			"file_transfer_syslog_level": "1",
 * 			"file_transfer_email_enable": "1",
 * 			"file_transfer_email_level": "1",
 * 			"file_transfer_phone_enable": "1",
 * 			"file_transfer_phone_level": "1",
 * 			"online_shopping_memory_enable": "1",
 * 			"online_shopping_memory_level": "1",
 * 			"online_shopping_syslog_enable": "1",
 * 			"online_shopping_syslog_level": "1",
 * 			"online_shopping_email_enable": "1",
 * 			"online_shopping_email_level": "1",
 * 			"online_shopping_phone_enable": "1",
 * 			"online_shopping_phone_level": "1",
 * 			"app_others_memory_enable": "1",
 * 			"app_others_memory_level": "1",
 * 			"app_others_syslog_enable": "1",
 * 			"app_others_syslog_level": "1",
 * 			"app_others_email_enable": "1",
 * 			"app_others_email_level": "1",
 * 			"app_others_phone_enable": "1",
 * 			"app_others_phone_level": "1",
 * 			"web_access_memory_enable": "1",
 * 			"web_access_memory_level": "1",
 * 			"web_access_syslog_enable": "1",
 * 			"web_access_syslog_level": "1",
 * 			"web_access_email_enable": "1",
 * 			"web_access_email_level": "1",
 * 			"web_access_phone_enable": "1",
 * 			"web_access_phone_level": "1",
 * 			"persist_memory_enable": "1",
 * 			"persist_memory_level": "1",
 * 			"persist_syslog_enable": "1",
 * 			"persist_syslog_level": "1",
 * 			"persist_email_enable": "1",
 * 			"persist_email_level": "1",
 * 			"persist_phone_enable": "1",
 * 			"persist_phone_level": "1",
 * 			"httpswitch_memory_enable": "1",
 * 			"httpswitch_memory_level": "1",
 * 			"httpswitch_syslog_enable": "1",
 * 			"httpswitch_syslog_level": "1",
 * 			"httpswitch_email_enable": "1",
 * 			"httpswitch_email_level": "1",
 * 			"httpswitch_phone_enable": "1",
 * 			"httpswitch_phone_level": "1",
 * 			"httperrcode_memory_enable": "1",
 * 			"httperrcode_memory_level": "1",
 * 			"httperrcode_syslog_enable": "1",
 * 			"httperrcode_syslog_level": "1",
 * 			"httperrcode_email_enable": "1",
 * 			"httperrcode_email_level": "1",
 * 			"httperrcode_phone_enable": "1",
 * 			"httperrcode_phone_level": "1",
 * 			"httpcache_memory_enable": "1",
 * 			"httpcache_memory_level": "1",
 * 			"httpcache_syslog_enable": "1",
 * 			"httpcache_syslog_level": "1",
 * 			"httpcache_email_enable": "1",
 * 			"httpcache_email_level": "1",
 * 			"httpcache_phone_enable": "1",
 * 			"httpcache_phone_level": "1",
 * 			"sslaccelerate_memory_enable": "1",
 * 			"sslaccelerate_memory_level": "1",
 * 			"sslaccelerate_syslog_enable": "1",
 * 			"sslaccelerate_syslog_level": "1",
 * 			"sslaccelerate_email_enable": "1",
 * 			"sslaccelerate_email_level": "1",
 * 			"sslaccelerate_phone_enable": "1",
 * 			"sslaccelerate_phone_level": "1",
 * 			"httpcompress_memory_enable": "1",
 * 			"httpcompress_memory_level": "1",
 * 			"httpcompress_syslog_enable": "1",
 * 			"httpcompress_syslog_level": "1",
 * 			"httpcompress_email_enable": "1",
 * 			"httpcompress_email_level": "1",
 * 			"httpcompress_phone_enable": "1",
 * 			"httpcompress_phone_level": "1",
 * 			"httpfirewall_memory_enable": "1",
 * 			"httpfirewall_memory_level": "1",
 * 			"httpfirewall_syslog_enable": "1",
 * 			"httpfirewall_syslog_level": "1",
 * 			"httpfirewall_email_enable": "1",
 * 			"httpfirewall_email_level": "1",
 * 			"httpfirewall_phone_enable": "1",
 * 			"httpfirewall_phone_level": "1",
 * 			"httpcc_memory_enable": "1",
 * 			"httpcc_memory_level": "1",
 * 			"httpcc_syslog_enable": "1",
 * 			"httpcc_syslog_level": "1",
 * 			"httpcc_email_enable": "1",
 * 			"httpcc_email_level": "1",
 * 			"httpcc_phone_enable": "1",
 * 			"httpcc_phone_level": "1",
 * 			"oneconnect_memory_enable": "1",
 * 			"oneconnect_memory_level": "1",
 * 			"oneconnect_syslog_enable": "1",
 * 			"oneconnect_syslog_level": "1",
 * 			"oneconnect_email_enable": "1",
 * 			"oneconnect_email_level": "1",
 * 			"oneconnect_phone_enable": "1",
 * 			"oneconnect_phone_level": "1",
 * 			"hm_memory_enable": "1",
 * 			"hm_memory_level": "1",
 * 			"hm_syslog_enable": "1",
 * 			"hm_syslog_level": "1",
 * 			"hm_email_enable": "1",
 * 			"hm_email_level": "1",
 * 			"hm_phone_enable": "1",
 * 			"hm_phone_level": "1",
 * 			"vs_memory_enable": "1",
 * 			"vs_memory_level": "1",
 * 			"vs_syslog_enable": "1",
 * 			"vs_syslog_level": "1",
 * 			"vs_email_enable": "1",
 * 			"vs_email_level": "1",
 * 			"vs_phone_enable": "1",
 * 			"vs_phone_level": "1",
 * 			"vlink_memory_enable": "1",
 * 			"vlink_memory_level": "1",
 * 			"vlink_syslog_enable": "1",
 * 			"vlink_syslog_level": "1",
 * 			"vlink_email_enable": "1",
 * 			"vlink_email_level": "1",
 * 			"vlink_phone_enable": "1",
 * 			"vlink_phone_level": "1",
 * 			"lcin_memory_enable": "1",
 * 			"lcin_memory_level": "1",
 * 			"lcin_syslog_enable": "1",
 * 			"lcin_syslog_level": "1",
 * 			"lcin_email_enable": "1",
 * 			"lcin_email_level": "1",
 * 			"lcin_phone_enable": "1",
 * 			"lcin_phone_level": "1",
 * 			"gtm_memory_enable": "1",
 * 			"gtm_memory_level": "1",
 * 			"gtm_syslog_enable": "1",
 * 			"gtm_syslog_level": "1",
 * 			"gtm_email_enable": "1",
 * 			"gtm_email_level": "1",
 * 			"gtm_phone_enable": "1",
 * 			"gtm_phone_level": "1",
 * 			"dns_memory_enable": "1",
 * 			"dns_memory_level": "1",
 * 			"dns_syslog_enable": "1",
 * 			"dns_syslog_level": "1",
 * 			"dns_email_enable": "1",
 * 			"dns_email_level": "1",
 * 			"dns_phone_enable": "1",
 * 			"dns_phone_level": "1",
 * 			"httpxssql_memory_enable": "1",
 * 			"httpxssql_memory_level": "1",
 * 			"httpxssql_syslog_enable": "1",
 * 			"httpxssql_syslog_level": "1",
 * 			"httpxssql_email_enable": "1",
 * 			"httpxssql_email_level": "1",
 * 			"httpxssql_phone_enable": "1",
 * 			"httpxssql_phone_level": "1",
 * 			"linkthreshold_memory_enable": "1",
 * 			"linkthreshold_memory_level": "1",
 * 			"linkthreshold_syslog_enable": "1",
 * 			"linkthreshold_syslog_level": "1",
 * 			"linkthreshold_email_enable": "1",
 * 			"linkthreshold_email_level": "1",
 * 			"linkthreshold_phone_enable": "1",
 * 			"linkthreshold_phone_level": "1",
 * 			"dnsproxy_memory_enable": "1",
 * 			"dnsproxy_memory_level": "1",
 * 			"dnsproxy_syslog_enable": "1",
 * 			"dnsproxy_syslog_level": "1",
 * 			"dnsproxy_email_enable": "1",
 * 			"dnsproxy_email_level": "1",
 * 			"dnsproxy_phone_enable": "1",
 * 			"dnsproxy_phone_level": "1",
 * 			"vrrp_memory_enable": "1",
 * 			"vrrp_memory_level": "1",
 * 			"vrrp_syslog_enable": "1",
 * 			"vrrp_syslog_level": "1",
 * 			"vrrp_email_enable": "1",
 * 			"vrrp_email_level": "1",
 * 			"vrrp_phone_enable": "1",
 * 			"vrrp_phone_level": "1",
 * 			"httpredirect_memory_enable": "1",
 * 			"httpredirect_memory_level": "1",
 * 			"httpredirect_syslog_enable": "1",
 * 			"httpredirect_syslog_level": "1",
 * 			"httpredirect_email_enable": "1",
 * 			"httpredirect_email_level": "1",
 * 			"httpredirect_phone_enable": "1",
 * 			"httpredirect_phone_level": "1",
 * 			"flood_memory_enable": "1",
 * 			"flood_memory_level": "1",
 * 			"flood_syslog_enable": "1",
 * 			"flood_syslog_level": "1",
 * 			"flood_email_enable": "1",
 * 			"flood_email_level": "1",
 * 			"flood_phone_enable": "1",
 * 			"flood_phone_level": "1",
 * 			"apt_memory_enable": "1",
 * 			"apt_memory_level": "1",
 * 			"apt_syslog_enable": "1",
 * 			"apt_syslog_level": "1",
 * 			"apt_email_enable": "1",
 * 			"apt_email_level": "1",
 * 			"apt_phone_enable": "1",
 * 			"apt_phone_level": "1",
 * 			"defense_memory_enable": "1",
 * 			"defense_memory_level": "1",
 * 			"defense_syslog_enable": "1",
 * 			"defense_syslog_level": "1",
 * 			"defense_email_enable": "1",
 * 			"defense_email_level": "1",
 * 			"defense_phone_enable": "1",
 * 			"defense_phone_level": "1",
 * 			"config_memory_enable": "1",
 * 			"config_memory_level": "1",
 * 			"config_syslog_enable": "1",
 * 			"config_syslog_level": "1",
 * 			"config_email_enable": "1",
 * 			"config_email_level": "1",
 * 			"config_phone_enable": "1",
 * 			"config_phone_level": "1"
 *		}
 *	}
 */

/**
 * @api {PUT}  /api/syslog-filter 修改日志过滤配置
 * @apiName syslog-filter
 * @apiGroup 日志设定
 *
 * @apiSuccess {Number} ddos_memory_enable DDOS日志本地存储使能状态
 * @apiSuccess {Number} ddos_memory_level DDOS日志本地存储级别
 * @apiSuccess {Number} ddos_syslog_enable DDOS日志Syslog存储使能状态
 * @apiSuccess {Number} ddos_syslog_level DDOS日志Syslog存储级别
 * @apiSuccess {Number} ddos_email_enable DDOS日志E-mail报警使能状态
 * @apiSuccess {Number} ddos_email_level DDOS日志E-mail报警级别
 * @apiSuccess {Number} ddos_phone_enable DDOS日志短信报警使能状态
 * @apiSuccess {Number} ddos_phone_level apt日志短信报警级别
 * @apiSuccess {Number} interface_memory_enable interface日志本地存储使能状态
 * @apiSuccess {Number} interface_memory_level interface日志本地存储级别
 * @apiSuccess {Number} interface_syslog_enable interface日志Syslog存储使能状态
 * @apiSuccess {Number} interface_syslog_level interface日志Syslog存储级别
 * @apiSuccess {Number} interface_email_enable interface日志E-mail报警使能状态
 * @apiSuccess {Number} interface_email_level interface日志E-mail报警级别
 * @apiSuccess {Number} interface_phone_enable interface日志短信报警使能状态
 * @apiSuccess {Number} interface_phone_level interface日志短信报警级别
 * @apiSuccess {Number} nat_memory_enable nat日志本地存储使能状态
 * @apiSuccess {Number} nat_memory_level nat日志本地存储级别
 * @apiSuccess {Number} nat_syslog_enable nat日志Syslog存储使能状态
 * @apiSuccess {Number} nat_syslog_level nat日志Syslog存储级别
 * @apiSuccess {Number} nat_email_enable nat日志E-mail报警使能状态
 * @apiSuccess {Number} nat_email_level nat日志E-mail报警级别
 * @apiSuccess {Number} nat_phone_enable nat日志短信报警使能状态
 * @apiSuccess {Number} nat_phone_level nat日志短信报警级别
 * @apiSuccess {Number} ha_memory_enable ha日志本地存储使能状态
 * @apiSuccess {Number} ha_memory_level ha日志本地存储级别
 * @apiSuccess {Number} ha_syslog_enable ha日志Syslog存储使能状态
 * @apiSuccess {Number} ha_syslog_level ha日志Syslog存储级别
 * @apiSuccess {Number} ha_email_enable ha日志E-mail报警使能状态
 * @apiSuccess {Number} ha_email_level ha日志E-mail报警级别
 * @apiSuccess {Number} ha_phone_enable ha日志短信报警使能状态
 * @apiSuccess {Number} ha_phone_level ha日志短信报警级别
 * @apiSuccess {Number} system_memory_enable system日志本地存储使能状态
 * @apiSuccess {Number} system_memory_level system日志本地存储级别
 * @apiSuccess {Number} system_syslog_enable system日志Syslog存储使能状态
 * @apiSuccess {Number} system_syslog_level system日志Syslog存储级别
 * @apiSuccess {Number} system_email_enable system日志E-mail报警使能状态
 * @apiSuccess {Number} system_email_level system日志E-mail报警级别
 * @apiSuccess {Number} system_phone_enable system日志短信报警使能状态
 * @apiSuccess {Number} system_phone_level system日志短信报警级别
 * @apiSuccess {Number} ospf_memory_enable ospf日志本地存储使能状态
 * @apiSuccess {Number} ospf_memory_level ospf日志本地存储级别
 * @apiSuccess {Number} ospf_syslog_enable ospf日志Syslog存储使能状态
 * @apiSuccess {Number} ospf_syslog_level ospf日志Syslog存储级别
 * @apiSuccess {Number} ospf_email_enable ospf日志E-mail报警使能状态
 * @apiSuccess {Number} ospf_email_level ospf日志E-mail报警级别
 * @apiSuccess {Number} ospf_phone_enable ospf日志短信报警使能状态
 * @apiSuccess {Number} ospf_phone_level ospf日志短信报警级别
 * @apiSuccess {Number} rip_memory_enable rip日志本地存储使能状态
 * @apiSuccess {Number} rip_memory_level rip日志本地存储级别
 * @apiSuccess {Number} rip_syslog_enable rip日志Syslog存储使能状态
 * @apiSuccess {Number} rip_syslog_level rip日志Syslog存储级别
 * @apiSuccess {Number} rip_email_enable rip日志E-mail报警使能状态
 * @apiSuccess {Number} rip_email_level rip日志E-mail报警级别
 * @apiSuccess {Number} rip_phone_enable rip日志短信报警使能状态
 * @apiSuccess {Number} rip_phone_level rip日志短信报警级别
 * @apiSuccess {Number} qos_memory_enable qos日志本地存储使能状态
 * @apiSuccess {Number} qos_memory_level qos日志本地存储级别
 * @apiSuccess {Number} qos_syslog_enable qos日志Syslog存储使能状态
 * @apiSuccess {Number} qos_syslog_level qos日志Syslog存储级别
 * @apiSuccess {Number} qos_email_enable qos日志E-mail报警使能状态
 * @apiSuccess {Number} qos_email_level qos日志E-mail报警级别
 * @apiSuccess {Number} qos_phone_enable qos日志短信报警使能状态
 * @apiSuccess {Number} qos_phone_level qos日志短信报警级别
 * @apiSuccess {Number} bgp_memory_enable bgp日志本地存储使能状态
 * @apiSuccess {Number} bgp_memory_level bgp日志本地存储级别
 * @apiSuccess {Number} bgp_syslog_enable bgp日志Syslog存储使能状态
 * @apiSuccess {Number} bgp_syslog_level bgp日志Syslog存储级别
 * @apiSuccess {Number} bgp_email_enable bgp日志E-mail报警使能状态
 * @apiSuccess {Number} bgp_email_level bgp日志E-mail报警级别
 * @apiSuccess {Number} bgp_phone_enable bgp日志短信报警使能状态
 * @apiSuccess {Number} bgp_phone_level bgp日志短信报警级别
 * @apiSuccess {Number} scan_memory_enable scan日志本地存储使能状态
 * @apiSuccess {Number} scan_memory_level scan日志本地存储级别
 * @apiSuccess {Number} scan_syslog_enable scan日志Syslog存储使能状态
 * @apiSuccess {Number} scan_syslog_level scan日志Syslog存储级别
 * @apiSuccess {Number} scan_email_enable scan日志E-mail报警使能状态
 * @apiSuccess {Number} scan_email_level scan日志E-mail报警级别
 * @apiSuccess {Number} scan_phone_enable scan日志短信报警使能状态
 * @apiSuccess {Number} scan_phone_level scan日志短信报警级别
 * @apiSuccess {Number} filter_memory_enable filter日志本地存储使能状态
 * @apiSuccess {Number} filter_memory_level filter日志本地存储级别
 * @apiSuccess {Number} filter_syslog_enable filter日志Syslog存储使能状态
 * @apiSuccess {Number} filter_syslog_level filter日志Syslog存储级别
 * @apiSuccess {Number} filter_email_enable filter日志E-mail报警使能状态
 * @apiSuccess {Number} filter_email_level filter日志E-mail报警级别
 * @apiSuccess {Number} filter_phone_enable filter日志短信报警使能状态
 * @apiSuccess {Number} filter_phone_level filter日志短信报警级别
 * @apiSuccess {Number} ips_memory_enable ips日志本地存储使能状态
 * @apiSuccess {Number} ips_memory_level ips日志本地存储级别
 * @apiSuccess {Number} ips_syslog_enable ips日志Syslog存储使能状态
 * @apiSuccess {Number} ips_syslog_level ips日志Syslog存储级别
 * @apiSuccess {Number} ips_email_enable ips日志E-mail报警使能状态
 * @apiSuccess {Number} ips_email_level ips日志E-mail报警级别
 * @apiSuccess {Number} ips_phone_enable ips日志短信报警使能状态
 * @apiSuccess {Number} ips_phone_level ips日志短信报警级别
 * @apiSuccess {Number} av_memory_enable av日志本地存储使能状态
 * @apiSuccess {Number} av_memory_level av日志本地存储级别
 * @apiSuccess {Number} av_syslog_enable av日志Syslog存储使能状态
 * @apiSuccess {Number} av_syslog_level av日志Syslog存储级别
 * @apiSuccess {Number} av_email_enable av日志E-mail报警使能状态
 * @apiSuccess {Number} av_email_level av日志E-mail报警级别
 * @apiSuccess {Number} av_phone_enable av日志短信报警使能状态
 * @apiSuccess {Number} av_phone_level av日志短信报警级别
 * @apiSuccess {Number} ac_memory_enable ac日志本地存储使能状态
 * @apiSuccess {Number} ac_memory_level ac日志本地存储级别
 * @apiSuccess {Number} ac_syslog_enable ac日志Syslog存储使能状态
 * @apiSuccess {Number} ac_syslog_level ac日志Syslog存储级别
 * @apiSuccess {Number} ac_email_enable ac日志E-mail报警使能状态
 * @apiSuccess {Number} ac_email_level ac日志E-mail报警级别
 * @apiSuccess {Number} ac_phone_enable ac日志短信报警使能状态
 * @apiSuccess {Number} ac_phone_level ac日志短信报警级别
 * @apiSuccess {Number} instant_message_memory_enable instant_message日志本地存储使能状态
 * @apiSuccess {Number} instant_message_memory_level instant_message日志本地存储级别
 * @apiSuccess {Number} instant_message_syslog_enable instant_message日志Syslog存储使能状态
 * @apiSuccess {Number} instant_message_syslog_level instant_message日志Syslog存储级别
 * @apiSuccess {Number} instant_message_email_enable instant_message日志E-mail报警使能状态
 * @apiSuccess {Number} instant_message_email_level instant_message日志E-mail报警级别
 * @apiSuccess {Number} instant_message_phone_enable instant_message日志短信报警使能状态
 * @apiSuccess {Number} instant_message_phone_level instant_message日志短信报警级别
 * @apiSuccess {Number} search_engine_memory_enable search_engine日志本地存储使能状态
 * @apiSuccess {Number} search_engine_memory_level search_engine日志本地存储级别
 * @apiSuccess {Number} search_engine_syslog_enable search_engine日志Syslog存储使能状态
 * @apiSuccess {Number} search_engine_syslog_level search_engine日志Syslog存储级别
 * @apiSuccess {Number} search_engine_email_enable search_engine日志E-mail报警使能状态
 * @apiSuccess {Number} search_engine_email_level search_engine日志E-mail报警级别
 * @apiSuccess {Number} search_engine_phone_enable search_engine日志短信报警使能状态
 * @apiSuccess {Number} search_engine_phone_level search_engine日志短信报警级别
 * @apiSuccess {Number} social_network_memory_enable social_network日志本地存储使能状态
 * @apiSuccess {Number} social_network_memory_level social_network日志本地存储级别
 * @apiSuccess {Number} social_network_syslog_enable social_network日志Syslog存储使能状态
 * @apiSuccess {Number} social_network_syslog_level social_network日志Syslog存储级别
 * @apiSuccess {Number} social_network_email_enable social_network日志E-mail报警使能状态
 * @apiSuccess {Number} social_network_email_level social_network日志E-mail报警级别
 * @apiSuccess {Number} social_network_phone_enable social_network日志短信报警使能状态
 * @apiSuccess {Number} social_network_phone_level social_network日志短信报警级别
 * @apiSuccess {Number} email_memory_enable email日志本地存储使能状态
 * @apiSuccess {Number} email_memory_level email日志本地存储级别
 * @apiSuccess {Number} email_syslog_enable email日志Syslog存储使能状态
 * @apiSuccess {Number} email_syslog_level email日志Syslog存储级别
 * @apiSuccess {Number} email_email_enable email日志E-mail报警使能状态
 * @apiSuccess {Number} email_email_level email日志E-mail报警级别
 * @apiSuccess {Number} email_phone_enable email日志短信报警使能状态
 * @apiSuccess {Number} email_phone_level email日志短信报警级别
 * @apiSuccess {Number} file_transfer_memory_enable file_transfer日志本地存储使能状态
 * @apiSuccess {Number} file_transfer_memory_level file_transfer日志本地存储级别
 * @apiSuccess {Number} file_transfer_syslog_enable file_transfer日志Syslog存储使能状态
 * @apiSuccess {Number} file_transfer_syslog_level file_transfer日志Syslog存储级别
 * @apiSuccess {Number} file_transfer_email_enable file_transfer日志E-mail报警使能状态
 * @apiSuccess {Number} file_transfer_email_level file_transfer日志E-mail报警级别
 * @apiSuccess {Number} file_transfer_phone_enable file_transfer日志短信报警使能状态
 * @apiSuccess {Number} file_transfer_phone_level file_transfer日志短信报警级别
 * @apiSuccess {Number} online_shopping_memory_enable online_shopping日志本地存储使能状态
 * @apiSuccess {Number} online_shopping_memory_level online_shopping日志本地存储级别
 * @apiSuccess {Number} online_shopping_syslog_enable online_shopping日志Syslog存储使能状态
 * @apiSuccess {Number} online_shopping_syslog_level online_shopping日志Syslog存储级别
 * @apiSuccess {Number} online_shopping_email_enable online_shopping日志E-mail报警使能状态
 * @apiSuccess {Number} online_shopping_email_level online_shopping日志E-mail报警级别
 * @apiSuccess {Number} online_shopping_phone_enable online_shopping日志短信报警使能状态
 * @apiSuccess {Number} online_shopping_phone_level online_shopping日志短信报警级别
 * @apiSuccess {Number} app_others_memory_enable app_others日志本地存储使能状态
 * @apiSuccess {Number} app_others_memory_level app_others日志本地存储级别
 * @apiSuccess {Number} app_others_syslog_enable app_others日志Syslog存储使能状态
 * @apiSuccess {Number} app_others_syslog_level app_others日志Syslog存储级别
 * @apiSuccess {Number} app_others_email_enable app_others日志E-mail报警使能状态
 * @apiSuccess {Number} app_others_email_level app_others日志E-mail报警级别
 * @apiSuccess {Number} app_others_phone_enable app_others日志短信报警使能状态
 * @apiSuccess {Number} app_others_phone_level app_others日志短信报警级别
 * @apiSuccess {Number} web_access_memory_enable web_access日志本地存储使能状态
 * @apiSuccess {Number} web_access_memory_level web_access日志本地存储级别
 * @apiSuccess {Number} web_access_syslog_enable web_access日志Syslog存储使能状态
 * @apiSuccess {Number} web_access_syslog_level web_access日志Syslog存储级别
 * @apiSuccess {Number} web_access_email_enable web_access日志E-mail报警使能状态
 * @apiSuccess {Number} web_access_email_level web_access日志E-mail报警级别
 * @apiSuccess {Number} web_access_phone_enable web_access日志短信报警使能状态
 * @apiSuccess {Number} web_access_phone_level web_access日志短信报警级别
 * @apiSuccess {Number} persist_memory_enable persist日志本地存储使能状态
 * @apiSuccess {Number} persist_memory_level persist日志本地存储级别
 * @apiSuccess {Number} persist_syslog_enable persist日志Syslog存储使能状态
 * @apiSuccess {Number} persist_syslog_level persist日志Syslog存储级别
 * @apiSuccess {Number} persist_email_enable persist日志E-mail报警使能状态
 * @apiSuccess {Number} persist_email_level persist日志E-mail报警级别
 * @apiSuccess {Number} persist_phone_enable persist日志短信报警使能状态
 * @apiSuccess {Number} persist_phone_level persist日志短信报警级别
 * @apiSuccess {Number} httpswitch_memory_enable httpswitch日志本地存储使能状态
 * @apiSuccess {Number} httpswitch_memory_level httpswitch日志本地存储级别
 * @apiSuccess {Number} httpswitch_syslog_enable httpswitch日志Syslog存储使能状态
 * @apiSuccess {Number} httpswitch_syslog_level httpswitch日志Syslog存储级别
 * @apiSuccess {Number} httpswitch_email_enable httpswitch日志E-mail报警使能状态
 * @apiSuccess {Number} httpswitch_email_level httpswitch日志E-mail报警级别
 * @apiSuccess {Number} httpswitch_phone_enable httpswitch日志短信报警使能状态
 * @apiSuccess {Number} httpswitch_phone_level httpswitch日志短信报警级别
 * @apiSuccess {Number} httperrcode_memory_enable httperrcode日志本地存储使能状态
 * @apiSuccess {Number} httperrcode_memory_level httperrcode日志本地存储级别
 * @apiSuccess {Number} httperrcode_syslog_enable httperrcode日志Syslog存储使能状态
 * @apiSuccess {Number} httperrcode_syslog_level httperrcode日志Syslog存储级别
 * @apiSuccess {Number} httperrcode_email_enable httperrcode日志E-mail报警使能状态
 * @apiSuccess {Number} httperrcode_email_level httperrcode日志E-mail报警级别
 * @apiSuccess {Number} httperrcode_phone_enable httperrcode日志短信报警使能状态
 * @apiSuccess {Number} httperrcode_phone_level httperrcode日志短信报警级别
 * @apiSuccess {Number} httpcache_memory_enable httpcache日志本地存储使能状态
 * @apiSuccess {Number} httpcache_memory_level httpcache日志本地存储级别
 * @apiSuccess {Number} httpcache_syslog_enable httpcache日志Syslog存储使能状态
 * @apiSuccess {Number} httpcache_syslog_level httpcache日志Syslog存储级别
 * @apiSuccess {Number} httpcache_email_enable httpcache日志E-mail报警使能状态
 * @apiSuccess {Number} httpcache_email_level httpcache日志E-mail报警级别
 * @apiSuccess {Number} httpcache_phone_enable httpcache日志短信报警使能状态
 * @apiSuccess {Number} httpcache_phone_level httpcache日志短信报警级别
 * @apiSuccess {Number} sslaccelerate_memory_enable sslaccelerate日志本地存储使能状态
 * @apiSuccess {Number} sslaccelerate_memory_level sslaccelerate日志本地存储级别
 * @apiSuccess {Number} sslaccelerate_syslog_enable sslaccelerate日志Syslog存储使能状态
 * @apiSuccess {Number} sslaccelerate_syslog_level sslaccelerate日志Syslog存储级别
 * @apiSuccess {Number} sslaccelerate_email_enable sslaccelerate日志E-mail报警使能状态
 * @apiSuccess {Number} sslaccelerate_email_level sslaccelerate日志E-mail报警级别
 * @apiSuccess {Number} sslaccelerate_phone_enable sslaccelerate日志短信报警使能状态
 * @apiSuccess {Number} sslaccelerate_phone_level sslaccelerate日志短信报警级别
 * @apiSuccess {Number} httpcompress_memory_enable httpcompress日志本地存储使能状态
 * @apiSuccess {Number} httpcompress_memory_level httpcompress日志本地存储级别
 * @apiSuccess {Number} httpcompress_syslog_enable httpcompress日志Syslog存储使能状态
 * @apiSuccess {Number} httpcompress_syslog_level httpcompress日志Syslog存储级别
 * @apiSuccess {Number} httpcompress_email_enable httpcompress日志E-mail报警使能状态
 * @apiSuccess {Number} httpcompress_email_level httpcompress日志E-mail报警级别
 * @apiSuccess {Number} httpcompress_phone_enable httpcompress日志短信报警使能状态
 * @apiSuccess {Number} httpcompress_phone_level httpcompress日志短信报警级别
 * @apiSuccess {Number} httpfirewall_memory_enable httpfirewall日志本地存储使能状态
 * @apiSuccess {Number} httpfirewall_memory_level httpfirewall日志本地存储级别
 * @apiSuccess {Number} httpfirewall_syslog_enable httpfirewall日志Syslog存储使能状态
 * @apiSuccess {Number} httpfirewall_syslog_level httpfirewall日志Syslog存储级别
 * @apiSuccess {Number} httpfirewall_email_enable httpfirewall日志E-mail报警使能状态
 * @apiSuccess {Number} httpfirewall_email_level httpfirewall日志E-mail报警级别
 * @apiSuccess {Number} httpfirewall_phone_enable httpfirewall日志短信报警使能状态
 * @apiSuccess {Number} httpfirewall_phone_level httpfirewall日志短信报警级别
 * @apiSuccess {Number} httpcc_memory_enable httpcc日志本地存储使能状态
 * @apiSuccess {Number} httpcc_memory_level httpcc日志本地存储级别
 * @apiSuccess {Number} httpcc_syslog_enable httpcc日志Syslog存储使能状态
 * @apiSuccess {Number} httpcc_syslog_level httpcc日志Syslog存储级别
 * @apiSuccess {Number} httpcc_email_enable httpcc日志E-mail报警使能状态
 * @apiSuccess {Number} httpcc_email_level httpcc日志E-mail报警级别
 * @apiSuccess {Number} httpcc_phone_enable httpcc日志短信报警使能状态
 * @apiSuccess {Number} httpcc_phone_level httpcc日志短信报警级别
 * @apiSuccess {Number} oneconnect_memory_enable oneconnect日志本地存储使能状态
 * @apiSuccess {Number} oneconnect_memory_level oneconnect日志本地存储级别
 * @apiSuccess {Number} oneconnect_syslog_enable oneconnect日志Syslog存储使能状态
 * @apiSuccess {Number} oneconnect_syslog_level oneconnect日志Syslog存储级别
 * @apiSuccess {Number} oneconnect_email_enable oneconnect日志E-mail报警使能状态
 * @apiSuccess {Number} oneconnect_email_level oneconnect日志E-mail报警级别
 * @apiSuccess {Number} oneconnect_phone_enable oneconnect日志短信报警使能状态
 * @apiSuccess {Number} oneconnect_phone_level oneconnect日志短信报警级别
 * @apiSuccess {Number} hm_memory_enable hm日志本地存储使能状态
 * @apiSuccess {Number} hm_memory_level hm日志本地存储级别
 * @apiSuccess {Number} hm_syslog_enable hm日志Syslog存储使能状态
 * @apiSuccess {Number} hm_syslog_level hm日志Syslog存储级别
 * @apiSuccess {Number} hm_email_enable hm日志E-mail报警使能状态
 * @apiSuccess {Number} hm_email_level hm日志E-mail报警级别
 * @apiSuccess {Number} hm_phone_enable hm日志短信报警使能状态
 * @apiSuccess {Number} hm_phone_level hm日志短信报警级别
 * @apiSuccess {Number} vs_memory_enable vs日志本地存储使能状态
 * @apiSuccess {Number} vs_memory_level vs日志本地存储级别
 * @apiSuccess {Number} vs_syslog_enable vs日志Syslog存储使能状态
 * @apiSuccess {Number} vs_syslog_level vs日志Syslog存储级别
 * @apiSuccess {Number} vs_email_enable vs日志E-mail报警使能状态
 * @apiSuccess {Number} vs_email_level vs日志E-mail报警级别
 * @apiSuccess {Number} vs_phone_enable vs日志短信报警使能状态
 * @apiSuccess {Number} vs_phone_level vs日志短信报警级别
 * @apiSuccess {Number} vlink_memory_enable vlink日志本地存储使能状态
 * @apiSuccess {Number} vlink_memory_level vlink日志本地存储级别
 * @apiSuccess {Number} vlink_syslog_enable vlink日志Syslog存储使能状态
 * @apiSuccess {Number} vlink_syslog_level vlink日志Syslog存储级别
 * @apiSuccess {Number} vlink_email_enable vlink日志E-mail报警使能状态
 * @apiSuccess {Number} vlink_email_level vlink日志E-mail报警级别
 * @apiSuccess {Number} vlink_phone_enable vlink日志短信报警使能状态
 * @apiSuccess {Number} vlink_phone_level vlink日志短信报警级别
 * @apiSuccess {Number} lcin_memory_enable lcin日志本地存储使能状态
 * @apiSuccess {Number} lcin_memory_level lcin日志本地存储级别
 * @apiSuccess {Number} lcin_syslog_enable lcin日志Syslog存储使能状态
 * @apiSuccess {Number} lcin_syslog_level lcin日志Syslog存储级别
 * @apiSuccess {Number} lcin_email_enable lcin日志E-mail报警使能状态
 * @apiSuccess {Number} lcin_email_level lcin日志E-mail报警级别
 * @apiSuccess {Number} lcin_phone_enable lcin日志短信报警使能状态
 * @apiSuccess {Number} lcin_phone_level lcin日志短信报警级别
 * @apiSuccess {Number} gtm_memory_enable gtm日志本地存储使能状态
 * @apiSuccess {Number} gtm_memory_level gtm日志本地存储级别
 * @apiSuccess {Number} gtm_syslog_enable gtm日志Syslog存储使能状态
 * @apiSuccess {Number} gtm_syslog_level gtm日志Syslog存储级别
 * @apiSuccess {Number} gtm_email_enable gtm日志E-mail报警使能状态
 * @apiSuccess {Number} gtm_email_level gtm日志E-mail报警级别
 * @apiSuccess {Number} gtm_phone_enable gtm日志短信报警使能状态
 * @apiSuccess {Number} gtm_phone_level gtm日志短信报警级别
 * @apiSuccess {Number} dns_memory_enable dns日志本地存储使能状态
 * @apiSuccess {Number} dns_memory_level dns日志本地存储级别
 * @apiSuccess {Number} dns_syslog_enable dns日志Syslog存储使能状态
 * @apiSuccess {Number} dns_syslog_level dns日志Syslog存储级别
 * @apiSuccess {Number} dns_email_enable dns日志E-mail报警使能状态
 * @apiSuccess {Number} dns_email_level dns日志E-mail报警级别
 * @apiSuccess {Number} dns_phone_enable dns日志短信报警使能状态
 * @apiSuccess {Number} dns_phone_level dns日志短信报警级别
 * @apiSuccess {Number} httpxssql_memory_enable httpxssql日志本地存储使能状态
 * @apiSuccess {Number} httpxssql_memory_level httpxssql日志本地存储级别
 * @apiSuccess {Number} httpxssql_syslog_enable httpxssql日志Syslog存储使能状态
 * @apiSuccess {Number} httpxssql_syslog_level httpxssql日志Syslog存储级别
 * @apiSuccess {Number} httpxssql_email_enable httpxssql日志E-mail报警使能状态
 * @apiSuccess {Number} httpxssql_email_level httpxssql日志E-mail报警级别
 * @apiSuccess {Number} httpxssql_phone_enable httpxssql日志短信报警使能状态
 * @apiSuccess {Number} httpxssql_phone_level httpxssql日志短信报警级别
 * @apiSuccess {Number} linkthreshold_memory_enable linkthreshold日志本地存储使能状态
 * @apiSuccess {Number} linkthreshold_memory_level linkthreshold日志本地存储级别
 * @apiSuccess {Number} linkthreshold_syslog_enable linkthreshold日志Syslog存储使能状态
 * @apiSuccess {Number} linkthreshold_syslog_level linkthreshold日志Syslog存储级别
 * @apiSuccess {Number} linkthreshold_email_enable linkthreshold日志E-mail报警使能状态
 * @apiSuccess {Number} linkthreshold_email_level linkthreshold日志E-mail报警级别
 * @apiSuccess {Number} linkthreshold_phone_enable linkthreshold日志短信报警使能状态
 * @apiSuccess {Number} linkthreshold_phone_level linkthreshold日志短信报警级别
 * @apiSuccess {Number} dnsproxy_memory_enable dnsproxy日志本地存储使能状态
 * @apiSuccess {Number} dnsproxy_memory_level dnsproxy日志本地存储级别
 * @apiSuccess {Number} dnsproxy_syslog_enable dnsproxy日志Syslog存储使能状态
 * @apiSuccess {Number} dnsproxy_syslog_level dnsproxy日志Syslog存储级别
 * @apiSuccess {Number} dnsproxy_email_enable dnsproxy日志E-mail报警使能状态
 * @apiSuccess {Number} dnsproxy_email_level dnsproxy日志E-mail报警级别
 * @apiSuccess {Number} dnsproxy_phone_enable dnsproxy日志短信报警使能状态
 * @apiSuccess {Number} dnsproxy_phone_level dnsproxy日志短信报警级别
 * @apiSuccess {Number} vrrp_memory_enable vrrp日志本地存储使能状态
 * @apiSuccess {Number} vrrp_memory_level vrrp日志本地存储级别
 * @apiSuccess {Number} vrrp_syslog_enable vrrp日志Syslog存储使能状态
 * @apiSuccess {Number} vrrp_syslog_level vrrp日志Syslog存储级别
 * @apiSuccess {Number} vrrp_email_enable vrrp日志E-mail报警使能状态
 * @apiSuccess {Number} vrrp_email_level vrrp日志E-mail报警级别
 * @apiSuccess {Number} vrrp_phone_enable vrrp日志短信报警使能状态
 * @apiSuccess {Number} vrrp_phone_level vrrp日志短信报警级别
 * @apiSuccess {Number} httpredirect_memory_enable httpredirect日志本地存储使能状态
 * @apiSuccess {Number} httpredirect_memory_level httpredirect日志本地存储级别
 * @apiSuccess {Number} httpredirect_syslog_enable httpredirect日志Syslog存储使能状态
 * @apiSuccess {Number} httpredirect_syslog_level httpredirect日志Syslog存储级别
 * @apiSuccess {Number} httpredirect_email_enable httpredirect日志E-mail报警使能状态
 * @apiSuccess {Number} httpredirect_email_level httpredirect日志E-mail报警级别
 * @apiSuccess {Number} httpredirect_phone_enable httpredirect日志短信报警使能状态
 * @apiSuccess {Number} httpredirect_phone_level httpredirect日志短信报警级别
 * @apiSuccess {Number} flood_memory_enable flood日志本地存储使能状态
 * @apiSuccess {Number} flood_memory_level flood日志本地存储级别
 * @apiSuccess {Number} flood_syslog_enable flood日志Syslog存储使能状态
 * @apiSuccess {Number} flood_syslog_level flood日志Syslog存储级别
 * @apiSuccess {Number} flood_email_enable flood日志E-mail报警使能状态
 * @apiSuccess {Number} flood_email_level flood日志E-mail报警级别
 * @apiSuccess {Number} flood_phone_enable flood日志短信报警使能状态
 * @apiSuccess {Number} flood_phone_level flood日志短信报警级别
 * @apiSuccess {Number} apt_memory_enable apt日志本地存储使能状态
 * @apiSuccess {Number} apt_memory_level apt日志本地存储级别
 * @apiSuccess {Number} apt_syslog_enable apt日志Syslog存储使能状态
 * @apiSuccess {Number} apt_syslog_level apt日志Syslog存储级别
 * @apiSuccess {Number} apt_email_enable apt日志E-mail报警使能状态
 * @apiSuccess {Number} apt_email_level apt日志E-mail报警级别
 * @apiSuccess {Number} apt_phone_enable apt日志短信报警使能状态
 * @apiSuccess {Number} apt_phone_level apt日志短信报警级别
 * @apiSuccess {Number} defense_memory_enable defense日志本地存储使能状态
 * @apiSuccess {Number} defense_memory_level defense日志本地存储级别
 * @apiSuccess {Number} defense_syslog_enable defense日志Syslog存储使能状态
 * @apiSuccess {Number} defense_syslog_level defense日志Syslog存储级别
 * @apiSuccess {Number} defense_email_enable defense日志E-mail报警使能状态
 * @apiSuccess {Number} defense_email_level defense日志E-mail报警级别
 * @apiSuccess {Number} defense_phone_enable defense日志短信报警使能状态
 * @apiSuccess {Number} defense_phone_level defense日志短信报警级别
 * @apiSuccess {Number} config_memory_enable config日志本地存储使能状态
 * @apiSuccess {Number} config_memory_level config日志本地存储级别
 * @apiSuccess {Number} config_syslog_enable config日志Syslog存储使能状态
 * @apiSuccess {Number} config_syslog_level config日志Syslog存储级别
 * @apiSuccess {Number} config_email_enable config日志E-mail报警使能状态
 * @apiSuccess {Number} config_email_level config日志E-mail报警级别
 * @apiSuccess {Number} config_phone_enable config日志短信报警使能状态
 * @apiSuccess {Number} config_phone_level config日志短信报警级别
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"data":,
 *		{
 * 			"ddos_memory_enable": "1",
 * 			"ddos_memory_level": "1",
 * 			"ddos_syslog_enable": "1",
 * 			"ddos_syslog_level": "1",
 * 			"ddos_email_enable": "1",
 * 			"ddos_email_level": "1",
 * 			"ddos_phone_enable": "1",
 * 			"ddos_phone_level": "1",
 * 			"interface_memory_enable": "1",
 * 			"interface_memory_level": "1",
 * 			"interface_syslog_enable": "1",
 * 			"interface_syslog_level": "1",
 * 			"interface_email_enable": "1",
 * 			"interface_email_level": "1",
 * 			"interface_phone_enable": "1",
 * 			"interface_phone_level": "1",
 * 			"nat_memory_enable": "1",
 * 			"nat_memory_level": "1",
 * 			"nat_syslog_enable": "1",
 * 			"nat_syslog_level": "1",
 * 			"nat_email_enable": "1",
 * 			"nat_email_level": "1",
 * 			"nat_phone_enable": "1",
 * 			"nat_phone_level": "1",
 * 			"ha_memory_enable": "1",
 * 			"ha_memory_level": "1",
 * 			"ha_syslog_enable": "1",
 * 			"ha_syslog_level": "1",
 * 			"ha_email_enable": "1",
 * 			"ha_email_level": "1",
 * 			"ha_phone_enable": "1",
 * 			"ha_phone_level": "1",
 * 			"system_memory_enable": "1",
 * 			"system_memory_level": "1",
 * 			"system_syslog_enable": "1",
 * 			"system_syslog_level": "1",
 * 			"system_email_enable": "1",
 * 			"system_email_level": "1",
 * 			"system_phone_enable": "1",
 * 			"system_phone_level": "1",
 * 			"ospf_memory_enable": "1",
 * 			"ospf_memory_level": "1",
 * 			"ospf_syslog_enable": "1",
 * 			"ospf_syslog_level": "1",
 * 			"ospf_email_enable": "1",
 * 			"ospf_email_level": "1",
 * 			"ospf_phone_enable": "1",
 * 			"ospf_phone_level": "1",
 * 			"rip_memory_enable": "1",
 * 			"rip_memory_level": "1",
 * 			"rip_syslog_enable": "1",
 * 			"rip_syslog_level": "1",
 * 			"rip_email_enable": "1",
 * 			"rip_email_level": "1",
 * 			"rip_phone_enable": "1",
 * 			"rip_phone_level": "1",
 * 			"qos_memory_enable": "1",
 * 			"qos_memory_level": "1",
 * 			"qos_syslog_enable": "1",
 * 			"qos_syslog_level": "1",
 * 			"qos_email_enable": "1",
 * 			"qos_email_level": "1",
 * 			"qos_phone_enable": "1",
 * 			"qos_phone_level": "1",
 * 			"bgp_memory_enable": "1",
 * 			"bgp_memory_level": "1",
 * 			"bgp_syslog_enable": "1",
 * 			"bgp_syslog_level": "1",
 * 			"bgp_email_enable": "1",
 * 			"bgp_email_level": "1",
 * 			"bgp_phone_enable": "1",
 * 			"bgp_phone_level": "1",
 * 			"scan_memory_enable": "1",
 * 			"scan_memory_level": "1",
 * 			"scan_syslog_enable": "1",
 * 			"scan_syslog_level": "1",
 * 			"scan_email_enable": "1",
 * 			"scan_email_level": "1",
 * 			"scan_phone_enable": "1",
 * 			"scan_phone_level": "1",
 * 			"filter_memory_enable": "1",
 * 			"filter_memory_level": "1",
 * 			"filter_syslog_enable": "1",
 * 			"filter_syslog_level": "1",
 * 			"filter_email_enable": "1",
 * 			"filter_email_level": "1",
 * 			"filter_phone_enable": "1",
 * 			"filter_phone_level": "1",
 * 			"ips_memory_enable": "1",
 * 			"ips_memory_level": "1",
 * 			"ips_syslog_enable": "1",
 * 			"ips_syslog_level": "1",
 * 			"ips_email_enable": "1",
 * 			"ips_email_level": "1",
 * 			"ips_phone_enable": "1",
 * 			"ips_phone_level": "1",
 * 			"av_memory_enable": "1",
 * 			"av_memory_level": "1",
 * 			"av_syslog_enable": "1",
 * 			"av_syslog_level": "1",
 * 			"av_email_enable": "1",
 * 			"av_email_level": "1",
 * 			"av_phone_enable": "1",
 * 			"av_phone_level": "1",
 * 			"ac_memory_enable": "1",
 * 			"ac_memory_level": "1",
 * 			"ac_syslog_enable": "1",
 * 			"ac_syslog_level": "1",
 * 			"ac_email_enable": "1",
 * 			"ac_email_level": "1",
 * 			"ac_phone_enable": "1",
 * 			"ac_phone_level": "1",
 * 			"instant_message_memory_enable": "1",
 * 			"instant_message_memory_level": "1",
 * 			"instant_message_syslog_enable": "1",
 * 			"instant_message_syslog_level": "1",
 * 			"instant_message_email_enable": "1",
 * 			"instant_message_email_level": "1",
 * 			"instant_message_phone_enable": "1",
 * 			"instant_message_phone_level": "1",
 * 			"search_engine_memory_enable": "1",
 * 			"search_engine_memory_level": "1",
 * 			"search_engine_syslog_enable": "1",
 * 			"search_engine_syslog_level": "1",
 * 			"search_engine_email_enable": "1",
 * 			"search_engine_email_level": "1",
 * 			"search_engine_phone_enable": "1",
 * 			"search_engine_phone_level": "1",
 * 			"social_network_memory_enable": "1",
 * 			"social_network_memory_level": "1",
 * 			"social_network_syslog_enable": "1",
 * 			"social_network_syslog_level": "1",
 * 			"social_network_email_enable": "1",
 * 			"social_network_email_level": "1",
 * 			"social_network_phone_enable": "1",
 * 			"social_network_phone_level": "1",
 * 			"email_memory_enable": "1",
 * 			"email_memory_level": "1",
 * 			"email_syslog_enable": "1",
 * 			"email_syslog_level": "1",
 * 			"email_email_enable": "1",
 * 			"email_email_level": "1",
 * 			"email_phone_enable": "1",
 * 			"email_phone_level": "1",
 * 			"file_transfer_memory_enable": "1",
 * 			"file_transfer_memory_level": "1",
 * 			"file_transfer_syslog_enable": "1",
 * 			"file_transfer_syslog_level": "1",
 * 			"file_transfer_email_enable": "1",
 * 			"file_transfer_email_level": "1",
 * 			"file_transfer_phone_enable": "1",
 * 			"file_transfer_phone_level": "1",
 * 			"online_shopping_memory_enable": "1",
 * 			"online_shopping_memory_level": "1",
 * 			"online_shopping_syslog_enable": "1",
 * 			"online_shopping_syslog_level": "1",
 * 			"online_shopping_email_enable": "1",
 * 			"online_shopping_email_level": "1",
 * 			"online_shopping_phone_enable": "1",
 * 			"online_shopping_phone_level": "1",
 * 			"app_others_memory_enable": "1",
 * 			"app_others_memory_level": "1",
 * 			"app_others_syslog_enable": "1",
 * 			"app_others_syslog_level": "1",
 * 			"app_others_email_enable": "1",
 * 			"app_others_email_level": "1",
 * 			"app_others_phone_enable": "1",
 * 			"app_others_phone_level": "1",
 * 			"web_access_memory_enable": "1",
 * 			"web_access_memory_level": "1",
 * 			"web_access_syslog_enable": "1",
 * 			"web_access_syslog_level": "1",
 * 			"web_access_email_enable": "1",
 * 			"web_access_email_level": "1",
 * 			"web_access_phone_enable": "1",
 * 			"web_access_phone_level": "1",
 * 			"persist_memory_enable": "1",
 * 			"persist_memory_level": "1",
 * 			"persist_syslog_enable": "1",
 * 			"persist_syslog_level": "1",
 * 			"persist_email_enable": "1",
 * 			"persist_email_level": "1",
 * 			"persist_phone_enable": "1",
 * 			"persist_phone_level": "1",
 * 			"httpswitch_memory_enable": "1",
 * 			"httpswitch_memory_level": "1",
 * 			"httpswitch_syslog_enable": "1",
 * 			"httpswitch_syslog_level": "1",
 * 			"httpswitch_email_enable": "1",
 * 			"httpswitch_email_level": "1",
 * 			"httpswitch_phone_enable": "1",
 * 			"httpswitch_phone_level": "1",
 * 			"httperrcode_memory_enable": "1",
 * 			"httperrcode_memory_level": "1",
 * 			"httperrcode_syslog_enable": "1",
 * 			"httperrcode_syslog_level": "1",
 * 			"httperrcode_email_enable": "1",
 * 			"httperrcode_email_level": "1",
 * 			"httperrcode_phone_enable": "1",
 * 			"httperrcode_phone_level": "1",
 * 			"httpcache_memory_enable": "1",
 * 			"httpcache_memory_level": "1",
 * 			"httpcache_syslog_enable": "1",
 * 			"httpcache_syslog_level": "1",
 * 			"httpcache_email_enable": "1",
 * 			"httpcache_email_level": "1",
 * 			"httpcache_phone_enable": "1",
 * 			"httpcache_phone_level": "1",
 * 			"sslaccelerate_memory_enable": "1",
 * 			"sslaccelerate_memory_level": "1",
 * 			"sslaccelerate_syslog_enable": "1",
 * 			"sslaccelerate_syslog_level": "1",
 * 			"sslaccelerate_email_enable": "1",
 * 			"sslaccelerate_email_level": "1",
 * 			"sslaccelerate_phone_enable": "1",
 * 			"sslaccelerate_phone_level": "1",
 * 			"httpcompress_memory_enable": "1",
 * 			"httpcompress_memory_level": "1",
 * 			"httpcompress_syslog_enable": "1",
 * 			"httpcompress_syslog_level": "1",
 * 			"httpcompress_email_enable": "1",
 * 			"httpcompress_email_level": "1",
 * 			"httpcompress_phone_enable": "1",
 * 			"httpcompress_phone_level": "1",
 * 			"httpfirewall_memory_enable": "1",
 * 			"httpfirewall_memory_level": "1",
 * 			"httpfirewall_syslog_enable": "1",
 * 			"httpfirewall_syslog_level": "1",
 * 			"httpfirewall_email_enable": "1",
 * 			"httpfirewall_email_level": "1",
 * 			"httpfirewall_phone_enable": "1",
 * 			"httpfirewall_phone_level": "1",
 * 			"httpcc_memory_enable": "1",
 * 			"httpcc_memory_level": "1",
 * 			"httpcc_syslog_enable": "1",
 * 			"httpcc_syslog_level": "1",
 * 			"httpcc_email_enable": "1",
 * 			"httpcc_email_level": "1",
 * 			"httpcc_phone_enable": "1",
 * 			"httpcc_phone_level": "1",
 * 			"oneconnect_memory_enable": "1",
 * 			"oneconnect_memory_level": "1",
 * 			"oneconnect_syslog_enable": "1",
 * 			"oneconnect_syslog_level": "1",
 * 			"oneconnect_email_enable": "1",
 * 			"oneconnect_email_level": "1",
 * 			"oneconnect_phone_enable": "1",
 * 			"oneconnect_phone_level": "1",
 * 			"hm_memory_enable": "1",
 * 			"hm_memory_level": "1",
 * 			"hm_syslog_enable": "1",
 * 			"hm_syslog_level": "1",
 * 			"hm_email_enable": "1",
 * 			"hm_email_level": "1",
 * 			"hm_phone_enable": "1",
 * 			"hm_phone_level": "1",
 * 			"vs_memory_enable": "1",
 * 			"vs_memory_level": "1",
 * 			"vs_syslog_enable": "1",
 * 			"vs_syslog_level": "1",
 * 			"vs_email_enable": "1",
 * 			"vs_email_level": "1",
 * 			"vs_phone_enable": "1",
 * 			"vs_phone_level": "1",
 * 			"vlink_memory_enable": "1",
 * 			"vlink_memory_level": "1",
 * 			"vlink_syslog_enable": "1",
 * 			"vlink_syslog_level": "1",
 * 			"vlink_email_enable": "1",
 * 			"vlink_email_level": "1",
 * 			"vlink_phone_enable": "1",
 * 			"vlink_phone_level": "1",
 * 			"lcin_memory_enable": "1",
 * 			"lcin_memory_level": "1",
 * 			"lcin_syslog_enable": "1",
 * 			"lcin_syslog_level": "1",
 * 			"lcin_email_enable": "1",
 * 			"lcin_email_level": "1",
 * 			"lcin_phone_enable": "1",
 * 			"lcin_phone_level": "1",
 * 			"gtm_memory_enable": "1",
 * 			"gtm_memory_level": "1",
 * 			"gtm_syslog_enable": "1",
 * 			"gtm_syslog_level": "1",
 * 			"gtm_email_enable": "1",
 * 			"gtm_email_level": "1",
 * 			"gtm_phone_enable": "1",
 * 			"gtm_phone_level": "1",
 * 			"dns_memory_enable": "1",
 * 			"dns_memory_level": "1",
 * 			"dns_syslog_enable": "1",
 * 			"dns_syslog_level": "1",
 * 			"dns_email_enable": "1",
 * 			"dns_email_level": "1",
 * 			"dns_phone_enable": "1",
 * 			"dns_phone_level": "1",
 * 			"httpxssql_memory_enable": "1",
 * 			"httpxssql_memory_level": "1",
 * 			"httpxssql_syslog_enable": "1",
 * 			"httpxssql_syslog_level": "1",
 * 			"httpxssql_email_enable": "1",
 * 			"httpxssql_email_level": "1",
 * 			"httpxssql_phone_enable": "1",
 * 			"httpxssql_phone_level": "1",
 * 			"linkthreshold_memory_enable": "1",
 * 			"linkthreshold_memory_level": "1",
 * 			"linkthreshold_syslog_enable": "1",
 * 			"linkthreshold_syslog_level": "1",
 * 			"linkthreshold_email_enable": "1",
 * 			"linkthreshold_email_level": "1",
 * 			"linkthreshold_phone_enable": "1",
 * 			"linkthreshold_phone_level": "1",
 * 			"dnsproxy_memory_enable": "1",
 * 			"dnsproxy_memory_level": "1",
 * 			"dnsproxy_syslog_enable": "1",
 * 			"dnsproxy_syslog_level": "1",
 * 			"dnsproxy_email_enable": "1",
 * 			"dnsproxy_email_level": "1",
 * 			"dnsproxy_phone_enable": "1",
 * 			"dnsproxy_phone_level": "1",
 * 			"vrrp_memory_enable": "1",
 * 			"vrrp_memory_level": "1",
 * 			"vrrp_syslog_enable": "1",
 * 			"vrrp_syslog_level": "1",
 * 			"vrrp_email_enable": "1",
 * 			"vrrp_email_level": "1",
 * 			"vrrp_phone_enable": "1",
 * 			"vrrp_phone_level": "1",
 * 			"httpredirect_memory_enable": "1",
 * 			"httpredirect_memory_level": "1",
 * 			"httpredirect_syslog_enable": "1",
 * 			"httpredirect_syslog_level": "1",
 * 			"httpredirect_email_enable": "1",
 * 			"httpredirect_email_level": "1",
 * 			"httpredirect_phone_enable": "1",
 * 			"httpredirect_phone_level": "1",
 * 			"flood_memory_enable": "1",
 * 			"flood_memory_level": "1",
 * 			"flood_syslog_enable": "1",
 * 			"flood_syslog_level": "1",
 * 			"flood_email_enable": "1",
 * 			"flood_email_level": "1",
 * 			"flood_phone_enable": "1",
 * 			"flood_phone_level": "1",
 * 			"apt_memory_enable": "1",
 * 			"apt_memory_level": "1",
 * 			"apt_syslog_enable": "1",
 * 			"apt_syslog_level": "1",
 * 			"apt_email_enable": "1",
 * 			"apt_email_level": "1",
 * 			"apt_phone_enable": "1",
 * 			"apt_phone_level": "1",
 * 			"defense_memory_enable": "1",
 * 			"defense_memory_level": "1",
 * 			"defense_syslog_enable": "1",
 * 			"defense_syslog_level": "1",
 * 			"defense_email_enable": "1",
 * 			"defense_email_level": "1",
 * 			"defense_phone_enable": "1",
 * 			"defense_phone_level": "1",
 * 			"config_memory_enable": "1",
 * 			"config_memory_level": "1",
 * 			"config_syslog_enable": "1",
 * 			"config_syslog_level": "1",
 * 			"config_email_enable": "1",
 * 			"config_email_level": "1",
 * 			"config_phone_enable": "1",
 * 			"config_phone_level": "1"
 *		}
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

class SyslogFilterController extends mController{	
	public $module = 'syslog_filter';
}

