<!DOCTYPE html>
<!-- saved from url=(0034)http://liveapp.cn/HTML/dev_qqGame/ -->
<html style="height: 614px;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="author" content="Tencent-TGideas">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="Description" content="">
<meta name="Keywords" content="">

<title>金融街盖楼</title>
<link href="./qqgame_files/style.css" rel="stylesheet" type="text/css">

<div style="display:none">
<?php
require "wxconfig.php" ;
require "config.php" ;
?>
<script type="text/javascript">
</script>
</div>
<style>html,body,.section,.sec{height:100%;}.loading{width:100%;height:100%;opacity:1;position:absolute;top:0px;left:0px;z-index:9999;background-color:#FDCBC0;}.loading .inner{width:240px;height:120px;position:absolute;top:50%;left:50%;margin:-80px 0 0 -120px;text-align:center;color:#055570;font-size:14px;}.loading .loading_rate{color:#055570;font-size:25px;font-weight:bold;line-height:40px;display:block;}.loading_img{margin:0 auto;width:162px;}


.userrank tr{
width:80%;
font-size:14px;
font-weight:bold;
border-bottom:1px solid #E5D1AD;
height:35px;
}
.userrank .td1{
width:10%;


}

.userrank .td2{
width:50%;
text-align:center;

}

.userrank .td3{
width:40%;
text-align:right;

}



</style>
</head>
<body>
<div class="wraper ovh" id="wraper">
<div class="loading" id="loading" style="display: none;">
<div class="inner">
<p class="loading_img">Loading...</p>
<p class="loading_rate" id="loading_rate">100%</p>
</div>
</div>
<div class="container" id="container">
<div class="pa tips" id="tips"></div>
<div class="main pr sec-02-show" id="main" style="-webkit-transition: -webkit-transform 300ms ease-out; transition: -webkit-transform 300ms ease-out; -webkit-transform: translate3d(0, -614px, 0);">




<section class="sec " id="sec-1">

<img class="p1t1 p1z2 show" src="./qqgame_files/p1_bg.jpg" width="100%" alt="">

<div style="width:100%;position:fixed;bottom:12%;left:0; z-index:10000">
 <a href="http://xz.lifejrj.cn/erweima1"><img src="./qqgame_files/app.png" style="width:100%"></a>
</div> 

<div class="yxsm" id="yxsm">
<img class="darkmask" src="./qqgame_files/mask.png" alt="" width="100%">
<img class="yxsm_kuang" src="./qqgame_files/rankrule.png" alt="" width="90%">

<a href="javascript:void(0);" onclick="yxsm_close();">
<img class="yxsm_close" src="./qqgame_files/rule_close.png" alt="" width="22%">
</a>
</div>


<div class="userform">
<img class="darkmask" src="./qqgame_files/mask.png" alt="" width="100%">
<div class="form_kuang">
<img src="./qqgame_files/rank.png" alt="" width="90%">
<div class="rankcontent">

<div style="width:68%; height:180px;overflow-y:scroll;">
<table class="userrank" style="width:100%;">

<?php
	$rank=1;
	$strSql="select phonenum,score from ".$tablename." order by score desc limit 50";
	$result=mysql_query($strSql,$myconn);
	while($row = mysql_fetch_array($result))
	{
?>

	<tr>
	<td class="td1"><?echo $rank;?></td>
	<td class="td2"><?echo "**".substr($row["phonenum"],-4)?></td>
	<td class="td3"><?echo $row["score"]?>楼</td>
	</tr>
<?php 
$rank++;
}
?>

</table>
</div>
<div class="rankbottombtn button ">你的总成绩<span id="user_score" style="color:red"></span>楼,排名第<span id="user_rank" style="color:red"></span>位</div>
<a href="javascript:void(0);" onclick="yxsm_show();"><div class="rankbottombtn button">活动详细规则 ></div></a>

</div>
</div>
</section>

</div>
</div>
</div>
<div class="mask flexcontainer" id="mask" style="display: none">
<div class="mask-box">
<div class="mask-pic"><i></i></div>
<span>为了更好的体验，请将手机/平板竖过来</span>
</div>
</div>
<div class="dialog" id="test1" onclick="closeDialog()" style="display:none">
<div class="dia-con"></div>
</div>
 <script src="jquery.min.js" type="text/javascript"></script> 
<script type="text/javascript">

form_show();
setRankText();
//yxsm_show();
function yxsm_show(){
    form_close();
	$(".yxsm").show();
	
}
function yxsm_close(){
	$(".yxsm").hide();
	form_show();
	
}
function hdgz_show(){
	$("#hdgz").show();
	
}
function hdgz_close(){
	$("#hdgz").hide();
	
}

function form_show(){
	$(".userform").show();
	
}
function form_close(){
    $(".userform").hide();
}

function setRankText(){

		$.ajax({
			type: 'GET',
			url: "action/getuserrank.php",
			data: {
				wgateid: getQueryString("wgateid")
			},
			success: function(data) {
			           var info = eval('('+data+')');					   
						document.getElementById("user_score").innerText=info.score;
						document.getElementById("user_rank").innerText=info.rank;
			},
			error: function() {
				alert("getuserrank出错啦");
				
			}
		});

}
function checkcount(){

		//检查是否可玩
		$.ajax({
					type: 'GET',
					url: "action/checkcount.php",
					data: {
						wgateid: getQueryString("wgateid")
					},
					success: function(data) {

						if(eval('('+data+')')!="0")
						{
						   location.href="index2.php?wgateid="+getQueryString("wgateid");
						}
						else
						{
							alert("您的游戏机会已用完，分享后可获得一次游戏机会！");
							return false;
						}
					},
					error: function() {
						alert("checkcount出错了");
						return null;
					}
				});
}


function checkwgateid(){
			$.ajax({
				type: 'GET',
				url: "action/checkwgateid.php",
				data: {
					wgateid: getQueryString("wgateid")
				},
				success: function(data) {

					if(eval('('+data+')')!=true)
					{

					   form_show();
					   
					}

				},
				error: function() {
					alert("checkwgateid出错了");
					return null;
				}
			});
	

}

        function baoming() {
            var tel = $("#phone").val();
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
			url: "action/submit.php",
			data: {
				wgateid: getQueryString("wgateid"),
				phone:tel
			},
			success: function(data) {

				if(eval('('+data+')')==true)
				{

			       form_close();
				   
				}
				else
				{
					alert("报名失败！原因:"+data);
				}
			},
			error: function() {
				alert("submit出错啦");
				return null;
			}
		});
	
        }
		

