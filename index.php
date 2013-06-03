<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );

?>
<html>
	<head>		
		<link rel="stylesheet" href="jquery.mobile-1.2.1.min.css" />
		<script src="js/jquery-1.8.3.min.js"></script>
		<script src="js/jquery.mobile-1.2.1.min.js"></script>
        <style type="text/css">
			.person_info {
				position:fixed;
				left:46%;
				padding-top:19%;
			}
		</style>
    </head>
    <body>
        <div style="position:absolute; width:95px; height:92px;">
        	<a href="<?=$code_url?>"><img class="person_info" src="resource/images/2.png" onMouseOver="this.src='resource/images/2.gif'" onMouseOut="this.src='resource/images/2.png'" /></a>
        </div>       
    </body>
</html>