var lazy;

$(function(){
	
	hideMe();
//  matchHeight();
// 	doLazy();
	dropdown();
	toggle(); 
// 	searchText();	
// 	expandSearch();
	accordion();
	table();
	form();
	cookie();
	
	$(window).resize(function(){
// 		height();
// 		matchHeight();
	}).triggerHandler('resize');
	
	$('.ball-bounce').click(function(){
		$(this).find('img').attr("src", "../wp-content/themes/plinkit/img/ball_bounce.gif");
	});
		
});	

$(document).ready(function(){
	$('body').addClass('ready');
	$('#send_credentials_via_email').prop('checked', true);
	
	alertHeight = $('header .alert').outerHeight();
	bodyPadding = parseInt($('body.alert-body').css('padding-top'));

	headerHeight = $('header').height();

 	newPadding = bodyPadding + alertHeight;
	
	$('body').css('padding-top', headerHeight);
	
	$('.alert-close').on('click',function(e) {
		$('.alert').slideUp();
		$('body').removeAttr('style');
		e.preventDefault();
	});
	$( "a.scroll" ).click(function( event ) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: $($(this).attr("href")).offset().top - 60}, 500);
    });
});

function doLazy() {
	lazy = $('.lazy').Lazy({
		afterLoad: function(element) {
			var type = element.prop('nodeName').toLowerCase();
			if(type == 'span') {
				element.css({
					'background-size': 'cover'
				});
			}
		}
	});
}



function height() {
	$width = $(window).width();
	$height = $(window).height();
	
	if($width > 990) {
		$('.height').height($height);
		$('#banner .height').height($height - 160);	
	} else {
		$('.height').css('height', 'auto');
// 		$('.band-item').matchHeight();
// 		$('.mr-item').matchHeight();
	}
}

function matchHeight() {	

	$width = $(window).width();
	if($width > 990) {
		// Select and loop the container element of the elements you want to equalise
	    $('.parent').each(function(){  
	      
	      // Cache the highest
	      var highestBox = 0;
	      
	      // Select and loop the elements you want to equalise
	      $('.match-height', this).each(function(){
	        
	        // If this box is higher than the cached highest then store it
	        if($(this).height() > highestBox) {
	          highestBox = $(this).height(); 
	        }
	      
	      });  
	            
	      // Set the height of all those children to whichever was highest 
	      $('.match-height',this).height(highestBox);
	                    
	    }); 
	} 	
	
}

function hideMe() {
	 /* Every time the window is scrolled ... */
    $(window).scroll( function(){
    
        /* Check the location of each desired element */
        $('.hideme').each( function(i){
            
            var top_of_object = $(this).offset().top + 180;
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            
            /* If the object is completely visible in the window, fade it it */
            if( bottom_of_window > top_of_object ){
                
                $(this).animate({'opacity':'1'},500);
                    
            }
            
        }); 
    
    });
}

