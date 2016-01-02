<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php
require("wxsdk.php");
?>
<script>
	wx.config({
		debug: false,
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp: <?php echo $signPackage["timestamp"];?>,
		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		signature: '<?php echo $signPackage["signature"];?>',
		jsApiList: [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			'onMenuShareQQ',
			'onMenuShareWeibo',
			'hideMenuItems',
			'showMenuItems',
			'hideAllNonBaseMenuItem',
			'showAllNonBaseMenuItem',
			'translateVoice',
			'startRecord',
			'stopRecord',
			'onRecordEnd',
			'playVoice',
			'pauseVoice',
			'stopVoice',
			'uploadVoice',
			'downloadVoice',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage',
			'getNetworkType',
			'openLocation',
			'getLocation',
			'hideOptionMenu',
			'showOptionMenu',
			'closeWindow',
			'scanQRCode',
			'chooseWXPay',
			'openProductSpecificView',
			'addCard',
			'chooseCard',
			'openCard'
		  ]
	});
	
window.wxshareData = {
			title: '金融街盖楼',
			desc: '金融街由你盖，参与盖楼游戏，获得海景房一套！',
			link: 'http://www.weixingate.com/gate.php?back=http%3A%2F%2Fwx.wonder4.cn%2Fapp%2Fjinrongjie%2Findex.php&force=1',
			imgUrl: 'http://wx.wonder4.cn/app/jinrongjie/icon.jpg',
			success: function(){window.isshare=true;}
		};
	wx.ready(function () {
		
		wx.onMenuShareAppMessage(window.wxshareData);
		wx.onMenuShareTimeline(window.wxshareData);
	});

	wx.error(function (res) {
	  alert(res.errMsg);
	});
</script>
