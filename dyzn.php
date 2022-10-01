<?php
// 基于github dyzn项目开发
//https://gitee.com/csitian_admin_admin/dytq?_from=gitee_search

$appId = '1'; //对应自己的appId 微信公众号平台自行注册
$appSecret = '2'; //对应自己的appSecret
$wxgzhurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appId . "&secret=" . $appSecret;
$access_token_Arr = https_request($wxgzhurl);
$access_token = json_decode($access_token_Arr, true);
$ACCESS_TOKEN = $access_token['access_token']; //ACCESS_TOKEN


// 什么时候恋爱的(格式别错)
$lovestart = strtotime('2022-10-01');
$end = time();
$love = ceil(($end - $lovestart) / 86400);

// 下一个生日是哪一天(格式别错)
$birthdaystart = strtotime('2022-10-01');
$end = time();
$diff_days = ($birthdaystart - $end);
$birthday = (int)($diff_days/86400);
$birthday = str_replace("-", "", $birthday);


$tianqiurl = 'https://v0.yiketianqi.com/api?unescape=1&version=v62&appid=56483371&appsecret=Gv9nR8H7&city=安宁'; //修改为自己的 使用实况天气接口v62 在https://tianqiapi.com/自行注册
$tianqiapi = https_request($tianqiurl);
$tianqi = json_decode($tianqiapi, true);

$qinghuaqiurl = 'https://v2.alapi.cn/api/qinghua?token='; //修改为自己的 在 http://www.alapi.cn/ 注册填入token即可 不填也能用
$qinghuaapi = https_request($qinghuaqiurl);
$qinghua = json_decode($qinghuaapi, true);


// 你自己的一句话
$yjh = ''; //可以留空 也可以写上一句

$touser = 'ohRVn6_y2a3DXrNgp7W88zfijIJ0';  //这个填你女朋友的openid
$data = array(
    'touser' => $touser,
    'template_id' => "CRrf2sRrOgkekfBWfWXgXVPECJvg8_39rmn48rEqswY", //改成自己的模板id，在微信后台模板消息里查看
    'data' => array(
        'first' => array(
            'value' => $yjh,
            'color' => "##993366"
        ),
        'keyword1' => array(
            'value' => $tianqi['wea_day'],
            'color' => "#0066CC"
        ),
        'keyword2' => array(
            'value' => $tianqi['tem'],
            'color' => "#99CCCC"
        ),
        'keyword3' => array(
            'value' => $love . '天',
            'color' => "#990000"
        ),
        'keyword4' => array(
            'value' => $birthday . '天',
            'color' => "#CC0000"
        ),
	'keyword5' => array(
            'value' => $tianqi['air_tips'],
            'color' => "#333399"
        ),
'keyword6' => array(
            'value' => $tianqi['air_level'],
            'color' => "#CC6699"
        ),
'keyword7' => array(
            'value' => $tianqi['visibility'],
            'color' => "#00FF33"
        ),
'keyword8' => array(
            'value' => $tianqi['humidity'],
            'color' => "#003300"
        ),
'keyword9' => array(
            'value' => $tianqi['win_meter'],
            'color' => "#336600"
        ),
'keyword10' => array(
            'value' => $tianqi['win'],
            'color' => "#DDDDDD"
        ),
        'remark' => array(
            'value' => $qinghua['data']['content'],
            'color' => "#FF0000"
        ),
    )
);

// 下面这些就不需要动了————————————————————————————————————————————————————————————————————————————————————————————
$json_data = json_encode($data);
$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $ACCESS_TOKEN;
$res = https_request($url, urldecode($json_data));
$res = json_decode($res, true);

if ($res['errcode'] == 0 && $res['errcode'] == "ok") {
    echo "发送成功！<br/>";
}else {
        echo "发送失败！请检查代码！！！<br/>";
}
function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}