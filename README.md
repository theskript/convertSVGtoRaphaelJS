convertSVGtoRaphaelJS
=====================

Send a remote svg file to readysetraphael.com using cURL and get raphaeljs code.

Usage Example:
=====================

It's simple: Initiate the class and enjoy!
<pre>
<?php
require_once("svg.class.php");
$svg = new svg($_GET['url']);
echo $svg->convert();
</pre>

http://www.theskript.com/demos/rsr.php?url= [URL GOES HERE, NO HTTP://]

http://www.theskript.com/demos/rsr.php?url=www.sitepoint.com/wp-content/themes/sitepoint/assets/svg/sitepoint.svg
