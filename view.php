<?php 
/*
$WshShell = new COM("WScript.Shell"); 
$oExec = $WshShell->Run("D:/2806_1.mp4", 3, true); 
*/
	$link = $_GET['link'];
  pclose(popen("start /B $link 2>nul >nul", "r"));
?>
<script type="text/javascript">
	location.href = "/list_anime.php?code="+ <?php print $_GET['code']; ?> ;
</script>