<?php
$host = $_GET['dst'];
unset($_GET['dst']);
$announce = $host."?".http_build_query($_GET);

$ses = curl_init($announce);
curl_setopt_array($ses, [
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT        => 5,
	CURLOPT_USERAGENT      => $_SERVER['HTTP_USER_AGENT'], // Может проверяться анонсером
]);
$result = curl_exec($ses);
$info = curl_getinfo($ses);
header("Content-Type: {$info['content_type']}", true, $info['http_code']);
print $result;

$logfile = __DIR__ . '/btlog/' . date('Y-m-d/U') . '.txt';
mkdir(dirname($logfile), 0777, true);

file_put_contents(
	$logfile,
	$announce."\n".$host."\n".$result,
	FILE_APPEND
);
//$homepage = file_get_contents($logfile);
//echo '<pre>';
//echo $homepage;
//echo '</pre>';
?>