function searchPosts() {
	
	/*
	if (typeof allKeywords === 'undefined') {
		var allKeywords = new Array();
	}
	*/
	
	$('#filters .submit').click(function(e) {
		
		if($('input[name="keyword"]').val()) {
			$('#keywords-form').append('<input type="hidden" name="search[]" value="' + $('input[name="keyword"]').val() + '" />');
		}
		
		e.preventDefault();
		
		//var keyword = $('#keywords-form .keyword').val();
		
    	var data = $('#filters #ages-form, #filters #skills-form, #filters #keywords-form').serializeArray();		
				
		/*
		if(keyword != '') {
			allKeywords.push(keyword);
		}
		
		if(allKeywords != '') {
			data.push({
			    name: "search",
			    value: allKeywords
			});
		}
		*/
		
		var result = $.param(data);

    	$.ajax({
			type: "GET",
			data: data,
			url: theme + "/inc/search_posts.php",
			beforeSend: function() {
	           $('#bands').html('<div class="loading" />');
	        },
			success: function(data) {
				$('#bands').html(data);
				window.history.pushState("object or string", "Title", "?" + result);
 	        },
	        complete: function() {
		        searchClick();
		        $("input.keyword").val("");
	        },
			async: false
		});
		
		$('.circles').addClass('anim');
		
		
    });
    
    function searchClick() {
	    
	    
	    $(".search-term").click(function(e) {
			
			
			var value = $(this).text();
			$('input[value="' + value + '"]').remove();
						
			//var removeKeyword = $(this).data('search');
						
	    	var data = $('#filters #ages-form, #filters #skills-form, #filters #keywords-form').serializeArray();
	    	
	    	console.log(data);	

			/*
			allKeywords = jQuery.grep(allKeywords, function(value) {
				return value != removeKeyword;
			});
						
			data.push({
			    name: "search",
			    value: allKeywords
			});

			*/
			
			var result = $.param(data);
	    	
	    	$.ajax({
				type: "GET",
				data: data,
				url: theme + "/inc/search_posts.php",
				beforeSend: function() {
		           $('#bands').html('<div class="loading" />');
		        },
				success: function(data) {
					$('#bands').html(data);
 					window.history.pushState("object or string", "Title", "?" + result);
	 	        },
		        complete: function() {
		        	searchClick();
		        	$("input.keyword").val("");
		        },
				async: false
			});
			
			e.preventDefault();
	    });
	    
	    
	    

		$(".term-click").click(function(e) {
			e.preventDefault();
			var removeKeyword = $(this).data('search');
			
			$('input[value="' + removeKeyword + '"]').closest('label').trigger('click');
						
	    	var data = $('#filters #ages-form, #filters #skills-form').serializeArray();		
			
			var arr = Object.keys(data).map(function (key) { return data[key]; });
						
			console.log(data);
				
 			var result = $.param(data);

						
	    	$.ajax({
				type: "GET",
				data: data,
				url: theme + "/inc/search_posts.php",
				beforeSend: function() {
		           $('#bands').html('<div class="loading" />');
		        },
				success: function(data) {
					$('#bands').html(data);
 				window.history.pushState("object or string", "Title", "?" + result);
	 	        },
		        complete: function() {
		        	searchClick();
		        	$("input.keyword").val("");
		        },
				async: false
			});
	    });


	}
    
}

