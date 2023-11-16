<?php
error_reporting(0);
# PHP7+
$browser = $_SERVER['HTTP_USER_AGENT'];
$dateTime = date('Y/m/d G:i:s');
$clientIP = $_SERVER['HTTP_CLIENT_IP'] 
    ?? $_SERVER["HTTP_CF_CONNECTING_IP"] # when behind cloudflare
    ?? $_SERVER['HTTP_X_FORWARDED'] 
    ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
    ?? $_SERVER['HTTP_FORWARDED'] 
    ?? $_SERVER['HTTP_FORWARDED_FOR'] 
    ?? $_SERVER['REMOTE_ADDR'] 
    ?? '0.0.0.0';

# Earlier than PHP7
$clientIP = '0.0.0.0';

if (isset($_SERVER['HTTP_CLIENT_IP'])) {
    $clientIP = $_SERVER['HTTP_CLIENT_IP'];
} elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    # when behind cloudflare
    $clientIP = $_SERVER['HTTP_CF_CONNECTING_IP']; 
} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
    $clientIP = $_SERVER['HTTP_X_FORWARDED'];
} elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
    $clientIP = $_SERVER['HTTP_FORWARDED_FOR'];
} elseif (isset($_SERVER['HTTP_FORWARDED'])) {
    $clientIP = $_SERVER['HTTP_FORWARDED'];
} elseif (isset($_SERVER['REMOTE_ADDR'])) {
    $clientIP = $_SERVER['REMOTE_ADDR'];
}
$clientIP = str_replace(":", "", $clientIP);

$dino = shell_exec('curl http://ipinfo.io/'.$clientIP);
$dina = '
{
  "ip": "195.55.116.75",
  "city": "Barcelona",
  "region": "Catalonia",
  "country": "ES",
  "loc": "41.3888,2.1590",
  "org": "AS3352 TELEFONICA DE ESPANA",
  "postal": "08001",
  "timezone": "Europe/Madrid",
  "readme": "https://ipinfo.io/missingauth"
}</br>';
$str = str_replace('"readme": "https://ipinfo.io/missingauth"', "", $dino);
$str0 = str_replace("  \"", "<tr><td>", $str);
$str01   = str_replace('",', "</td></tr>", $str0);
$str1  = str_replace('{', "", $str01);
$str2  = str_replace('}', "", $str1);
$str3  = str_replace('ip', "<b>Ip</b>", $str2);
$str4  = str_replace('city', "<b>City</b>", $str3);
$str5  = str_replace('region',"<b>Region</b>", $str4);
$str6  = str_replace('country',"<b>Country</b>", $str5);
$str7  = str_replace('loc',"<b>Location</b>", $str6);
$str8  = str_replace('org',"<b>Organitzation</b>", $str7);
$str9  = str_replace('postal',"<b>Postal</b>", $str8);
$str10 = str_replace('timezone',"<b>Timezone</b>", $str9);
$str11 = str_replace('readme',"<b>Readme</b>", $str10);
//$str12 = str_replace('{ "status": 404, "error": { "title": "Wrong ip", "message": "Please provide a valid IP address" } }', "IP ERROR", $str11);
//$str14   = str_replace(',', "</br>", $str13);
$str13   = str_replace('"', "", $str11);
$str15   = str_replace('Almondigas', "Albondiga", $str13);
$str17   = str_replace(': ES',': ES <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0c/Spain_flag_waving_icon.svg/1280px-Spain_flag_waving_icon.svg.png" height="15px">',$str15);
$str18   = str_replace('ESPANA', "ESPAÑA", $str17);
$str19   = str_replace('Catalonia','Catalonia <img src="https://freesvg.org/img/1442600697.png" height="15px">',$str18);
$str20   = str_replace("TELEFONICA",'MOVISTAR <img src="https://www.movistar.es/estaticos/img/ico-app-mi-movistar-2017.png" height="15px">',$str19);
$last = $str20;
//$last = $dino;
echo "<style>td{border: 1px red solid;color:white;}body{background-color:black;color:white;}</style><body><table><tr><table>".$last."</table></tr></table></body>";
shell_exec("echo ".$clientIP." >> /var/www/html/ip/ip.txt");
shell_exec("echo IP: ".$clientIP." Time: ".$dateTime." User Agent:".$browser." >> /var/www/html/ip/ip.html");
shell_exec('curl http://ipinfo.io/'.$clientIP." >> /var/www/html/ip/".$clientIP.".txt");
//shell_exec('copy ip.txt ./ip/ip'.$clientIP.".txt");
?>
