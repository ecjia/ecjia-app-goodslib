// JavaScript Document
;
(function(app, $) {
	var bath_url; /* 列表页 */
	app.goods_list = {
		init: function() {
			$(".no_search").chosen({
				allow_single_deselect: false,
				disable_search: true
			});
			bath_url = $("a[name=move_cat_ture]").attr("data-url");
			app.goods_list.search();
			app.goods_list.batch_move_cat();
			app.goods_info.previewImage();
			app.goods_list.toggle_on_sale();
		},

		search: function() {
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val(); //关键字

				var url = $("form[name='search_form']").attr('action');

				if (keywords == 'undefind') keywords = '';
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}

				ecjia.pjax(url);
			});

			$("form[name='search_form']").on('submit', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val(); //关键字
				var url = $("form[name='search_form']").attr('action');

				if (keywords == 'undefind') keywords = '';

				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
		},

		batch_move_cat: function() {},

		toggle_on_sale: function() {
			$('[data-trigger="toggle_on_sale"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this);
				var url = $this.attr('data-url');
				var id = $this.attr('data-id');
				var val = $this.hasClass('fa-times') ? 1 : 0;
				var type = $this.attr('data-type') ? $this.attr('data-type') : "POST";
				var pjaxurl = $this.attr('refresh-url');

				var option = {
					obj: $this,
					url: url,
					id: id,
					val: val,
					type: type
				};

				$.ajax({
					url: option.url,
					data: {
						id: option.id,
						val: option.val
					},
					type: option.type,
					dataType: "json",
					success: function(data) {
						data.content ? option.obj.removeClass('fa-times').addClass('fa-check') : option.obj.removeClass('fa-check').addClass('fa-times');
						ecjia.pjax(pjaxurl, function() {
							ecjia.merchant.showmessage(data);
						});
					}
				});
			})
		}
	}

	/* 编辑页 */
	app.goods_info = { /* 添加编辑页 */
		init: function() {
			$(".date").datepicker({
				format: "yyyy-mm-dd"
			});
			$("#color").colorpicker();

			//记录排序名称
			$('.move-mod-head').attr('data-sortname', 'goods_info');
			//执行排序
			ecjia.merchant.set_sortIndex('goods_info');

			//清除控件残留
			$('[name="goods_img"]').val('').focus();
			$('.cat_id_error').hide();

			app.goods_info.set_allprice_note();

			app.goods_info.goto_newpage();
			app.goods_info.add_volume_price();
			app.goods_info.toggle_promote();
			app.goods_info.integral_market_price();
			app.goods_info.parseint_input();

			app.goods_info.priceSetted();
			app.goods_info.marketPriceSetted();
			app.goods_info.checkGoodsSn();

			app.goods_info.submit_info();

			app.goods_info.fileupload();

			app.goods_info.term_meta();
			app.goods_info.term_meta_key();
			app.goods_info.add_cat();
			app.goods_info.search_cat_opt();
			app.goods_info.load_cat_list();
			app.goods_info.next_step();
		},

		fileupload: function() {
			$(".fileupload-btn").on('click', function(e) {
				e.preventDefault();
				$(this).parent().find("input").trigger('click');
			})
		},

		goto_newpage: function() {
			$('[data-toggle="goto_newpage"]').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-href') || $(this).attr('href');
				smoke.confirm(js_lang.give_up_confirm, function(e) {
					if (e) {
						window.location.href = url;
					}
				}, {
					ok: js_lang.ok,
					cancel: js_lang.cancel
				});
			});
		},

		add_volume_price: function() {
			$('.add_volume_price').on('click', function(e) {
				e.preventDefault();
				$(this).parent().find('.fontello-icon-plus').trigger('click');
			});
		},

		toggle_promote: function() {
			$('.toggle_promote').on('change', function(e) {
				e.preventDefault();
				$(this).is(":checked") == true ? $('#promote_1').prop('disabled', false) : $('#promote_1').attr('disabled', true);
			})
		},

		integral_market_price: function() {
			$('[data-toggle="integral_market_price"]').on('click', function(e) {
				e.preventDefault();
				var init_val = parseInt($('[name="market_price"]').val());
				$('[name="market_price"]').val(init_val); //'market_price'].value = parseInt(document.forms['theForm'].elements['market_price'].value);
			});
		},

		parseint_input: function() {
			$('[data-toggle="parseint_input"]').on('blur', function(e) {
				e.preventDefault();
				var init_val = parseInt($(this).val());
				$(this).val(init_val);
			});
		},

		priceSetted: function() {},

		marketPriceSetted: function() {},
		checkGoodsSn: function() {},

		set_allprice_note: function() {},

		set_price_note: function(options) {},

		computePrice: function(options) {},

		previewImage: function(file) {},

		submit_info: function() {},

		term_meta: function() {},

		term_meta_key: function() {},

		add_cat: function() {},

		complete: function(url) {
			var data = {
				'status': 'success',
				'message': js_lang.add_goods_ok,
			};
			ecjia.pjax(url, function() {
				ecjia.merchant.showmessage(data);
			})
		},

		search_cat_opt: function() {
			var opt = {
				onAfter: function() {
					$('.ms-group').each(function(index) {
						$(this).find('.isShow').length ? $(this).css('display', 'block') : $(this).css('display', 'none');
					});
					return;
				},
				show: function() {
					this.style.display = "";
					$(this).addClass('isShow');
				},
				hide: function() {
					this.style.display = "none";
					$(this).removeClass('isShow');
				},
			};
			$('#ms-search_zero').quicksearch($('.level_0 .ms-elem-selectable'), opt);
			$('#ms-search_one').quicksearch($('.level_1 .ms-elem-selectable'), opt);
			$('#ms-search_two').quicksearch($('.level_2 .ms-elem-selectable'), opt);
		},

		load_cat_list: function() {
			$('.nav-list-ready li').off().on('click', function() {
				var $this = $(this);
				if (!$this.hasClass('disabled')) {
					$this.addClass('selected').siblings('li').removeClass('selected');
					$this.addClass('disabled').siblings('li').removeClass('disabled');
				} else {
					return false;
				}

				var cat_id = $this.attr('data-id');
				var level = parseInt($this.attr('data-level')) + 1;
				var url = $('.goods_cat_container').attr('data-url');

				if (cat_id == undefined) {
					return false;
				}
				var info = {
					'cat_id': cat_id,
				};

				$('input[name="cat_id"]').val(cat_id);

				if (cat_id != 0 && cat_id != undefined) {
					$('button[type="button"]').prop('disabled', false);
				}
				var no_content = '<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>';
				$.post(url, info, function(data) {
					if (level == 1) {
						$('.level_1').html('');
						$('.level_2').html(no_content);
					} else if (level == 2) {
						$('.level_2').html('');
					}
					var level_div = $('.level_' + level);

					if (data.content.length > 0) {
						for (var i = 0; i < data.content.length; i++) {
							var opt = '<li class = "ms-elem-selectable selectable" data-id=' + data.content[i].cat_id + ' data-level=' + level + '><span>' + data.content[i].cat_name + '</span></li>'
							level_div.append(opt);
						};
						app.goods_info.search_cat_opt();
					} else {
						level_div.html(no_content);
					}
					app.goods_info.load_cat_list();
				});
			});
		},

		next_step: function() {
			$('.next_step').on('click', function() {
				var $this = $(this);
				var url = $this.attr('data-url');
				var cat_id = $('input[name="cat_id"]').val();
				url += '&cat_id=' + cat_id;
				ecjia.pjax(url);
			})
		}
	}

	/* 商品预览 */
	app.preview = {
		init: function() {
			app.preview.goods_search();

			var browse = window.navigator.appName.toLowerCase();
			var MyMar;
			var speed = 1; //速度，越大越慢
			var spec = 1; //每次滚动的间距, 越大滚动越快
			var minOpa = 50; //滤镜最小值
			var maxOpa = 100; //滤镜最大值
			var spa = 2; //缩略图区域补充数值
			var w = 0;
			spec = (browse.indexOf("microsoft") > -1) ? spec : ((browse.indexOf("opera") > -1) ? spec * 10 : spec * 20);

			function $(e) {
				return document.getElementById(e);
			}

			function goleft() {
				$('photos').scrollLeft -= spec;
			}

			function goright() {
				$('photos').scrollLeft += spec;
			}

			function setOpacity(e, n) {
				if (browse.indexOf("microsoft") > -1) e.style.filter = 'alpha(opacity=' + n + ')';
				else e.style.opacity = n / 100;
			}
			if ($('goleft') != null) {
				$('goleft').style.cursor = 'pointer';
				$('goright').style.cursor = 'pointer';
				$('mainphoto').onmouseover = function() {
					setOpacity(this, maxOpa);
				}
				$('goleft').onmouseover = function() {
					this.src = images_url + '/goleft2.gif';
					MyMar = setInterval(goleft, speed);
				}
				$('goleft').onmouseout = function() {
					this.src = images_url + '/goleft.gif';
					clearInterval(MyMar);
				}
				$('goright').onmouseover = function() {
					this.src = images_url + '/goright2.gif';
					MyMar = setInterval(goright, speed);
				}
				$('goright').onmouseout = function() {
					this.src = images_url + '/goright.gif';
					clearInterval(MyMar);
				}
				window.onload = function() {
					var rHtml = '';
					var p = $('showArea').getElementsByTagName('img');
					for (var i = 0; i < p.length; i++) {
						w += parseInt(p[i].getAttribute('width')) + spa;
						setOpacity(p[i], minOpa);
						p[i].onmouseover = function() {
							setOpacity(this, maxOpa);
							$('mainphoto').src = this.getAttribute('rel');
							$('mainphoto').setAttribute('name', this.getAttribute('name'));
							setOpacity($('mainphoto'), maxOpa);
						}
						p[i].onmouseout = function() {
							setOpacity(this, minOpa);
						}
						rHtml += '<img src="' + p[i].getAttribute('rel') + '" width="0" height="0" alt="" />';
					}
					$('showArea').style.width = parseInt(w) + 'px';
					var rLoad = document.createElement("div");
					$('photos').appendChild(rLoad);
					rLoad.style.width = "1px";
					rLoad.style.height = "1px";
					rLoad.style.overflow = "hidden";
					rLoad.innerHTML = rHtml;
				};
			}
		},

		goods_search: function() {
			$("form[name='searchForm']").bind('form-pre-serialize', function(event, form, options, veto) {
				(typeof(tinyMCE) != "undefined") && tinyMCE.triggerSave();
			}).on('submit', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('action'),
					id = $this.find('[name="keywords"]').val();
				ecjia.pjax(url + '&id=' + id);
			});
		},
	}

	/* 货品列表 */
	app.products_list = {
		init: function() {
			app.products_list.products_submit();
		},

		products_submit: function() {
			var $this = $('form[name="theForm"]');
			var option = {
				rules: {
					product_sn: {
						required: true
					},
					product_number: {
						required: true
					}
				},
				messages: {
					product_sn: {
						required: js_lang.product_sn_required
					},
					product_number: {
						required: js_lang.product_number_required
					}
				},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.merchant.showmessage(data);
						}
					});
				}
			}

			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$this.validate(options);
		}
	}

	/* 回收站 */
	app.goods_trash = {
		init: function() {
			app.goods_trash.search();
			app.goods_trash.submit();
		},

		submit: function() {
			var $this = $('form[name="listForm"]');
			var option = {
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.merchant.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$this.validate(options);
		},
		search: function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var cat_id = $("select[name='cat_id']").val(); //分类
				var keywords = $("input[name='keywords']").val(); //关键字
				var url = $("form[name='searchForm']").attr('action') + '&keywords=' + keywords + '&cat_id=' + cat_id;
				//                var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val();
				ecjia.pjax(url);
			});
		}
	}

	/* 商品属性 */
	app.goods_attr = {
		init: function() {
			$("select").not(".noselect").chosen();
			$('[data-trigger="toggleSpec"]').on('click', function() {
				var $this = $(this);
				var $parent = $this.parents('.form-group');
				if ($this.find('i').hasClass('fa-times')) {
					$parent.remove();
				} else {
					var info = $parent.clone(true);
					info.find('.fa-check').attr('class', 'fa-times');
					$parent.after(info);
					info.find('.chzn-container').remove();
					info.find('select').attr({
						'id': '',
						'class': ''
					}).chosen();
				}
			})

			$('[data-toggle="get_attr_list"]').on('change', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('data-url'),
					type = $this.val();

				$.get(url, {
					goods_type: type
				}, function(data) {
					$('#tbody-goodsAttr').html(data.content);
					$("select").not(".noselect").chosen();
				}, "JSON");
			})

			$('[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType: "json",
					success: function(data) {
						if (data.message) {
							ecjia.merchant.showmessage(data);
						} else {
							ecjia.pjax(data.url);
						}
					}
				});
			});
		}
	}

	/* 关联商品 */
	app.link_goods = {}

	/* 关联配件 */
	app.link_parts = {}

	/* 关联文章 */
	app.link_article = {}

	/* 商品相册 */
	app.goods_photo = {
		init: function() {
			$(".wookmark_list img").disableSelection();

			$('.move-mod').sortable({
				distance: 0,
				revert: false,
				//缓冲效果
				handle: '.move-mod-head',
				placeholder: 'ui-sortable-placeholder thumbnail',
				activate: function(event, ui) {
					$('.wookmark-goods-photo').append(ui.helper);
				},
				stop: function(event, ui) {},
				sort: function(event, ui) {}
			});

			var action = $(".fileupload").attr('data-action');
			$(".fileupload").dropper({
				action: action,
				label: js_lang.drag_here_upload,
				maxQueue: 2,
				maxSize: 5242880,
				// 5 mb
				height: 150,
				postKey: "img_url",
				successaa_upload: function(data) {
					ecjia.merchant.showmessage(data);
				}
			});

			$('.next_step').on('click', function() {
				ecjia.pjax($(this).attr('data-url'));
			});

			$('.complete').on('click', function() {
				ecjia.pjax($(this).attr('data-url'), function() {
					var data = {
						'status': 'success',
						'message': js_lang.add_goods_ok,
					};
					ecjia.merchant.showmessage(data);
				});
			});

			app.goods_photo.loaded_img();
			app.goods_photo.save_sort();
			app.goods_photo.sort_ok();
			app.goods_photo.edit_title();
			app.goods_photo.sort_cancel();
		},

		save_sort: function() {
			$('.save-sort').on('click', function(e) {
				e.preventDefault();
				var info = {},
					info_str = '{info : [',
					sort_url = $(this).attr('data-sorturl');

				$('.wookmark-goods-photo li').each(function(i) {
					var $this = $(this);
					info_str += i + 1 == $('.wookmark-goods-photo li').length ? '{img_id : ' + $this.find('[data-toggle="ajaxremove"]').attr('data-imgid') + ', img_original : "' + $this.find('[data-original]').attr('data-original') + '"},' : '{img_id : ' + $this.find('[data-toggle="ajaxremove"]').attr('data-imgid') + ', img_original : "' + $this.find('[data-original]').attr('data-original') + '"},';
				});
				info_str += ']}';
				info = eval('(' + info_str + ')');
				$.get(sort_url, info, function(data) {
					ecjia.merchant.showmessage(data);
				})
			});
		},

		sort_ok: function() {
			$('[data-toggle="sort-ok"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('data-saveurl'),
					id = $this.attr('data-imgid'),
					val = $this.parent().find('.edit-inline').val(),
					info = {
						img_id: id,
						val: val
					};

				$.get(url, info, function(data) {
					$this.parent().find('.edit_title').html(val);
					$this.parent('p').find('.ajaxremove , .move-mod-head , [data-toggle="edit"]').css('display', 'inline-block');
					$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'none');
					ecjia.merchant.showmessage(data);
				});
			});
		},

		edit_title: function() {
			$('[data-toggle="edit"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					value = $(this).parent().find('.edit_title').text();

				$this.parent('p').find('.edit_title').html('<input class="edit-inline" type="text" value="' + value + '" />').find('.edit-inline').focus().select();
				$this.parent('p').find('.ajaxremove , .move-mod-head, [data-toggle="edit"]').css('display', 'none');
				$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'block');
			});
		},

		sort_cancel: function() {
			$('[data-toggle="sort-cancel"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					value = $(this).parent().find('.edit-inline').val();

				$this.parent().find('.edit_title').html(value);
				$this.parent('p').find('.ajaxremove , .move-mod-head, [data-toggle="edit"]').css('display', 'block');
				$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'none');
			});
		},

		loaded_img: function() {
			$('div.wookmark_list').imagesLoaded(function() {
				$('div.wookmark_list .thumbnail a.bd').attr('rel', 'gallery').colorbox({
					maxWidth: '80%',
					maxHeight: '80%',
					opacity: '0.8',
					loop: true,
					slideshow: false,
					fixed: true,
					speed: 300,
				});
			});
		}
	}

})(ecjia.merchant, jQuery);

// end