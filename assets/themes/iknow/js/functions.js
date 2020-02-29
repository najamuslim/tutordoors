// JavaScript Document
$(document).ready(function() {

	$(".search-bar").click(function () {
		$(".search-box").toggle("fade" )
	});
	
	//tooltip
	$("[data-toggle='tooltip']").tooltip();

	if($(".bxslider").length){
		$('.bxslider').bxSlider({
			mode: 'fade',
		});
	}

	if($(".bxslider2").length){
		$('.bxslider2').bxSlider({
			pagerCustom: '#bx-pager',
			mode: 'fade',
			onSliderLoad: function(currentIndex) {
				$('.side-imgage').empty();
		      	var img_src = $('#bx-pager [data-slide-index="'+currentIndex+'"]').find('img').prop('src');
		      	$('.side-imgage').append('<img src="'+img_src+'" alt="" width="300">');
		    },
		    onSlideBefore: function($slideElement, oldIndex, newIndex){
		    	$('.side-imgage').empty();
			    var img_src = $('#bx-pager [data-slide-index="'+newIndex+'"]').find('img').prop('src');
		      	$('.side-imgage').append('<img src="'+img_src+'" alt="" width="300">');
		    }
		});
	}

	if($(".gallery").length){
		$("a[rel^='prettyPhoto']").prettyPhoto();
	}


	if($("#owl-carousel").length){
		
		var owl = $("#owl-carousel");
		
		owl.owlCarousel({
		  items : 4, //10 items above 1000px browser width
		  itemsDesktop : [1000,3], //5 items between 1000px and 901px
		  itemsDesktopSmall : [900,3], // betweem 900px and 601px
		  itemsTablet: [600,2], //2 items between 600 and 0
		  itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option
		});
		
		// Custom Navigation Events
		$(".next").click(function(){
			owl.trigger('owl.next');
		})
		$(".prev").click(function(){
			owl.trigger('owl.prev');
		});
	}
	if($(".chart").length){
		$('.chart').easyPieChart({});  
	}
	if($(".accordion_cp").length){
		  //custom animation for open/close
		$.fn.slideFadeToggle = function(speed, easing, callback) {
			return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);
		};

		$('.accordion_cp').accordion({
			defaultOpen: 'section1',
			cookieName: 'nav',
			speed: 'slow',
			animateOpen: function (elem, opts) { //replace the standard slideUp with custom function
				elem.next().stop(true, true).slideFadeToggle(opts.speed);
			},
			animateClose: function (elem, opts) { //replace the standard slideDown with custom function
				elem.next().stop(true, true).slideFadeToggle(opts.speed);
			}
		});
	} 
});

// var map;
// 		var brooklyn = new google.maps.LatLng(40.6743890, -73.9455);
		
// 		var MY_MAPTYPE_ID = 'custom_style';
		
// 		function initialize() {
		
// 		  var featureOpts = [
// 			{
// 			  stylers: [
// 				{ hue: '#b1e7b8' },
// 				{ visibility: 'simplified' },
// 				{ gamma: 0.5 },
// 				{ weight: 0.5 }
// 			  ]
// 			},
// 			{
// 			  elementType: 'labels',
// 			  stylers: [
// 				{ visibility: 'on' }
// 			  ]
// 			},
// 			{
// 			  featureType: 'water',
// 			  stylers: [
// 				{ color: '#b1e7b8' }
// 			  ]
// 			}
// 		  ];
		
// 		  var mapOptions = {
// 			zoom: 12,
// 			center: brooklyn,
// 			mapTypeControlOptions: {
// 			  mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
// 			},
// 			mapTypeId: MY_MAPTYPE_ID
// 		  };
		
// 		  map = new google.maps.Map(document.getElementById('map-canvas'),
// 			  mapOptions);
		
// 		  var styledMapOptions = {
// 			name: 'Custom Style'
// 		  };
		
// 		  var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
		
// 		  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
// 		}
		
// 		google.maps.event.addDomListener(window, 'load', initialize);