function getQueryString(name) { 
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
	var r = window.location.search.substr(1).match(reg); 
	if (r != null) return unescape(r[2]); return null; 
} 
</script>


<script src="./qqgame_files/film.js"></script>
<script>
(function(m) {
	if (m) {
		return
	}
	var vendors = ["webkit", "moz", "o"];
	var m = {
		extend: function(destination, source, override, replacer) {
			if (override === undefined) {
				override = true
			}
			for (var property in source) {
				if (override || !(property in destination)) {
					if (replacer) {
						replacer(property)
					} else {
						destination[property] = source[property]
					}
				}
			}
			return destination
		},
		support: {
			translate3d: (function() {
				var sTranslate3D = "translate3d(0px, 0px, 0px)";
				var eTemp = document.createElement("div");
				eTemp.style.cssText = " -moz-transform:" + sTranslate3D + "; -ms-transform:" + sTranslate3D + "; -o-transform:" + sTranslate3D + "; -webkit-transform:" + sTranslate3D + "; transform:" + sTranslate3D;
				var rxTranslate = /translate3d\(0px, 0px, 0px\)/g;
				var asSupport = eTemp.style.cssText.match(rxTranslate);
				var bHasSupport = (asSupport !== null && asSupport.length == 1);
				return bHasSupport
			})()
		},
		css: function(obj, prop, value) {
			var needVendor = /transform/i;
			if (needVendor.test(prop)) {
				for (var i = 0; i < vendors.length; i++) {
					obj.style[vendors[i] + prop.substr(0, 1).toUpperCase() + prop.substr(1)] = value
				}
			}
			obj.style[prop] = value
		}
	};
	window.m = m
})(window.m);
m.Slide = function(config) {
	this.config = m.extend(m.extend({}, m.Slide.config), config, true);
	this.init()
};
m.Slide.config = {
	touchMove: false,
	animTime: 500,
	touchDis: 40,
	direction: "x",
	touchSpeed: 1,
	currentClass: "current",
	progressBar: false
};
m.Slide.prototype = {
	init: function() {
		var self = this;
		var c = self.config;
		self._data = {};
		self.target = c.target;
		self.length = self.target.length;
		self.trigger = c.trigger;
		self.num = self.target.length;
		self.wrap = self.target[0].parentNode;
		if (m.support.translate3d) {
			self.wrap.style.webkitTransition = "-webkit-transform " + c.animTime + "ms ease-out"
		}
		m.css(self.wrap, "transform", "translate(0,0)");
		self.width = self.wrap.parentNode.clientWidth;
		if (c.progressBar === true) {
			var progressBar = document.createElement("ul");
			progressBar.classList.add("progress-bar");
			for (var i = 0; i < self.length; i++) {
				var child = document.createElement("li");
				progressBar.appendChild(child)
			}
			self.progressBar = self.wrap.parentNode.appendChild(progressBar).childNodes
		}
		self._attach();
		self.playTo(0)
	},
	_attach: function() {
		var self = this;
		var c = self.config;
		window.addEventListener("resize", self.update.bind(self));
		if (self.trigger) {
			var len = self.trigger.length;
			for (var i = 0; i < len; i++) {
				(function(i) {
					self.trigger[i].addEventListener("touchend", function(e) {
						self.playTo(i)
					})
				})(i)
			}
		}
		var d = self._data;
		var locked = false;
		var touchDirection;
		var touchMove, touchEnd;
		if (c.touchMove) {
			self.wrap.addEventListener("touchstart", function(e) {
				if (c.ontouchstart && c.ontouchstart.apply(self, [e]) === false) {
					return false
				}
				d.pageX = e.touches[0].pageX;
				d.pageY = e.touches[0].pageY;
				self.wrap.style.webkitTransitionDuration = "0ms";
				self.wrap.addEventListener("touchmove", touchMove);
				self.wrap.addEventListener("touchend", touchEnd);
				touchDirection = ""
			})
		}
		touchMove = function(e) {
			var tips = document.getElementById("tips");
			d.disX = e.touches[0].pageX - d.pageX;
			d.disY = e.touches[0].pageY - d.pageY;
			if (c.direction == "x") {
				d.dis = d.disX
			} else {
				d.dis = d.disY
			}
			if (!touchDirection) {
				if (Math.abs(d.disX / d.disY) > 1) {
					touchDirection = "x"
				} else {
					touchDirection = "y"
				}
			}
			if (c.ontouchmove && c.ontouchmove.apply(self, [d.dis, e]) === false) {
				return false
			}
			if (c.direction == touchDirection) {
				if (c.direction == "x") {
					m.css(self.wrap, "transform", "translate3d(" + (d.dis - self.target[self.current].offsetLeft) + "px,0,0)")
				} else {
					m.css(self.wrap, "transform", "translate3d(0," + (d.dis - self.target[self.current].offsetTop) + "px,0)")
				}
			}
		};
		touchEnd = function() {
			if (touchDirection && c.direction != touchDirection) {
				return
			}
			if (d.dis === undefined || isNaN(d.dis)) {
				d.dis = 0
			}
			self.wrap.style.webkitTransitionDuration = c.animTime + "ms";
			self.wrap.removeEventListener("touchmove", touchMove);
			self.wrap.removeEventListener("touchend", touchEnd);
			var isOK = true;
			if (c.ontouchend) {
				if (c.ontouchend.apply(self, [d.dis]) === false) {
					isOK = false
				}
			}
			if (!d.dis || (Math.abs(d.dis) < c.touchDis || !isOK)) {
				self.playTo(self.current);
				return
			}
			if (d.dis > 0) {
				document.getElementById("tips").style.top = "-36px";
				self.playTo(self.current - c.touchSpeed)
			} else {
				if (self.current == 8) {
					self.playTo(self.current);
					document.getElementById("tips").style.top = "0"
				} else {
					document.getElementById("tips").style.top = "-36px";
					self.playTo(self.current + c.touchSpeed)
				}
			}
			d.dis = 0
		};
		self.wrap.addEventListener("click", function(e) {
			c.onclick && c.onclick.call(self, e)
		})
	},
	playTo: function(i) {
		var self = this;
		var c = self.config;
		self.wrap.style.webkitTransitionDuration = c.animTime + "ms";
		if (c.onchangebefore) {
			if (c.onchangebefore.apply(self, [i]) === false) {
				return
			}
		}
		if (i >= self.num - 1) {
			i = self.num - 1
		}
		if (i < 0) {
			i = 0
		}
		if (m.support.translate3d) {
			if (c.direction == "x") {
				m.css(self.wrap, "transform", "translate3d(" + (-self.target[i].offsetLeft) + "px,0,0)")
			} else {
				m.css(self.wrap, "transform", "translate3d(0," + (-self.target[i].offsetTop) + "px,0)")
			}
		} else {
			if (c.direction == "x") {
				m.css(self.wrap, "transform", "translate(" + (-self.target[i].offsetLeft) + "px,0)")
			} else {
				m.css(self.wrap, "transform", "translate(0," + (-self.target[i].offsetTop) + "px)")
			}
		}
		if (i === self.current) {
			return
		}
		if (self.trigger && self.trigger[self.current]) {
			self.trigger[self.current].classList.remove(c.currentClass)
		}
		if (self.progressBar && self.progressBar[self.current]) {
			self.progressBar[self.current].classList.remove(c.currentClass)
		}
		self.prevPage = self.current;
		self.current = i;
		if (self.trigger && self.trigger[self.current]) {
			self.trigger[self.current].classList.add(c.currentClass)
		}
		if (self.progressBar && self.progressBar[self.current]) {
			self.progressBar[self.current].classList.add(c.currentClass)
		}
		if (c.lazyClass) {
			self.lazy(i)
		}
		window.setTimeout(function() {
			c.onchange && c.onchange.apply(self, [i])
		}, c.animTime)
	},
	prev: function() {
		this.playTo(this.current - 1)
	},
	next: function() {
		this.playTo(this.current + 1)
	},
	update: function(e) {
		var self = this;
		self.width = self.wrap.parentNode.clientWidth
	},
	lazy: function(i) {
		var lazyElems = [];
		targetWrap = this.target[i];
		if (targetWrap.classList.contains(this.config.lazyClass)) {
			lazyElems.push(targetWrap)
		}
		var lazyChildren = Array.prototype.slice.call(targetWrap.querySelectorAll("." + this.config.lazyClass), 0);
		lazyElems = lazyElems.concat(lazyChildren);
		for (var j = 0; j < lazyElems.length; j++) {
			var elem = lazyElems[j];
			var url = elem.getAttribute("data-url");
			if (url) {
				if (/img/i.test(elem.tagName)) {
					elem.src = url
				} else {
					elem.style.backgroundImage = "url(" + url + ")"
				}
				elem.removeAttribute("data-url")
			}
		}
	}
};
</script>
<script>
if (typeof (pgvMain) =='function') {pgvMain();}
</script>
<script>