function searchPostsToys() {
	
	/*
	if (typeof allKeywords === 'undefined') {
		var allKeywords = new Array();
	}
	*/
	
	$('#filters .submit').click(function(e) {
		
		if($('input[name="keyword"]').val()) {
			$('#keywords-form').append('<input type="hidden" name="search[]" value="' + $('input[name="keyword"]').val() + '" />');
		}
		
		e.preventDefault();
		
		//var keyword = $('#keywords-form .keyword').val();
		
    	var data = $('#filters #ages-form, #filters #skills-form, #filters #keywords-form').serializeArray();		
				
		/*
		if(keyword != '') {
			allKeywords.push(keyword);
		}
		
		if(allKeywords != '') {
			data.push({
			    name: "search",
			    value: allKeywords
			});
		}
		*/
		
		var result = $.param(data);

    	$.ajax({
			type: "GET",
			data: data,
			url: theme + "/inc/search_toys.php",
			beforeSend: function() {
	           $('#bands').html('<div class="loading" />');
	        },
			success: function(data) {
				$('#bands').html(data);
				window.history.pushState("object or string", "Title", "?" + result);
 	        },
	        complete: function() {
		        searchClick();
		        $("input.keyword").val("");
	        },
			async: false
		});
		
		$('.circles').addClass('anim');
		
		
    });
    
    function searchClick() {
	    
	    
	    $(".search-term").click(function(e) {
			
			
			var value = $(this).text();
			$('input[value="' + value + '"]').remove();
						
			//var removeKeyword = $(this).data('search');
						
	    	var data = $('#filters #ages-form, #filters #skills-form, #filters #keywords-form').serializeArray();
	    	
	    	console.log(data);	

			/*
			allKeywords = jQuery.grep(allKeywords, function(value) {
				return value != removeKeyword;
			});
						
			data.push({
			    name: "search",
			    value: allKeywords
			});

			*/
			
			var result = $.param(data);
	    	
	    	$.ajax({
				type: "GET",
				data: data,
				url: theme + "/inc/search_toys.php",
				beforeSend: function() {
		           $('#bands').html('<div class="loading" />');
		        },
				success: function(data) {
					$('#bands').html(data);
 					window.history.pushState("object or string", "Title", "?" + result);
	 	        },
		        complete: function() {
		        	searchClick();
		        	$("input.keyword").val("");
		        },
				async: false
			});
			
			e.preventDefault();
	    });
	    
	    
	    

		$(".term-click").click(function(e) {
			e.preventDefault();
			var removeKeyword = $(this).data('search');
			
			$('input[value="' + removeKeyword + '"]').closest('label').trigger('click');
						
	    	var data = $('#filters #ages-form, #filters #skills-form').serializeArray();		
			
			var arr = Object.keys(data).map(function (key) { return data[key]; });
						
			console.log(data);
				
 			var result = $.param(data);

						
	    	$.ajax({
				type: "GET",
				data: data,
				url: theme + "/inc/search_toys.php",
				beforeSend: function() {
		           $('#bands').html('<div class="loading" />');
		        },
				success: function(data) {
					$('#bands').html(data);
 				window.history.pushState("object or string", "Title", "?" + result);
	 	        },
		        complete: function() {
		        	searchClick();
		        	$("input.keyword").val("");
		        },
				async: false
			});
	    });


	}
    
}

function searchPostsAll() {
	
	/*
	if (typeof allKeywords === 'undefined') {
		var allKeywords = new Array();
	}
	*/
	
	$('#filters .submit').click(function(e) {
		
		if($('input[name="keyword"]').val()) {
			$('#keywords-form').append('<input type="hidden" name="search[]" value="' + $('input[name="keyword"]').val() + '" />');
		}
		
		e.preventDefault();
		
		//var keyword = $('#keywords-form .keyword').val();
		
    	var data = $('#filters #ages-form, #filters #skills-form, #filters #keywords-form').serializeArray();		
				
		/*
		if(keyword != '') {
			allKeywords.push(keyword);
		}
		
		if(allKeywords != '') {
			data.push({
			    name: "search",
			    value: allKeywords
			});
		}
		*/
		
		var result = $.param(data);

    	$.ajax({
			type: "GET",
			data: data,
			url: theme + "/inc/search_all.php",
			beforeSend: function() {
	           $('#bands').html('<div class="loading" />');
	        },
			success: function(data) {
				$('#bands').html(data);
				window.history.pushState("object or string", "Title", "?" + result);
 	        },
	        complete: function() {
		        searchClick();
		        $("input.keyword").val("");
	        },
			async: false
		});
		
		$('.circles').addClass('anim');
		
		
    });
    
    function searchClick() {
	    
	    
	    $(".search-term").click(function(e) {
			
			
			var value = $(this).text();
			$('input[value="' + value + '"]').remove();
						
			//var removeKeyword = $(this).data('search');
						
	    	var data = $('#filters #ages-form, #filters #skills-form, #filters #keywords-form').serializeArray();
	    	
	    	console.log(data);	

			/*
			allKeywords = jQuery.grep(allKeywords, function(value) {
				return value != removeKeyword;
			});
						
			data.push({
			    name: "search",
			    value: allKeywords
			});

			*/
			
			var result = $.param(data);
	    	
	    	$.ajax({
				type: "GET",
				data: data,
				url: theme + "/inc/search_all.php",
				beforeSend: function() {
		           $('#bands').html('<div class="loading" />');
		        },
				success: function(data) {
					$('#bands').html(data);
 					window.history.pushState("object or string", "Title", "?" + result);
	 	        },
		        complete: function() {
		        	searchClick();
		        	$("input.keyword").val("");
		        },
				async: false
			});
			
			e.preventDefault();
	    });
	    
	    
	    

		$(".term-click").click(function(e) {
			e.preventDefault();
			var removeKeyword = $(this).data('search');
			
			$('input[value="' + removeKeyword + '"]').closest('label').trigger('click');
						
	    	var data = $('#filters #ages-form, #filters #skills-form').serializeArray();		
			
			var arr = Object.keys(data).map(function (key) { return data[key]; });
						
			console.log(data);
				
 			var result = $.param(data);

						
	    	$.ajax({
				type: "GET",
				data: data,
				url: theme + "/inc/search_all.php",
				beforeSend: function() {
		           $('#bands').html('<div class="loading" />');
		        },
				success: function(data) {
					$('#bands').html(data);
 				window.history.pushState("object or string", "Title", "?" + result);
	 	        },
		        complete: function() {
		        	searchClick();
		        	$("input.keyword").val("");
		        },
				async: false
			});
	    });


	}
    
}


