<?php
$configh = fopen('io/d/config.txt', 'r');
$configh1 = fread($configh, filesize('io/d/config.txt'));
$config = explode('<config>', $configh1);
$sitename = $config[0];
$siteaddress = $config[1];
fclose($configh);
 ?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $sitename ?></title>
</head>
<body>
  <iframe src="io/?o=1" width="100%" height="75%" style="border:none;">
  <p>Your browser does not support iframes.</p>
</iframe>

<iframe src="io/?i" width="100%" height="20%" style="border:none;">
<p>Your browser does not support iframes.</p>
</iframe>
</body>
</html>
