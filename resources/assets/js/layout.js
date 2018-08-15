$(document).ready(function() {

	var form = $('.layout-wrapper #form-layout');
	var components = form.find('.top-holder .components-holder');
	var layout = form.find('.main-layout-holder');
	
	$.ajaxSetup({
		'headers': {
			'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
		}
	});

	/* Drag and drop functionalities */
	function dr_events() {
		var dragging = false,
		currentDragged;

		var resizeHandles = 
		    `
		<div class="resize nw" id="nw" draggable="false" contenteditable="false"></div>
		<div class="resize n" id="n" draggable="false" contenteditable="false"></div>
		<div class="resize ne" id="ne" draggable="false" contenteditable="false"></div>
		<div class="resize w" id="w" draggable="false" contenteditable="false"></div>
		<div class="resize e" id="e" draggable="false" contenteditable="false"></div>
		<div class="resize sw" id="sw" draggable="false" contenteditable="false"></div>
		<div class="resize s" id="s" draggable="false" contenteditable="false"></div>
		<div class="resize se" id="se" draggable="false" contenteditable="false"></div>`;

		var resizing = false,
		    currentResizeHandle,
		    sX,
		    sY;

		var mousedownEventType = ((document.ontouchstart!==null)?'mousedown':'touchstart'),
		    mousemoveEventType = ((document.ontouchmove!==null)?'mousemove':'touchmove'),
		    mouseupEventType = ((document.ontouchmove!==null)?'mouseup':'touchend');

		/*form.find('.main-layout-holder .layout-content-holder').on('click', '.resizable', function(e) {
			if($(this).hasClass('active')) {
				$(this).removeClass('active');
				$(this).children(".resize").remove();
			} else {
				$(this).html($(this).html() + resizeHandles);
			  	$(".resize").on(mousedownEventType, function(e){
			    	currentResizeHandle = $(this);
			    	resizing = true;
			    	sX = e.pageX;
			    	sY = e.pageY;
			  	});
			  	$(this).addClass('active');
			}
		});*/

		layout.on('click', '.resizable', function(e){
		  $(this).children(".resize").remove();
		  $(this).html($(this).html() + resizeHandles);
		  $(".resize").on(mousedownEventType, function(e){
		    currentResizeHandle = $(this);
		    resizing = true;
		    sX = e.pageX;
		    sY = e.pageY;
		  });
		})
		.on('blur', '.resizable', function(e){ 
		  $(this).children(".resize").remove();
		});

		$('.draggable')
		.on(mousedownEventType, function(e){
		  if (!e.target.classList.contains("resize") && !resizing) {
		    currentDragged = $(this);
		    dragging = true;
		    sX = e.pageX;
		    sY = e.pageY;
		  }
		});

		/*$(".resizable")
		.focus(function(e){alert('asdf')
		  $(this).html($(this).html() + resizeHandles);
		  $(".resize").on(mousedownEventType, function(e){
		    currentResizeHandle = $(this);
		    resizing = true;
		    sX = e.pageX;
		    sY = e.pageY;
		  });
		})
		.blur(function(e){
		  $(this).children(".resize").remove();
		});*/

		$("body").on(mousemoveEventType, function(e) {
		  var xChange = e.pageX - sX,
		      yChange = e.pageY - sY;
		  if (resizing) {
		    e.preventDefault();
		    
		    var parent  = currentResizeHandle.parent();
		    
		    switch (currentResizeHandle.attr('id')) {
		      case "nw":
		        var newWidth = parseFloat(parent.css('width')) - xChange,
		            newHeight = parseFloat(parent.css('height')) - yChange,
		            newLeft = parseFloat(parent.css('left')) + xChange,
		            newTop = parseFloat(parent.css('top')) + yChange;
		        break;
		      case "n":
		        var newWidth = parseFloat(parent.css('width')),
		            newHeight = parseFloat(parent.css('height')) - yChange,
		            newLeft = parseFloat(parent.css('left')),
		            newTop = parseFloat(parent.css('top')) + yChange;
		        break;
		      case "ne":
		        var newWidth = parseFloat(parent.css('width')) + xChange,
		            newHeight = parseFloat(parent.css('height')) - yChange,
		            newLeft = parseFloat(parent.css('left')),
		            newTop = parseFloat(parent.css('top')) + yChange;
		        break;
		      case "e":
		        var newWidth = parseFloat(parent.css('width')) + xChange,
		            newHeight = parseFloat(parent.css('height')),
		            newLeft = parseFloat(parent.css('left')),
		            newTop = parseFloat(parent.css('top'));
		        break;
		      case "w":
		        var newWidth = parseFloat(parent.css('width')) - xChange,
		            newHeight = parseFloat(parent.css('height')),
		            newLeft = parseFloat(parent.css('left')) + xChange,
		            newTop = parseFloat(parent.css('top'));
		        break;
		      case "sw":
		        var newWidth = parseFloat(parent.css('width')) - xChange,
		            newHeight = parseFloat(parent.css('height')) + yChange,
		            newLeft = parseFloat(parent.css('left')) + xChange,
		            newTop = parseFloat(parent.css('top'));
		        break;
		      case "s":
		        var newWidth = parseFloat(parent.css('width')),
		            newHeight = parseFloat(parent.css('height')) + yChange,
		            newLeft = parseFloat(parent.css('left')),
		            newTop = parseFloat(parent.css('top'));
		        break;
		      case "se":
		        var newWidth = parseFloat(parent.css('width')) + xChange,
		            newHeight = parseFloat(parent.css('height')) + yChange,
		            newLeft = parseFloat(parent.css('left')),
		            newTop = parseFloat(parent.css('top'));
		        break;
		    }
		    //Width
		    var containerWidth = parseFloat(parent.parent().css("width"));
		    
		    if (newLeft < 0) {
		      newWidth += newLeft;
		      newLeft = 0;
		    }
		    if (newWidth < 0) {
		      newWidth = 0;
		      newLeft = parent.css("left");
		    }
		    if (newLeft + newWidth > containerWidth) {
		      newWidth = containerWidth-newLeft;
		    }
		    
		    parent
		      .css('left', newLeft + "px")
		      .css('width', newWidth + "px");
		    sX = e.pageX;

		    //Height
		    var containerHeight = parseFloat(parent.parent().css("height"));
		    
		    if (newTop < 0) {
		      newHeight += newTop;
		      newTop = 0;
		    }
		    if (newHeight < 0) {
		      newHeight = 0;
		      newTop = parent.css("top");
		    }
		    if (newTop + newHeight > containerHeight) {
		      newHeight = containerHeight-newTop;
		    }
		    
		    parent
		      .css('top', newTop + "px")
		      .css('height', newHeight + "px");
		    sY = e.pageY;
		    
		  } else if (dragging) {
		    e.preventDefault();
		    
		    var draggedWidth = parseFloat(currentDragged.css("width")),
		        draggedHeight = parseFloat(currentDragged.css("height")),
		        containerWidth = parseFloat(currentDragged.parent().css("width")),
		        containerHeight = parseFloat(currentDragged.parent().css("height"));
		    
		    var newLeft = (parseFloat(currentDragged.css("left")) + xChange),
		        newTop = (parseFloat(currentDragged.css("top")) + yChange);
		    
		    if (newLeft < 0) {
		      newLeft = 0;
		    }
		    if (newTop < 0) {
		      newTop = 0;
		    }
		    if (newLeft + draggedWidth > containerWidth) {
		      newLeft = containerWidth - draggedWidth;
		    }
		    if (newTop + draggedHeight > containerHeight) {
		      newTop = containerHeight - draggedHeight;
		    }

		    currentDragged
		      .css("left", newLeft + "px")
		      .css("top", newTop + "px");
		    sX = e.pageX;
		    sY = e.pageY;
		    
		  }
		})
		.on(mouseupEventType, function(e){
		  dragging = false;
		  resizing = false;
		});
	}
	//dr_events();



	//word roulette
	function draw() {
	    var triky = $(".slot-machine-holder .roulette").slotMachine({
	      active: 0,
	      delay: 1000,
	      randomize: function(activeElementIndex){
	        var nextIndex = activeElementIndex + 1;
	        return nextIndex;
	      }
	    });
	    return triky;
	}

	var drawTime = 10;
    var displayTime = 10000; //7000
    var finalWinnerTime = 10000;//9000
    var myLoopTimer = 12000; //9000

    var i = 0; 
    function blink_text() {
	    $('.blink').fadeOut(500);
	    $('.blink').fadeIn(500);
	}
    function myLoop() {
    	if(i == 0) {
    		myLoopTimer = 1000;
    	} else {
    		myLoopTimer = 12000;
    	}
      setTimeout(function() {    
        /*$('.roulette #indev0').removeClass('loading');
        $('.roulette #indev0').html('');*/

        var start = draw(); 
    	start.shuffle( drawTime ); // 4 delay time
        
        
        var next_index = start.active + 1;
        var index_val = $('#indev' + next_index).text();
        var disply = function() {
          	$('#indev' + next_index).html( index_val );
          	/*$('#indev' + next_index).addClass( 'blink' );
			setInterval(blink_text, 1000);*/
        };

        setTimeout(disply, displayTime);

        i++;                    
        if (i > 0) {  
          	myLoop();         
        } else {
          var finalWinner = function() {
            
          }
          setTimeout(finalWinner, finalWinnerTime);
        }                        

      }, myLoopTimer) 
    }


    //random letters
	$.fn.shuffleLetters = function(prop){

        var options = $.extend({
            "step"      : 100,           // How many times should the letters be changed
            "fps"       : 100,           // Frames Per Second
            "text"      : "",           // Use this text instead of the contents
            "callback"  : function(){
                
            }  // Run once the animation is complete
        },prop)

        return this.each(function(){

            var el = $(this),
                str = "";
            // Preventing parallel animations using a flag;

            if(el.data('animated')){
                return true;
            }

            el.data('animated',true);


            if(options.text) {
                str = options.text.split('');
            }
            else {
                str = el.text().split('');
            }

            // The types array holds the type for each character;
            // Letters holds the positions of non-space characters;

            var types = [],
                letters = [];

            // Looping through all the chars of the string

            for(var i=0; i<str.length; i++){

                var ch = str[i];

                if(ch == " "){
                    //types[i] = "symbol";
                    types[i] = "";
                    continue;
                }
                else if(/[a-z]/.test(ch)){
                    types[i] = "lowerLetter";
                }
                else if(/[A-Z]/.test(ch)){
                    types[i] = "upperLetter";
                }
                else {
                    types[i] = "symbol";
                }

                letters.push(i);
            }

            el.html("");            

            // Self executing named function expression:

            (function shuffle(start){

                // This code is run options.fps times per second
                // and updates the contents of the page element

                var i,
                    len = letters.length, 
                    strCopy = str.slice(0); // Fresh copy of the string

                if(start>len){

                    // The animation is complete. Updating the
                    // flag and triggering the callback;

                    el.data('animated',false);
                    options.callback(el);
                    return;
                }

                // All the work gets done here
                for(i=Math.max(start,0); i < len; i++){

                    // The start argument and options.step limit
                    // the characters we will be working on at once

                    if( i < start+options.step){
                        // Generate a random character at this position
                        strCopy[letters[i]] = randomChar(types[letters[i]]);
                    }
                    else {
                        strCopy[letters[i]] = "";
                    }
                }

                el.text(strCopy.join(""));
                setTimeout(function() {
                    shuffle(start+1);
                }, 5000/options.fps);
            })(-options.step);
        });
    };

    function randomChar(type){
        var pool = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
        var arr = pool.split('');
        return arr[Math.floor(Math.random() * arr.length)];
    }
    
    var strs = [ 'MEGASPORTSWORLD' ];
    
    function changeText( i, step, interval ) {
        if( typeof interval == 'undefined' ) interval = 0;
        var next = i + 1;
        if( strs.length == next ) next = 0;
        
        setTimeout(function(){
            layout.find(".slot-machine-holder .slot-text h1").text(strs[i]).shuffleLetters({
            	step: step,
                callback: changeText( next, step, 5000 ) 
            });
        }, interval);
    }   


    //letter roulette
    var i = 0;
	function letterslot(breaks, endSpeed, frames, delay) {
	  text = 'MEGASPORTSWORLD';  // The message displayed
	  chars = ' ABCDEFGHIJKLMNOPQRSTUVWXYZÑ';  // All possible Charactrers
	  scale = 50;  // Font size and overall scale
	  breaks = breaks;  // Speed loss per frame
	  endSpeed = endSpeed;  // Speed at which the letter stops
	  firstLetter = frames;  // Number of frames untill the first letter stopps (60 frames per second)
	  delay = delay;  // Number of frames between letters stopping



	  canvas = document.querySelector('.layout-wrapper #form-layout .main-layout-holder .slot-machine-holder canvas');
	  ctx = canvas.getContext('2d');

	  text = text.split('');
	  chars = chars.split('');
	  charMap = [];
	  offset = [];
	  offsetV = [];

	  for(var i = 0; i < chars.length; i++) {
	      charMap[chars[i]] = i;
	  }

	  for(var i = 0; i < text.length; i++) {
	      var f = firstLetter + delay * i;
	      offsetV[i] = endSpeed + breaks * f;
	      offset[i] = -(1 + f) * (breaks * f + 2 * endSpeed) / 2;
	  }

	  (onresize = function() {
	      canvas.width = canvas.clientWidth;
	      canvas.height = canvas.clientHeight;
	  })();

	  requestAnimationFrame(loop = function() {
	      ctx.setTransform(1, 0, 0, 1, 0, 0);
	      ctx.clearRect(0, 0, canvas.width, canvas.height);
	      ctx.globalAlpha = 1;
	      ctx.fillStyle = '#622';
	      ctx.fillRect(0, (canvas.height - scale) / 2, canvas.width, scale);
	      for(var i = 0; i < text.length; i++) {
	          ctx.fillStyle = '#ccc';
	          ctx.textBaseline = 'middle';
	          ctx.textAlign = 'center';
	          ctx.setTransform(1, 0, 0, 1, Math.floor((canvas.width - scale * (text.length - 1)) / 2), Math.floor(canvas.height / 2));
	          var o = offset[i];
	          while(o < 0) o++;
	          o %= 1;
	          var h = Math.ceil(canvas.height / 2 / scale);
	          for(var j = -h; j < h; j++) {
	              var c = 0;
	              if(typeof charMap[text[i]] == 'undefined') {
	                c = 0 + j - Math.floor(offset[i]);
	              } else {
	                c = charMap[text[i]] + j - Math.floor(offset[i]);
	              }
	              while(c < 0) c += chars.length;
	              c %= chars.length;
	              var s = 1 - Math.abs(j + o) / (canvas.height / 2 / scale + 1)
	              ctx.globalAlpha = s
	              ctx.font = scale * s + 'px Helvetica'
	              ctx.fillText(chars[c], scale * i, (j + o) * scale);
	          }
	          offset[i] += offsetV[i];
	          offsetV[i] -= breaks;
	          if(offsetV[i] < endSpeed) {
	            offset[i] = 0;
	            offsetV[i] = 0;
	          }
	      }
	      requestAnimationFrame(loop);
	  });
	  i++;

	  if(i > 0) {
	    setTimeout(function() {
	      letterslot(0.003, 0.05, 500, 15);
	    }, 10000);
	  }
	}
    





	
	/* Raffle Layout Functionalities */
	components.find('.colorpicker').colorpicker({
		color: '#000',
	});

	$('.layout-wrapper #form-layout').on('change', '#layout_promo', function() {
		var id = $(this).val();
		form.find('input').val('');

		if(id == '') {
			form.find('.top-holder .promo-group').addClass('is-invalid');
			form.find('.top-holder #layout_promo').focus();
			form.find('.top-holder .promo-group .spinner-holder').html('');
			form.find('.components-holder').slideUp(500);
			form.find('.main-layout-holder').slideUp(500);
		} else {
			form.find('.top-holder .promo-group').removeClass('is-invalid');
			form.find('.top-holder .promo-group .spinner-holder').html('<i class="fa fa-spinner fa-spin" style="margin: 10px;"></i>');
			form.find('#promo_id').val(id);

			$.ajax({
				dataType: 'json',
				type: 'GET',
				url: 'getpromoprizedata',
				data: {promo_id: id}
			}).done(function(data) {
				if(data.status) {
					form.find('.main-layout-holder .inner-holder').html(data.data);
					components.find('.tab-content #button-pane #btn-link').html(data.select);
					form.find('.top-holder .promo-group .spinner-holder').html('');
					form.find('.components-holder').slideDown(500);
					form.find('.main-layout-holder').slideDown(500);

					$(".main-layout-holder .slot-machine-holder .roulette").html('');
					$(".main-layout-holder .slot-machine-holder .roulette").removeClass('slotMachineGradient');
			        for(var x = 1; x < 26; x++) {
			    		$(".main-layout-holder .slot-machine-holder .roulette").append('<div id="indev'+ x +'">Fullname '+ x +'</div>');
			    	}

					letterslot(0.003, 0.05, 500, 15);
					myLoop();
					changeText( 0, 100 );
				} else {
					swal('Error!', 'Error retrieving data.', 'error');
					form.find('.components-holder').slideUp(500);
					form.find('.main-layout-holder').slideUp(500);
				}
				dr_events();
			});
		}
	});

	components.find('.tab-content').on('change', '#bg-image', function() {
		var file = this.files[0];
		var reader = new FileReader();
		reader.onloadend = function() {
			form.find('.main-layout-holder .layout-content-holder').css({
				'background-image': 'url("' + reader.result + '")',
			    'background-size': 'cover',
    			'background-repeat': 'no-repeat',
			    'background-position': 'center center'
			});
		}
		if(file) {
			reader.readAsDataURL(file);
		}
	});

	components.find('#label-pane').on('click', '.btn-add-label', function() {
		var lbl = components.find('#label-pane #text-label').val();
		var size = components.find('#label-pane #text-size').val();
		components.find('#label-pane #text-color').val(components.find('#label-pane .colorpicker span i').css('background-color'));
		var color = components.find('#label-pane #text-color').val();

		if(lbl == '') {
			$(this).closest('#label-pane').find('.label-group').addClass('is-invalid');
			components.find('#label-pane #text-label').focus();
		} else {
			form.find('.main-layout-holder .tab-pane.active .layout-content-holder').prepend('<p class="layout-text draggable removable" style="color: '+ color +'; font-size: '+ size +'px;">'+ lbl +'<span class="remove-elem"><i class="fa fa-times"></i></span></p>');
			dr_events();
			//$('.layout-text').mousedown(handle_mousedown);
			components.find('#label-pane #text-label').val('');
			components.find('#label-pane #text-size').val('');
			components.find('#label-pane #text-color').val('');
			$(this).closest('#label-pane').find('.label-group').removeClass('is-invalid');
			components.find('.colorpicker span i').css('background-color', '#000');
			components.find('.colorpicker').colorpicker({ color: '#000' });
		}
	});

	components.on('click', '#image-pane .btn-add-image', function() {
		var img = components.find('#image-pane #layout-image').val();

		if(img == '') {
			swal('Error!', 'Please upload an image file', 'error');
		} else {
			var file = components.find('#image-pane #layout-image')[0].files[0];
			var reader = new FileReader();
			reader.onloadend = function() {
				form.find('.main-layout-holder .tab-pane.active .layout-content-holder').prepend('<div class="img-holder removable resizable draggable"><img src="' + reader.result + '"><span class="remove-elem"><i class="fa fa-times"></i></span></div>');
				dr_events();
				components.find('#image-pane #layout-image').val('');
			}
			if(file) {
				reader.readAsDataURL(file);
			}
		}
	});


	components.on('click', '#button-pane .btn-add-btn', function() {
		var btn = components.find('#button-pane');
		var txt = btn.find('#btn-text').val();
		var target = btn.find('#btn-link').val();
		var bradius = (btn.find('#btn-bradius').val() == '') ? 0 : btn.find('#btn-bradius').val();
		var tcolor = (btn.find('#btn-txt-color').val() == '') ? '#000' : btn.find('#btn-txt-color').val();
		var bgcolor = (btn.find('#btn-bg-color').val() == '') ? '#000' : btn.find('#btn-bg-color').val();

		if(txt == '') {
			btn.find('.btn-text-group').addClass('is-invalid');
			btn.find('#btn-text').focus();
		} else if(target == '') {
			btn.find('.btn-target-group').addClass('is-invalid');
			btn.find('#btn-target').focus();
		} else {
			form.find('.main-layout-holder .tab-pane.active .layout-content-holder').prepend('<div class="btn-holder removable resizable draggable"><button type="button" value="'+ target +'" style="border-radius: '+ bradius +'px; color: '+ tcolor +'; border-color: '+ bgcolor +'; background-color: '+ bgcolor +'">'+ txt +'</button><span class="remove-elem"><i class="fa fa-times"></i></span></div>');
			dr_events();
			btn.find('#btn-text').val('');
			btn.find('#btn-link').val('');
			btn.find('#btn-bradius').val('');
			btn.find('#btn-txt-color').val('');
			btn.find('#btn-bg-color').val('');
			btn.find('.btn-text-group').removeClass('is-invalid');
			btn.find('.btn-target-group').removeClass('is-invalid');
			components.find('.colorpicker span i').css('background-color', '#000');
			components.find('.colorpicker').colorpicker({ color: '#000' });
		}
	});

	components.on('click', '#slot-machine-pane .btn-add-slot-machine', function() {
		var slot = components.find('#slot-machine-pane #slot-machine-selector').val();
		var time = components.find('#slot-machine-pane #display-time').val();
		if(slot == 0) {
			form.find('.main-layout-holder .tab-pane.active .layout-content-holder').prepend('<div class="slot-machine-holder random-letter removable resizable draggable"><div class="slot-text"><h1></h1></div><span class="remove-elem"><i class="fa fa-times"></i></span></div>');
			dr_events();
			changeText( 0, parseInt(time) );
		} else if(slot == 1) {
			form.find('.main-layout-holder .tab-pane.active .layout-content-holder').prepend('<div class="slot-machine-holder removable resizable draggable"><canvas class="slot-text"></canvas><span class="remove-elem"><i class="fa fa-times"></i></span></div>');
			dr_events();
			letterslot(0.003, 0.05, 500, 15);
		} else {
			form.find('.main-layout-holder .tab-pane.active .layout-content-holder').prepend('<div class="slot-machine-holder removable resizable draggable"><div class="roulette"></div><span class="remove-elem"><i class="fa fa-times"></i></span></div>');
	        for(var x = 1; x < 26; x++) {
	    		$(".main-layout-holder .slot-machine-holder .roulette").append('<div id="indev'+ x +'">Fullname '+ x +'</div>');
	    	}
			dr_events();
    		myLoop();
		}
	});

	/* remove elements */
	layout.on('click', '.tab-pane.active .removable .remove-elem', function() {
		$(this).parent().remove();
	});

	/* save elements */
	form.on('submit', function(e) {
		e.preventDefault();
		var i = 0;
		var data = '';
		var inc = '';
		var prize_id = 0;
		var formdata = new FormData(this);
		/*form.find('.main-layout-holder .tab-pane.active .layout-content-holder .resizable').children(".resize").remove();
		form.find('.main-layout-holder .tab-pane.active .layout-content-holder .removable').children(".remove-elem").remove();*/
		
		layout.find('.tab-content .tab-pane').each(function() {
			i++;
			prize_id = $(this).attr('data-id');
			/*var elem = $(this).find('.layout-content-holder').prop('outerHTML');
			data = {index: elem};*/
			//data[$(this).attr('id')] = $(this).find('.layout-content-holder').html();
			if(layout.find('.tab-content .tab-pane').length === i) {
				inc = '';
			} else {
				inc = '||';
			}
			data += prize_id + '|' + $(this).attr('id') + '~' + $(this).find('.layout-content-holder').html() + inc;

		});
		formdata.append('layout', data);
		form.find('#save-btn-layout').append(' <i class="fa fa-spinner fa-spin"></i>');
		
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: formdata,
			dataType: 'json',
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				if(data.status > 0) {
					form.find('.main-layout-holder .inner-holder').html(data.data);
					components.find('.tab-content #button-pane #btn-link').html(data.select);
					swal('Success', 'Layout has been saved.', 'success');

					dr_events();
					$(".main-layout-holder .slot-machine-holder .roulette").html('');
					$(".main-layout-holder .slot-machine-holder .roulette").removeClass('slotMachineGradient');
			        for(var x = 1; x < 26; x++) {
			    		$(".main-layout-holder .slot-machine-holder .roulette").append('<div id="indev'+ x +'">Fullname '+ x +'</div>');
			    	}
				}

				form.find('#save-btn-layout').html('Save');
			}
		});
	});

});



$(document).ajaxComplete(function() {

	/*function handle_mousedown(e){
	    window.my_dragging = {};
	    my_dragging.pageX0 = e.pageX;
	    my_dragging.pageY0 = e.pageY;
	    my_dragging.elem = this;
	    my_dragging.offset0 = $(this).offset();
	    function handle_dragging(e){
	        var left = my_dragging.offset0.left + (e.pageX - my_dragging.pageX0);
	        var top = my_dragging.offset0.top + (e.pageY - my_dragging.pageY0);
	        $(my_dragging.elem)
	        .offset({top: top, left: left});
	    }
	    function handle_mouseup(e){
	        $('body')
	        .off('mousemove', handle_dragging)
	        .off('mouseup', handle_mouseup);
	    }
	    $('body')
	    .on('mouseup', handle_mouseup)
	    .on('mousemove', handle_dragging);
	}*/

});