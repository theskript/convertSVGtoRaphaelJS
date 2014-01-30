<?php
/*************************************************************************************************
 * 
 * 
 *         Send a remote svg file to readysetraphael.com using cURL and get RaphaelJS code.
 * 
 * 
*************************************************************************************************/

class svg
{
    private $file;
    private $tmpfile;
    private $filepath;
    
	// Set Core Variables
    public function __construct($url)
    {
        $this->file = $url;
        $this->tmpfile = uniqid(rand(), true) . '.svg';
    }
    
    // Send our temp SVG file to ReadySetRaphael and get back RaphaelJS code
	public function getRaphaelJScode()
	{        
		
		$ch = curl_init();
        $post_data = array(
            'MAX_FILE_SIZE' => '100000000', 
            'image' => '@'.$this->filepath,
            'submit' => 'Send'
        );
        
        curl_setopt($ch, CURLOPT_URL, 'http://www.readysetraphael.com/submit.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "".uniqid(rand(), true).".txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "".uniqid(rand(), true).".txt");
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
    
    // Store Temp SVG file on server && Return RaphaelJS output	
	public function convert()
    {       
		file_put_contents(''.$this->tmpfile, fopen('http://'.$this->file, 'r'));
        $this->filepath = realpath('./'.$this->tmpfile);
        return $this->getRaphaelJScode();
        exit();
    }
    
    // Remove Temp SVG from server
	public function __destruct()
    {        
		unlink($this->filepath);
    }
}

$svg = new svg($_GET['url']);
echo '<pre>';
echo $svg->convert();
echo '</pre>';

?>
