<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));
echo MY_CONTROLLER.'</br>';
echo '__FILE__ : '.__FILE__.'</br>';
echo 'PATHINFO_BASENAME : '. PATHINFO_BASENAME .'</br>';
echo '<hr>dirname() : '.dirname(__FILE__).'</br>';
echo 'basename() :'.basename(__FILE__).'</br>';
echo 'parse_url() : '.parse_url(__FILE__).'</br>';
echo 'realpath() : '.realpath(__FILE__).'</br>';
?>
<pre>
<?php print_r(pathinfo(__FILE__));?>
</pre>