function checkDirect() {
	if (window.orientation == 180 || window.orientation == 0) {
		$(".mask").hide();
	}
	if (window.orientation == 90 || window.orientation == -90) {
		$(".mask").show();
	}
}
document.addEventListener('DOMContentLoaded', function() {
	checkDirect();
	window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", checkDirect, false);
	document.documentElement.style.height = window.innerHeight + 'px';

	function gid(o) {
		return document.getElementById(o);
	}
	var section = gid("section");
	window.addEventListener('load', function() {
		document.documentElement.style.height = window.innerHeight + 'px';
	});
	var timer;
	var sections = document.querySelectorAll('#main .sec');

	function checkSection(n) {
		gid("main").className = "main pr sec-0" + (n + 1) + "-show ";

		function runClick() {
			n = n + 1;
			pgvSendClick({
				hottag: 'a20140729bkl.screen0' + n + '.arrived'
			})
		}
		runClick()
	}


	var slide = new m.Slide({
		target: sections,
		touchMove: false,
		direction: 'y',
		animTime: 300,
		onchange: function(n) {
			gid("main").className = "main pr sec-0" + (n + 1) + "-show ";
			if (n == 1) {
				$("#sec-1").removeClass("crack_on");
				$("#sec-1").css("background", "url(imgs/p1_bg.png) center top repeat");
				$("#test").hide();
			}
		}
	});


	function s4Change() {
		var section4 = gid("section4");
		if (section4.classList[2] != "s4_change1") {
			section4.classList.remove("s4_change2")
			section4.classList.add("s4_change1");
		} else {
			section4.classList.remove("s4_change1")
			section4.classList.add("s4_change2")
		}
	}

	function showPage() {
		gid("load").parentNode.removeChild(gid("load"));
		gid("section").style.display = "block";
		setPageHeight();
		slide.init();
	}

	function setPageHeight() {
		for (var i = 0; i < sections.length; i++) {
			sections[i].style.height = window.innerHeight + 'px';
		}
		gid("section").style.height = window.innerHeight * sections.length + "px";
	}

	var path = "qqgame_files/";
	var resource = [];
	for (var i = 1; i < 26; i++) {};
	var createFilm = function(node, res) {
			return film(node, {
				resource: res,
				aniType: "easeInOut",
				aniComplete: function() {
					slide.next();
				}
			})
		}
	var multiplePic = createFilm(document.getElementById('test'), resource);
});
var SHAKE_THRESHOLD = 300;
var last_update = 0;
var x = y = z = last_x = last_y = last_z = 0,
	moneyatuo, lock = 0;

