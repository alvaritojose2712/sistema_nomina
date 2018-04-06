<?php
require_once('./inc/functions.php');

   $qstring = $_SERVER['REQUEST_URI'];
       $clip_pos = strpos($qstring, '?');
       $destination = substr($qstring, $clip_pos+1);
       header("Location: $destination");
       exit;
?>

<html>
<head>
	
</head>
<br>
<blockquote>
<a href="<?php echo $url; ?>"><?php echo $url; ?></a>
</blockquote>
</html>