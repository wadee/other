/**
 * ��֡�������
 * @author aidenxiong
 * @modify 2014/06/04 ����֡��ͼƬ�Ĳ����޸�Ϊimg��ǩ����ʽ���������Ի��ⲿ��������³������׵����
 * @modify 2014/06/20 �޸�Ϊÿ��ֻ�޸�img��src  �������޸�����img�Ľڵ�  ��Ч��������׵�����
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
		resource : [],  //������ݵ�Ϊһ��ͼƬ����ô��Ϊ�ǲ���sprite����ʽ����
		totalFrame : 10,  //֡��
		spriteDirect : 0, //ʹ��spriteͼƬ��ʱ�򣬿���ָ��spriteƽ�̷���  1Ϊ����  2Ϊ����    ���ֵΪ0   ��ô���ݳ���Ƚ����ж�
		index : 0, //Ĭ����ʾ�ڼ�֡
		playTime : 1000, //����ִ���¼�
		aniType : 'linear', //����켣
		onLoading : emptyFunc, //��Դ����ʱ�Ļص�
		onComplete : emptyFunc,  //��Դ������ɺ�Ļص�
		onPlaying : emptyFunc,  //ÿ�����һ��ͼƬ�л�ʱ�Ļص�
		aniComplete : emptyFunc //ÿ���Զ����һ�ζ������ź�Ļص�
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

		//��������
		var resource, isLoading, curIndex, resLen, totalFrame,frameStyles, contSize, isAnimate, aid, filmEl;

		//������ʼ��
		opts = util.extend(defaults, opts);
		resource = [].concat(opts.resource);
		totalFrame = opts.totalFrame;
		isLoading = true;
		curIndex = 0;
		resLen = resource.length;
		frameStyles = [];
		contSize = {};
		isAnimate = false;
		aid = null; //�������е�ID

		//��ԴԤ����
		util.resLoader(resource, opts.onLoading, function(size){
			opts.onComplete(size);
			isLoading = false;
			if(resLen == 1){
				totalFrame = opts.totalFrame;
				//����
				var lateral = function(){
					contSize.width = size.width/totalFrame;
					contSize.height = size.height;
					for (var i = 0; i < totalFrame; i++) {
						frameStyles.push("background:url(" + resource[0] + ") -" + (contSize.width*i) + "px 0 no-repeat;");
					};
				}
				//����
				var portrait = function(){
					contSize.width = size.width;
					contSize.height = size.height/totalFrame;
					for (var i = 0; i < totalFrame; i++) {
						frameStyles.push("background:url(" + resource[0] + ") 0 -" + (contSize.height*i) + "px no-repeat;");
					};
				}
				if(opts.spriteDirect == 1){ //����
					lateral();
				}else if(opts.spriteDirect == 2){ //����
					portrait();
				}else{
					size.width > size.height ? lateral() : portrait();
				}
			}else{  //�����Դ��������������ô���ò����е�totalFrame�������ã���ʵ�ʴ������Դ��Ϊ׼
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
			if(index < 0){  //����������Ӻ�����ǰ��
				index = index - Math.floor(index/totalFrame) * totalFrame;
			}else{
				index = index % totalFrame;
			}
			if(resLen == 1){
				node.style.cssText = "width:"+contSize.width+'px;height:'+contSize.height+'px;'+frameStyles[index];
			}else{
				//ֻ�޸�src�������  ��Ч�����������
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
		 * ͨ������ͣ���ڵڼ���λ��������λ����λ��
		 * @param  {Number} index ��Ҫ���ŵ���λ��
		 * @param  {String} opt   ���ŵķ���   ��ǰ��forward  ���backward
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
		 * ͨ���涨���ŵ�֡��������
		 * @param  {Number} num ��Ҫ���ŵ�֡��
		 * @param  {String} opt ���ŵķ���   ��ǰ��forward  ���backward
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