function deviceMotionHandler(eventData) {
	var acceleration = eventData.accelerationIncludingGravity;
	var curTime = new Date().getTime();
	if ((curTime - last_update) > 100) {
		var diffTime = curTime - last_update;
		last_update = curTime;
		x = acceleration.x;
		y = acceleration.y;
		z = acceleration.z;
		var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;
		if (speed > SHAKE_THRESHOLD) {
			if ($("#main").hasClass("sec-06-show") && lock == 0) {
				lock = 1;
				if (document.getElementById("box1").className == "box1 cls_fadein") {
					document.getElementById("box1").style.zIndex = 1;
					document.getElementById("box2").style.zIndex = 2;
					document.getElementById("box1").className = "box1 cls_fadeout";
					document.getElementById("box2").className = "";
					document.getElementById("box2").className = "box2 cls_fadein";
				} else {
					document.getElementById("box1").style.zIndex = 2;
					document.getElementById("box2").style.zIndex = 1;
					document.getElementById("box1").className = "box1 cls_fadein";
					document.getElementById("box2").className = "box2 cls_fadeout";
				}
				setTimeout(function() {
					lock = 0;
				}, 1000);
			}
		}
		last_x = x;
		last_y = y;
		last_z = z;
	}
}
var load = document.getElementById('loading');
var imgPath = 'qqgame_files/';
var loadingPage = (function() {
	var imgSources = ['p1_bg.jpg'];
	for (var i = 0; i < imgSources.length; i++) {
		imgSources[i] = (imgPath + imgSources[i]);
	};
	var loadImage = function(path, callback) {
			var img = new Image();
			img.onload = function() {
				img.onload = null;
				callback(path);
			}
			img.src = path;
		}
	var imgLoader = function(imgs, callback) {
			var len = imgs.length,
				i = 0;
			while (imgs.length) {
				loadImage(imgs.shift(), function(path) {
					callback(path, ++i, len);
				})
			}
		}
	var rateNum = document.getElementById('loading_rate');
	var bar = document.getElementById('bar');
	var percent = 0;
	imgLoader(imgSources, function(path, curNum, total) {
		percent = curNum / total;
		rateNum.innerHTML = Math.floor(percent * 100) + '%';
		if (percent == 1) {
			setTimeout(function() {
				$('#loading').css('display', 'none');
				$("#sec-1").addClass("sec01_show");
			}, 500);
		}
	});
})();

</script>

<script>

</script>


</body></html>