function toggle() {
	$('a#toggle').click(function(e) {
		e.preventDefault();
		$('body').toggleClass('open');
	});
	
/*
	$('html').click(function() {
		$('body').removeClass('open');
	});
*/
	
	$('#nav, a#toggle').click(function(event){
	    event.stopPropagation();
	});
	
	$('html').on('touchstart', function(e) {
		$('body').removeClass('open');
	});
			
	$('#nav, a#toggle').on('touchstart',function(e) {
	    e.stopPropagation();
	});
	
	$('.searchbtn a').click(function(e) {
		e.preventDefault();
		$('body').toggleClass('searcher');
		$('#searchform input[type="text"]').focus();
	});
	$('a#search').click(function(){
		$(this).closest('#search-box').find('form input[type="submit"]').trigger('click');
	});
}

function dropdown() {
	
	$('#nav li.has-drop, .drop-down').hover(function() {
		$('body').addClass('subbed');
		console.log('subbed');
	}, function() {
		$('body').removeClass('subbed');
	});
	
	$(document).mouseup(function(e) {
	    var container = $(".sub-menu, .has-drop");
	
	    // if the target of the click isn't the container nor a descendant of the container
	    if (!container.is(e.target) && container.has(e.target).length === 0) 
	    {
	        $('body').removeClass('subbed');
	    }
	});
	
}

function searchText() {
	$('.search-text').keyup(function(event) {
		$val = $('.search-text').val();
		$("a#search").attr("href", "/search/?search%5B%5D=" + $val);
		
		if (event.which == 13) {
	        
            window.location.href = "/search/?search%5B%5D=" + $val;
            
            return false;
        }
	});
}

function dotAnimation() {

	$(window).bind('scroll', function() {
	    if($(window).scrollTop() >= $('#banner.ball').offset().top + $('#banner.ball').outerHeight() - window.innerHeight) {
	        $('.ball-bounce').addClass('play');
	    }
	});
	
	$('.submit_button').click(function(){
	    $('#login-modal .ball-bounce').addClass('play');
	});
	
	$('.submit.button').click(function(){
	    $('.ball-bounce').addClass('play');
	});
	
	$('#filters .submit').click(function(){
	    $('#filters .ball-bounce').addClass('play');
		$('#filters .ball-bounce').find('.bb').attr("src", "../wp-content/themes/plinkit/img/ball_bounce.gif");
	});


}

function expandSearch() {
	$('.search-box h2').click(function(){
		$('body').toggleClass('show-search');
// 		matchHeight();
	});
}

function accordion() {
	$('.accordion-title').click(function(){
		$(this).toggleClass('open');
		$(this).next('.accordion-inner').slideToggle();
	})
}

