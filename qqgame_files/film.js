/**
 * 逐帧动画组件
 * @author aidenxiong
 * @modify 2014/06/04 将单帧但图片的播放修改为img标签的形式，这样可以缓解部分浏览器下出现闪白的情况
 * @modify 2014/06/20 修改为每次只修改img的src  而不是修改整个img的节点  有效解决了闪白的问题
 */
(function(scope){
	var util = {
		imgSingleLoader : function(src, cb){
			var img = new Image();
			img.onload = function(){
				cb({
					width : img.width,
					height : img.height
				});
				img.onload = null;
			}
			img.src = src;
		},
		resLoader : function(res, singleComplete, allComplete){
			var len = res.length, count = 0;
			for (var i = 0; i < len; i++) {
				(function(src){
					util.imgSingleLoader(src, function(size){
						singleComplete(++count, len, size);
						if(count == len){
							allComplete(size);
						}
					})
				})(res[i]);
			};
		},
		extend : function(oSource, eSoruce){
			var temp = {};
			for(var k in oSource){
				temp[k] = oSource[k];
			}
			for(var j in eSoruce){
				temp[j] = eSoruce[j];
			}
			return temp;
		},
		animation : (function(){
			var lastTime = 0;
			var vendors = ['ms', 'moz', 'webkit', 'o'];
			var request, cancel;
			for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
				request = window[vendors[x]+'RequestAnimationFrame'];
				cancel = window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
			}

			if (!request) {
				request = function(callback, element) {
					var currTime = new Date().getTime();
					var timeToCall = Math.max(0, 16 - (currTime - lastTime));
					var id = window.setTimeout(function() { 
						callback(currTime + timeToCall); 
					},timeToCall);
					lastTime = currTime + timeToCall;
					return id;
				};
			}

			if (!cancel) {
				cancel = function(id) {
					clearTimeout(id);
				};
			}

			return {
				"request" : request,
				"cancel" : cancel
			}
		})()
	};
	var emptyFunc = function(){};
	var defaults = {
		resource : [],  //如果传递的为一张图片，那么认为是采用sprite的形式进行
		totalFrame : 10,  //帧数
		spriteDirect : 0, //使用sprite图片的时候，可以指明sprite平铺方向  1为横向  2为纵向    如果值为0   那么根据长宽比进行判断
		index : 0, //默认显示第几帧
		playTime : 1000, //滚动执行事件
		aniType : 'linear', //运算轨迹
		onLoading : emptyFunc, //资源加载时的回调
		onComplete : emptyFunc,  //资源加载完成后的回调
		onPlaying : emptyFunc,  //每次完成一张图片切换时的回调
		aniComplete : emptyFunc //每次自动完成一次动画播放后的回调
	}
	var animation = {
		'linear' : function(t,b,c,d){ return c*t/d + b; },
		'easeIn': function(t,b,c,d){
			return c*(t/=d)*t + b;
		},
		'easeOut': function(t,b,c,d){
			return -c *(t/=d)*(t-2) + b;
		},
		'easeInOut': function(t,b,c,d){
			if ((t/=d/2) < 1) return c/2*t*t + b;
			return -c/2 * ((--t)*(t-2) - 1) + b;
		}
	}
	var film = scope.film = function(node, opts){

		//变量定于
		var resource, isLoading, curIndex, resLen, totalFrame,frameStyles, contSize, isAnimate, aid, filmEl;

		//变量初始化
		opts = util.extend(defaults, opts);
		resource = [].concat(opts.resource);
		totalFrame = opts.totalFrame;
		isLoading = true;
		curIndex = 0;
		resLen = resource.length;
		frameStyles = [];
		contSize = {};
		isAnimate = false;
		aid = null; //动画运行的ID

		//资源预加载
		util.resLoader(resource, opts.onLoading, function(size){
			opts.onComplete(size);
			isLoading = false;
			if(resLen == 1){
				totalFrame = opts.totalFrame;
				//横向
				var lateral = function(){
					contSize.width = size.width/totalFrame;
					contSize.height = size.height;
					for (var i = 0; i < totalFrame; i++) {
						frameStyles.push("background:url(" + resource[0] + ") -" + (contSize.width*i) + "px 0 no-repeat;");
					};
				}
				//纵向
				var portrait = function(){
					contSize.width = size.width;
					contSize.height = size.height/totalFrame;
					for (var i = 0; i < totalFrame; i++) {
						frameStyles.push("background:url(" + resource[0] + ") 0 -" + (contSize.height*i) + "px no-repeat;");
					};
				}
				if(opts.spriteDirect == 1){ //横向
					lateral();
				}else if(opts.spriteDirect == 2){ //纵向
					portrait();
				}else{
					size.width > size.height ? lateral() : portrait();
				}
			}else{  //如果资源数超过两个，那么配置参数中的totalFrame不起作用，已实际传入的资源数为准
				totalFrame = resLen;
				contSize = size;
				filmEl = document.createElement('img');
				node.appendChild(filmEl);
				for (var i = 0; i < totalFrame; i++) {
					frameStyles.push(resource[i]);
				};
			}
			that.jumpTo(opts.index);
		});

		var formatOpt = function(opt){
			var tempObj = {}
			if(typeof opt == 'string'){
				tempObj.direction = opt;
			}
			tempObj = util.extend(opts, opt);
			tempObj.direction = tempObj.direction == 'backward' ? 'backward' : 'forward';
			return tempObj
		}

		var that = {}
		that.jumpTo = function(index){
			if(isLoading) return;
			if(index < 0){  //负数的情况从后面往前数
				index = index - Math.floor(index/totalFrame) * totalFrame;
			}else{
				index = index % totalFrame;
			}
			if(resLen == 1){
				node.style.cssText = "width:"+contSize.width+'px;height:'+contSize.height+'px;'+frameStyles[index];
			}else{
				//只修改src的情况下  有效解决闪白问题
				filmEl.src = frameStyles[index];
			}
			// node.style.cssText = "width:"+contSize.width+'px;height:'+contSize.height+'px;'+frameStyles[index];
			curIndex = index;
			opts.onPlaying(curIndex);
			return that;
		}
		that.next = function(){
			that.jumpTo(curIndex + 1);
			return that;
		};
		that.prev = function(){
			that.jumpTo(curIndex - 1);
			return that;
		};
		/**
		 * 通过告诉停留在第几个位置上来定位滑动位置
		 * @param  {Number} index 需要播放到的位置
		 * @param  {String} opt   播放的方向   向前：forward  向后：backward
		 * @return {[type]}       [description]
		 */
		that.playByIndex = function(index, opt){
			opt = formatOpt(opt);
			var playNum = 0;
			index = index % totalFrame;
			if((opt.direction == 'forward' && curIndex >= index) || (opt.direction == 'backward' && curIndex <= index)){
				playNum = totalFrame - curIndex + index;
			}else{
				playNum = index - curIndex;
			}
			that.playByNum(playNum, opt);
			return that;
		};
		/**
		 * 通过规定播放的帧数来滑动
		 * @param  {Number} num 需要播放的帧数
		 * @param  {String} opt 播放的方向   向前：forward  向后：backward
		 * @return {[type]}     [description]
		 */
		that.playByNum = function(num, opt){
			aid && that.pause();
			opt = formatOpt(opt);
			var startTime = new Date().getTime();
			var endTime = startTime + opt.playTime;
			var aniFunc = typeof opt.aniType == 'function' ? opt.aniType : (animation[opt.aniType] || animation['linear']);
			var hasPlayedNum = 0, nextPlayTime = aniFunc(hasPlayedNum + 1, startTime, opt.playTime, num);
			(function loop(cTime){
				if(cTime >= nextPlayTime){
					hasPlayedNum++;
					nextPlayTime = aniFunc(hasPlayedNum + 1, startTime, opt.playTime, num);
					opt.direction == 'forward' ? that.next() : that.prev();
				}
				if(cTime <= endTime){
					aid = util.animation.request(loop);
				}else{
					aid = null;
					opt.aniComplete();
				}
			})(startTime);
			return that;
		}
		that.play = function(t, dir){
			aid && that.pause();
			var startTime = new Date().getTime(), lastTime = startTime;
			(function loop(cTime){
				if(cTime > lastTime + t){
					lastTime = cTime;
					dir == 'forward' ? that.next() : that.prev();
				}
				aid = util.animation.request(loop);
			})(startTime);
			return that;
		}
		that.pause = function(){
			util.animation.cancel(aid);
			aid = null;
			return that;
		}
		return that;
	}
})(this);/*  |xGv00|0c18de0606a354f4e2b7992aa95c8754 */