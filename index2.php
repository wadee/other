<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no"/>
    <title>金融街盖楼</title>
    <link rel="icon" type="image/GIF" href="res/favicon.ico"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="x5-fullscreen" content="true"/>
    <meta name="360-fullscreen" content="true"/>
    <style>
        body, canvas, div {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            -khtml-user-select: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
    </style>
</head>
<body style="padding:0; margin: 0; background: #000;">
<canvas id="gameCanvas" width="320" height="480"></canvas>
<script>
    var wx = {}, cc = {};
    cc.OrbitCamera = cc.CatmullRomBy = cc.CatmullRomTo = cc.CardinalSplineBy = cc.CardinalSplineTo = {};
</script>
<script src="src/engine.js"></script>
<script src="src/game.min.js"></script>
<script src="jquery.min.js" type="text/javascript"></script> 
<div style="display:none">
</div>

<script language=javascript>
 function getQueryString(name) { 
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
	var r = window.location.search.substr(1).match(reg); 
	if (r != null) return unescape(r[2]); return null; 
} 

checkwgateid();
countFeed();
// baoming();

function countFeed(){
			$.ajax({
				type: 'GET',
				url: "http://xz.lifejrj.cn:8080/api/countFeed.json",
				data: {
					mobile : getQueryString("mobile"),
				},
				success: function(data) {

					checkcount(data);

					// if(data != true )
					// {

					//    form_show();
					   
					// }

				},
				error: function() {
					return null;
				}
			});
	}

function checkcount(countFeed){

		//检查是否可玩
		$.ajax({
					type: 'GET',
					url: "action/checkcount.php",
					data: {
						mobile: getQueryString("mobile"),
						ingame:0,
					},
					success: function(data) {

						var checkcount = data;

						if ((checkcount - 3) <= countFeed) {
							//do nothing
							//location.href="index2.php?mobile="+getQueryString("mobile");
						}else{
							location.href="index.php?mobile="+getQueryString("mobile");
						}

						// if(eval('('+data+')')!="0")
						// console.log(eval('('+data+')'));
						// if(data != null)
						// {
						//    location.href="index2.php?wgateid="+getQueryString("wgateid");
						// }
						// else
						// {
						// 	share_show();
						// 	return false;
						// }
					},
					error: function() {
						// alert("checkcount出错了");
						return 0;
					}
				});
}

function checkwgateid(){
	$.ajax({
					type: 'GET',
					url: "action/checkwgateid.php",
					data: {
						mobile: getQueryString("mobile")	
					},
					success: function(data) {
						if(data == 0){
							addcount();
						}
					},
					error: function() {
						alert("checkcount出错了");
						return null;
					}
				});	
}

function addcount(){

		$.ajax({
					type: 'GET',
					url: "action/addcount.php",
					data: {
						mobile: getQueryString("mobile")	
					},
					success: function(data) {
					  // location.href="index2.php?mobile="+getQueryString("mobile");
					},
					error: function() {
						alert("checkcount出错了");
						return null;
					}
				});
}

function baoming() {
            var tel = getQueryString("mobile");
            var telReg = /^(?:13\d|15\d|18\d)\d{5}(\d{3}|\*{3})$/;

            if (tel == '') {
                alert('请填写手机号！');
                return;
            }
            if (!telReg.test(tel)) {
                alert('请填写正确的手机号！');
                return;
            }
			
			//提交
			 $.ajax({
			type: 'GET',
			url: "http://xz.lifejrj.cn:8080/api/hasUser.json",
			data: {
				mobile:tel
			},
			success: function(data) {
				if(eval('('+data+')')==true)
				{
			       // form_close();
			       window.fromapp = true;
				}
				else
				{
					window.fromapp = false;
				}
			},
			error: function() {
				window.fromapp = true;
			}
		});
	
        }

		var mebtnopenurl = 'http://www.weiadmin.cn/index.php?g=Wap&m=Index&a=index&token=xkfcxd1402407094&from=singlemessage&isappinstalled=0';

				
		function goHome(){
			window.location=mebtnopenurl;
		}
		function clickMore(){
			if((window.location+"").indexOf("zf",1)>0){
				window.location = "http://www.weiadmin.cn/index.php?g=Wap&m=Index&a=index&token=xkfcxd1402407094&from=singlemessage&isappinstalled=0";
			 }
			 else{
				goHome();
			 }
		}
		function dp_share(){
			//document.title ="我把金融街堆到了"+myData.score+"层，谁敢跟我一比？";
			//document.getElementById("share").style.display="";
			
		}
		function dp_Ranking(){
			window.location=mebtnopenurl;
		}

		function showAd(){
		}
		function hideAd(){
		}
		
		</script>
		<div id=share style="display: none">
			<img width=100% src="share.png"
				style="position: fixed; z-index: 9999; top: 0; left: 0; display: "
				ontouchstart="document.getElementById('share').style.display='none';" />
		</div>
		<div style="display: none;">
		
		
			<script type="text/javascript">
            var myData = { gameid: "mtl" };
            var domain = ["oixm.cn", "hiemma.cn", "peagame.net"][parseInt(Math.random() * 3)];
			//window.shareData.timeLineLink = "http://"+ parseInt(Math.random()*100000) +"."+ myData.gameid +"."+domain+"/gamecenter.html?gameid=" + myData.gameid + (localStorage.myuid ? "&uid=" + localStorage.myuid : "");
			function dp_submitScore(score){
				if(score>0){
					dp_share();
				}
			}
			
			function submitscore(score){
			  

					$.ajax({
								type: 'GET',
								url: "action/submitscore.php",
								data: {
									mobile: getQueryString("mobile"),
									score:score
								},
								success: function(data) {
										
								},
								error: function() {
									alert("submitscore出错啦");
									
								}
							});
			
			
			}
			function onShareComplete(res) {

	        }
			/**
*
*  Base64 encode / decode
*
*  @author haitao.tu
*  @date   2010-04-26
*  @email  tuhaitao@foxmail.com
*
*/

function Base64() {
 
	// private property
	_keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
 
	// public method for encoding
	this.encode = function (input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;
		input = _utf8_encode(input);
		while (i < input.length) {
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}
			output = output +
			_keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
			_keyStr.charAt(enc3) + _keyStr.charAt(enc4);
		}
		return output;
	}
 
	// public method for decoding
	this.decode = function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
		while (i < input.length) {
			enc1 = _keyStr.indexOf(input.charAt(i++));
			enc2 = _keyStr.indexOf(input.charAt(i++));
			enc3 = _keyStr.indexOf(input.charAt(i++));
			enc4 = _keyStr.indexOf(input.charAt(i++));
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
			output = output + String.fromCharCode(chr1);
			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
		}
		output = _utf8_decode(output);
		return output;
	}
 
	// private method for UTF-8 encoding
	_utf8_encode = function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
		for (var n = 0; n < string.length; n++) {
			var c = string.charCodeAt(n);
			if (c < 128) {
				utftext += String.fromCharCode(c);
			} else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			} else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
		return utftext;
	}
 
	// private method for UTF-8 decoding
	_utf8_decode = function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
		while ( i < utftext.length ) {
			c = utftext.charCodeAt(i);
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			} else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			} else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
		}
		return string;
	}
}


			</script>
 
</body>
</html>
