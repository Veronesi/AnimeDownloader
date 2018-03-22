<?php
	print "hola";
	pclose(popen("start /B php -f D:/test.php 2>nul >nul", "r"));
?>