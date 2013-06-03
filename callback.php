<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$_SESSION['token'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	$at=$token['access_token'];
?>
		<link rel="stylesheet" href="jquery.mobile-1.2.1.min.css" />
		<script src="js/jquery-1.8.3.min.js"></script>
		<script src="js/jquery.mobile-1.2.1.min.js"></script>
        <style type="text/css">
			#person_info {
				position:fixed;
				left:42%;
				top:17%;
				width:100px !important;
				height:100px !important;display:
				overflow:hidden !important;
				border-radius:50px !important;
				box-shadow:0px 0px 6px rgba(0, 0, 0, 0.3);       
			}
			#fadingBarsG{
				position:fixed;
				top:22%;
				left:32%;
				width:240px;
				height:29px;
			}
			.fadingBarsG{
				position:absolute;
				top:0;
				background-color:#2C9DE8;
				width:29px;
				height:29px;
				-webkit-animation-name:bounce_fadingBarsG;
				-webkit-animation-duration:1s;
				-webkit-animation-iteration-count:infinite;
				-webkit-animation-direction:linear;
				-webkit-transform:scale(.3);
			}
			#fadingBarsG_1{
				left:0;
				-webkit-animation-delay:0.4s;
			}
			#fadingBarsG_2{
				left:30px;
				-webkit-animation-delay:0.5s;
			}
			#fadingBarsG_3{
				left:60px;
				-webkit-animation-delay:0.6s;
			}
			#fadingBarsG_4{
				left:90px;
				-webkit-animation-delay:0.7s;
			}
			#fadingBarsG_5{
				left:120px;
				-webkit-animation-delay:0.8s;
			}
			#fadingBarsG_6{
				left:150px;
				-webkit-animation-delay:0.9s;
			}
			#fadingBarsG_7{
				left:180px;
				-webkit-animation-delay:1s;
			}
			#fadingBarsG_8{
				left:210px;
				-webkit-animation-delay:1.1s;
			}
			@-webkit-keyframes bounce_fadingBarsG{
				0%{ -webkit-transform:scale(1); background-color:#2C9DE8;}
				100%{ -webkit-transform:scale(.3); background-color:#E04880;}
			}
			#thumb1 {position:absolute; float:left;left:2%;top:60px;max-height:80px;max-width:80px;}
			#thumb2 {position:absolute; float:left;left:2%;top:60px;max-height:80px;max-width:80px;}
			#heading{position:relative;float:left;left:10%;top:20px;font-size:16px;font-weight:bold;display:block;margin:.6em 0;text-overflow:ellipsis;overflow:hidden;white-space:nowrap}
			#desc{position:absolute;float:left;left:10%;top:110px;font-size:12px;font-weight:normal;display:block;margin:-.5em 0 .6em;text-overflow:ellipsis;overflow:hidden;white-space:nowrap}
		</style>
        <!-- BEGIN - 获取用户信息 -->
        <script type="text/javascript">
        $.ajax({   
    		url: "https://api.weibo.com/2/account/get_uid.json",  //获取用户uid
    		type: "GET",  
    		dataType: "jsonp",  
    		data: {  
        		access_token: "<? echo $at; ?>"
    		},  
    		success: function(data, textStatus, xhr){  
      			var uids = data.data.uid;    
				$.ajax({   
    				url: "https://api.weibo.com/2/users/show.json",   //获取用户头像
    				type: "GET",  
    				dataType: "jsonp",  
    				data: {  
        				access_token: "<? echo $at; ?>",
						uid:uids
    				},  
    				success: function(data, textStatus, xhr){  
      					var infoImg=data.data.avatar_large;
						/* var _url=data.data.profile_url;
						var str="http://weibo.com/"+_url;
						document.getElementById("person_url").href=str;	*/
				 		document.getElementById("person_info").src=infoImg;			
						$.ajax({   
    						url: "https://api.weibo.com/2/statuses/home_timeline.json",  //获取用户微博
    						type: "GET",  
    						dataType: "jsonp",  
    						data: {  
        						access_token: "<? echo $at; ?>"
    						},  
    						success: function(data, textStatus, xhr){  
      							var weibo = data.data.statuses;
     							var length = weibo.length;
      							var str= '';
								var wbPages= '';
								var biaozhi=1;
      							$.each(weibo,function(i){
          							w=weibo[i];
									str+='<ul data-role="listview" class="ui-listview">';
									str+='<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-btn-up-c"><div class="ui-btn-inner ui-li">';
          							str+='<div class="ui-btn-text">';
									str+='<a href="#wbPage" class="ui-link-inherit" data-transition="slide">';
									str+='<img src="'+w.user.profile_image_url+'" '+'class="ui-li-thumb">';
									str+='<h3 class="ui-li-heading">'+w.user.screen_name+'</h3>';
									str+='<p class="ui-li-desc">'+w.text+'</p></a></div></li></ul>';
      							});							
      							$("#wb_content").html(str);
								$("ul").click(function() {
									if(biaozhi==1) {
										$('._wbPage').remove();
										wbPages= '';
										var index=$("ul").index(this);
										wbPages+='<div class="_wbPage">';
										wbPages+='<img src="'+weibo[index].user.profile_image_url+'" '+'id="thumb1" />';
										wbPages+='<h3 id="heading">'+weibo[index].user.screen_name+'</h3>';
										wbPages+='<p id="desc">'+weibo[index].text+'</p></div>';
										$(wbPages).appendTo("#wbPage");
										biaozhi=0;
									}
									else if(biaozhi==0) {
										$('._wbPage').remove();
										wbPages= '';
										index=$("ul").index(this);
										wbPages+='<div class="_wbPage">';
										wbPages+='<img src="'+weibo[index].user.profile_image_url+'" '+'id="thumb2" />';
										wbPages+='<h3 id="heading">'+weibo[index].user.screen_name+'</h3>';
										wbPages+='<p id="desc">'+weibo[index].text+'</p></div>';
										$(wbPages).appendTo("#wbPage");
										biaozhi=1;
									}
								});								
    						}
						})			
    				}  
				}) 		  
    		}  
		});	
		</script>   
        <div data-role="page"><a id="person_url" href="#wb_content" data-transition="slidedown"><img id="person_info" /></a></div>
        <!-- END - 获取用户信息 -->        
        <!-- BEGIN - 我是loading -->
        <div data-role="page" id="loadings" >
        	<div id="fadingBarsG">
				<div id="fadingBarsG_1" class="fadingBarsG"></div>
				<div id="fadingBarsG_2" class="fadingBarsG"></div>
				<div id="fadingBarsG_3" class="fadingBarsG"></div>
				<div id="fadingBarsG_4" class="fadingBarsG"></div>
				<div id="fadingBarsG_5" class="fadingBarsG"></div>
				<div id="fadingBarsG_6" class="fadingBarsG"></div>
				<div id="fadingBarsG_7" class="fadingBarsG"></div>
				<div id="fadingBarsG_8" class="fadingBarsG"></div>
			</div>
        </div>
        <!-- END - 我是loading -->
        <!-- BEGIN - WeiboList -->
        <div data-role="page" id="wb_content">
        </div>
        <!-- END - WeiboList -->
        <!-- BEGIN 详细页 -->
        <div data-role="page" id="wbPage" data-add-back-btn="true">
			<div data-role="header" class="ui-header ui-bar-a" role="banner">
        	<a href="#" class="ui-btn-left ui-btn ui-btn-up-a ui-btn-icon-left ui-btn-corner-all ui-shadow" data-rel="back" data-icon="arrow-l" data-theme="a">
        	<span class="ui-btn-inner ui-btn-corner-all" aria-hidden="true">
            	<span class="ui-btn-text">Back</span>
            	<span class="ui-icon ui-icon-arrow-l ui-icon-shadow"></span>
            </span>
        	</a>
			<h1 class="ui-title" tabindex="0" role="heading" aria-level="1">wb_Page</h1>
			</div>
        </div>
        <!-- END 详细页 -->
<?php
} else {
?>
授权失败。
<?php
}
?>
