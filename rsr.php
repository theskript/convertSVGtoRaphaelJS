<?php
/*************************************************************************************************
 * 
 * 
 *         Send a remote svg file to readysetraphael.com using cURL and get raphaeljs code.
 * 
 * 
*************************************************************************************************/

class svg
{
    private $file;
    private $dir;
    private $tmpfile;
    public function __construct($url,$dirname)
    {
        $this->file = $url;
        $this->dir = $dirname;
        $this->tmpfile = uniqid(rand(), true) . '.svg';
        if (!file_exists($this->dir)) 
        {
            mkdir($this->dir, 0777, true);
        }
        
    }
    
    public function getRaphaelJScode($filepath)
    {
        $ch = curl_init();
        $post_data = array(
            'MAX_FILE_SIZE' => '100000000', 
            'image' => '@'.$filepath,
            'submit' => 'Send'
        );
        
        curl_setopt($ch, CURLOPT_URL, 'http://www.readysetraphael.com/submit.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        
        $html = curl_exec($ch);
        
        if (preg_match("/<div id=\"output\">([^`]*?)<\/div>/", $html, $match)) 
        {
            $data = ltrim(rtrim(trim($match[1])));
        }
        
        $file = array_reverse(explode('/',$this->file));
        $file = substr($file[0],0,-4);
        $file = preg_replace("/[^A-Za-z0-9 ]/", '', $file);
        $data = str_replace('rsr',$file,$data);
        return $data;
    }
    
    public function convert()
    {
        file_put_contents(''.$this->dir.'/'.$this->tmpfile, fopen('http://'.$this->file.'', 'r'));
        $filepath = realpath('./'.$this->dir.'/'.$this->tmpfile);
        $output = $this->getRaphaelJScode($filepath)
        return $output;
        exit();
    }
    
    public function __destruct()
    {
        unlink($filepath);
    }
}

$svg = new svg();
echo '<pre>';
echo $svg->convert($_GET['url'],'tmpdir');
echo '</pre>';
?>