function table() {
	$( "table" ).wrap( "<div class='table-wrapper'></div>" );
}

function form() {
	$('select#kids').change(function(){
		if($(this).val() == '1'){
			$('li.wppb-form-field').removeClass('show');
			$('li#wppb-form-element-19').addClass('show');
			$('li#wppb-form-element-20').addClass('show');
		}
		if($(this).val() == '2'){
			$('li.wppb-form-field').removeClass('show');
			$('li#wppb-form-element-19').addClass('show');
			$('li#wppb-form-element-20').addClass('show');
			$('li#wppb-form-element-21').addClass('show');
			$('li#wppb-form-element-25').addClass('show');
		}
		if($(this).val() == '3'){
			$('li.wppb-form-field').removeClass('show');
			$('li#wppb-form-element-19').addClass('show');
			$('li#wppb-form-element-20').addClass('show');
			$('li#wppb-form-element-21').addClass('show');
			$('li#wppb-form-element-25').addClass('show');
			$('li#wppb-form-element-22').addClass('show');
			$('li#wppb-form-element-26').addClass('show');
		}
		if($(this).val() == '4'){
			$('li.wppb-form-field').removeClass('show');
			$('li#wppb-form-element-19').addClass('show');
			$('li#wppb-form-element-20').addClass('show');
			$('li#wppb-form-element-21').addClass('show');
			$('li#wppb-form-element-25').addClass('show');
			$('li#wppb-form-element-22').addClass('show');
			$('li#wppb-form-element-26').addClass('show');
			$('li#wppb-form-element-23').addClass('show');
			$('li#wppb-form-element-27').addClass('show');
		}
		if($(this).val() == '5+'){
			$('li.wppb-form-field').removeClass('show');
			$('li#wppb-form-element-19').addClass('show');
			$('li#wppb-form-element-20').addClass('show');
			$('li#wppb-form-element-21').addClass('show');
			$('li#wppb-form-element-25').addClass('show');
			$('li#wppb-form-element-22').addClass('show');
			$('li#wppb-form-element-26').addClass('show');
			$('li#wppb-form-element-23').addClass('show');
			$('li#wppb-form-element-27').addClass('show');
			$('li#wppb-form-element-24').addClass('show');
			$('li#wppb-form-element-28').addClass('show');
		}
	});

	$(document).ready(function() {

		$('input#parent_16').change(function(){
		    if (this.checked) {
		        $('li#wppb-form-element-17').addClass('active');
		    } else {
			    $('select#kids').val('Select Number');
		        $('li#wppb-form-element-17').removeClass('active');
				$('#wppb-edit-user-optional li').removeClass('show');
		        $('li.wppb-form-field').removeClass('show');
		    }
		}); 
	
	});
}

function cookie() {
	
	var $visits = $.cookie("visits");
	
	if( $visits === undefined ) {   //see if it is null
        $.cookie( 'visits', '1',  { expires: 7, path: '/' } );  //set default value
        $visits = 1;  //set the value to zero
    }
    
    var $visitsValue = parseInt($visits,10);
    $visitsValue++;
    $.cookie("visits", $visitsValue, { expires: 7, path: '/' });
    
       
    if($visits == 5) {

	    var inst = $('#signup-modal').remodal();
		inst.open();

    }
    
    console.log($visits);
    
}

function imgLoad() {
	$(function(){
	    $.each(document.images, function(){
	       var this_image = this;
	       var src = $(this_image).attr('src') || '' ;
	       if(!src.length > 0){
	           //this_image.src = options.loading; // show loading
	           var lsrc = $(this_image).attr('lsrc') || '' ;
	           if(lsrc.length > 0){
	               var img = new Image();
	               img.src = lsrc;
	               $(img).load(function() {
	                   this_image.src = this.src;
	               });
	           }
	       }
	   });
	});
}