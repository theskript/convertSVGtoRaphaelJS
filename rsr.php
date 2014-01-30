<?php
/*************************************************************************************************
 * 
 * 
 *         Send a remote svg file to readysetraphael.com using cURL and get raphaeljs code.
 * 
 * 
*************************************************************************************************/


$file = $_GET['url'];
if (!file_exists('_rsr')) {
    mkdir('_rsr', 0777, true);
}
$tmpfile = uniqid(rand(), true) . '.svg';
file_put_contents('_rsr/'.$tmpfile, fopen('http://'.$file.'', 'r'));
$filepath = realpath('./_rsr/'.$tmpfile);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.readysetraphael.com/submit.php');
$post_data = array(
        'MAX_FILE_SIZE' => '100000000', 
        'image' => '@'.$filepath,
        'submit' => 'Send'
);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
$html = curl_exec($ch);
if (preg_match("/<div id=\"output\">([^`]*?)<\/div>/", $html, $match)) {
        $data = ltrim(rtrim(trim($match[1])));
}
$file = array_reverse(explode('/',$file));
$file = substr($file[0],0,-4);
$file = preg_replace("/[^A-Za-z0-9 ]/", '', $file);
$data = str_replace('rsr',$file,$data);
echo '<pre>' . $data . '</pre>';
unlink($filepath);

?>
