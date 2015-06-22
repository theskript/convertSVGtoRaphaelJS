convertSVGtoRaphaelJS
=====================

Send a remote svg file to readysetraphael.com using cURL and get raphaeljs code.

Usage Example:
=====================

It's simple: Initiate the class and enjoy!

<pre>
require_once("svg.class.php");
$svg = new svg($_GET['url']);
echo $svg->convert();
</pre>
