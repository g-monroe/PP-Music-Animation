;(function(win, doc, $){
	'use strict';

	$.fn.backgroundScroll = function(options) {
		var $win = $(win);
		var $doc = $(doc);
		var $this = $(this);
		var setting = {
			unArrayOpt: ['duration', 'pattern', 'click'],
			dataScroll: 'data-scroll',
			bgImg: 'background-image',
			bgPos: 'background-position',
			bgRep: 'background-repeat'
		};

		// オプション指定がない場合はCSSを参照し取得する
		var getDefaultStyleValue = function ($this, option, property) {console.log(option);console.log(property);
			return (option === '') ? $this.css(property).split(',') : option;
		};

		// オプションから今回の値を取得
		var get_optionValue = function (num, option) {
			return option[num % option.length];
		};

		// スタイル設定
		var setBackgroundImage = function (setting, $this, pattern, images) {
			// 画像のパスをurl関数に変換
			images = $.map(images, function (img) {
				return 'url(' + img + ')';
			});
			$this
				.attr(setting.dataScroll, 'true')
				.css(setting.bgImg, images);
			if (!pattern){ $this.css(setting.bgRep, 'no-repeat'); }
		};

		var runScroll = function (setting, $this, opts) {
			// ポジション配列設定
			var posX = [];
			var posY = [];
			var posIndex = {x: 0, y: 1};
			var images = opts.img;

			// 初期のポジション取得し配列に追加
			var initialPos = $this.css(setting.bgPos).split(', ');
			var posLeng = initialPos.length;
			var imagesLeng = images.length;
			var imagesCount = 0;
			var selfPos = '' ;
			for (imagesCount; imagesCount < imagesLeng; imagesCount++) {
				selfPos = initialPos[imagesCount % posLeng].split(' ');
				posX.push(parseFloat(selfPos[posIndex.x]));
				posY.push(parseFloat(selfPos[posIndex.y]));
			}


			// スクロール処理
			var positions = [];
			var direction = {};
			var values = {};
			var if_repeat_X = 0;
			var if_repeat_Y = 0;

			setInterval(function () {
				if ($this.attr(setting.dataScroll) === 'true') {

					positions = [];

					imagesCount = 0;
					for (imagesCount; imagesCount < imagesLeng; imagesCount++) {
						// 値
						values = {};
						for(opt in opts){
							values[opt] = get_optionValue(imagesCount, opts[opt]);
						}

						direction = {};
						direction = {
							top: values.directionY === 'top',
							right: values.directionX === 'right',
							bottom: values.directionY === 'bottom',
							left: values.directionX === 'left'
						};

						if_repeat_X = 0;
						if_repeat_Y = 0;
						if(opts.pattern){
							values.startX = 0;
							values.startY = 0;
							values.endX = parseFloat(values.imageWidth);
							values.endY = parseFloat(values.imageHeight);
							if_repeat_X = Math.abs(posX[imagesCount]) >= values.endX;
							if_repeat_Y = Math.abs(posY[imagesCount]) >= values.endY;
						} else {
							// Start
							values.startX = direction.right ? -parseFloat(values.imageWidth)
								: direction.left ? setting.thisWidth
								: 0;
							values.startY = direction.bottom ? -parseFloat(values.imageHeight)
								: direction.top ? setting.thisHeight
								: 0;
							// End
							values.endX = direction.right ? setting.thisWidth
								: direction.left ? -parseFloat(values.imageWidth)
								: null;
							values.endY = direction.bottom ? setting.thisHeight
								: direction.top ? -parseFloat(values.imageHeight)
								: null;
							if_repeat_X = direction.right ? posX[imagesCount] >= values.endX
								: direction.left ? posX[imagesCount] <= values.endX
								: null;
							if_repeat_Y = direction.bottom ? posY[imagesCount] >= values.endY
								: direction.top ? posY[imagesCount] <= values.endY
								: null;
						}

						// 移動距離と画像サイズが同じ大きさであればpositionを0にする
						posX[imagesCount] = if_repeat_X ? values.startX : posX[imagesCount];
						posY[imagesCount] = if_repeat_Y ? values.startY : posY[imagesCount];


						// 指定の方向へ数値を追加
						posX[imagesCount] = (direction.right) ? posX[imagesCount] + values.speed
							: (direction.left) ? posX[imagesCount] - values.speed
							: posX[imagesCount];
						posY[imagesCount] = (direction.bottom) ? posY[imagesCount] + values.speed
							: (direction.top) ? posY[imagesCount] - values.speed
							: posY[imagesCount];

						// ポジションを追加
						positions.push(Math.floor(posX[imagesCount]) + 'px ' + Math.floor(posY[imagesCount]) + 'px');
					}

					$this.css(setting.bgPos, positions.join(', '));
				}
			}, opts.duration);
		};

		var opts = $.extend({}, $.fn.backgroundScroll.defaults, options);
		var opt = '';
		opts.img = getDefaultStyleValue($this, opts.img, setting.bgImg);console.log(opts.img);
		for(opt in opts){
			if ($.inArray(opt, setting.unArrayOpt) <= 0) {
				opts[opt] = ($.isArray(opts[opt])) ? opts[opt] : [opts[opt]];
			}
		}

		$(window).on('load resize', function(){
			setting.thisWidth = $this.outerWidth();
			setting.thisHeight = $this.outerHeight();
			opts.position = getDefaultStyleValue($this, opts.position, setting.bgPos);

			// スタイル設定
			setBackgroundImage(setting, $this, opts.pattern, opts.img);

			// スクロール
			runScroll(setting, $this, opts);

			$this.on('click', function(){
				if(opts.click){
					if($(this).attr(setting.dataScroll) == 'true'){
						$(this).attr(setting.dataScroll, 'false');
					} else {
						$(this).attr(setting.dataScroll, 'true');
					}
				}
			});
		});
	}

	$.fn.backgroundScroll.defaults = {
		pattern: false,
		click: false,
		img: '',
		speed: 1,
		duration: 10,
		directionX: '',
		directionY: '',
		imageWidth: 0,
		imageHeight: 0,
		position: ''
	};
})(window, window.document, window.jQuery);

