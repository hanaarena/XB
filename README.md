PROJECT XB
==

Sina Weibo Web client built with PHP-SDK


##如题  / DESCRIPTION
* 这是一个「伪」新浪微博Web客户端(因为目前只有读取微博功能╮(╯_╰)╭)
* 使用PHP-SDK + jQuery Mobile开发，鉴于未来可能转向多平台，可以使用其他SDK再改造，[我是传送门](http://open.weibo.com/wiki/SDK)
* 因为申请的Appkey没有通过官方审核，所以目前只有相关人士能使用。
* 测试地址 [http://yangculer.com/wb](http://yangculer.com/wb)

##更新日记  / UPDATE LOG
* 使用jQuery的`$.ajax()`调用微博API，以获取已登录用户的头像和获取当前登录用户及其所关注用户的最新微博
  P.S.:调用用户相关的API需要`access_token`，PHP-SDK封装了获取`access_token`的方法 → `$token['access_token']`
