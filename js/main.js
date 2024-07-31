// Animation
/* AOS.init(); */
jQuery(function() {
  AOS.init();
});


/* jQuery(function () {
  jQuery(document).on('click', '.page-scroll', function (event) {
    var target = jQuery(this).attr("href");
    var target1 = target.split("#");
    if (target1[1] != undefined) {
      jQuery('html, body').stop().animate({
        scrollTop: jQuery("#" + target1[1]).offset().top - 114
      }, 1500);
    }
  });
}); */

//jQuery for page scrolling feature - requires jQuery Easing plugin
jQuery(function() {
	jQuery('a.page-scroll').bind('click', function(event) {
		var $anchor = jQuery(this);
    jQuery('html, body').stop().animate({
			scrollTop: jQuery($anchor.attr('href')).offset().top - jQuery("header.fixed-top").height() -0
		}, 1500, 'easeInOutExpo');
		event.preventDefault();
	});
});



//jQuery to collapse the navbar
jQuery(document).ready(function(e) {
  jQuery('header .navbar-toggler').click( function(){
    jQuery("header .navbar-toggler").toggleClass("open");
    });
});


 //jQuery(document).ready(function(){
//Home Hero Slider
jQuery('.fade-slider').slick({
  dots: false,
  arrows: true,
  infinite: true,
  speed: 600,
  fade: true,
  autoplay: true,
  pauseOnHover: false,
  autoplaySpeed: 5000,
  //accessibility: false,
  cssEase: 'linear',
    responsive: [
    {
      breakpoint: 991,
      settings: {
        arrows: false,
        dots: true,
        
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        dots: true
      }
    }
  ]  
});
  
// For Video Play to end 
$('.fade-slider').on('afterChange', function(event, slick, currentSlide) {
    var vid = $(slick.$slides[currentSlide]).find('video');
    if (vid.length > 0) {
            $('.fade-slider').slick('slickPause');
      $(vid).get(0).play();
    }
});
  $("#video2").bind("ended", function() {
    $('.fade-slider').slick('slickNext');
    $('.fade-slider').slick('slickPlay');
});
   


// Home Testimonials Slider
jQuery('.testimonials-slider').slick({
  dots: true,
  arrows: true,
  infinite: false,slidesToShow: 3, slidesToScroll: 1,
  speed: 600,
  //fade: true,
  autoplay: false,
  pauseOnHover: false,
  //autoplaySpeed: 5000,
  //cssEase: 'linear'  
  responsive: [
    {
      breakpoint: 1199,
      settings: {
        arrows: false,
        dots: true
      }
    },
    {
      breakpoint: 991,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 2
      }
    },
    {
      breakpoint: 575,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1
      }
    }
  ]
});

// Programs Slider
jQuery('.programs-slider').slick({
  dots: false,
  arrows: true,
  infinite: false,slidesToShow: 2, slidesToScroll: 1,
  speed: 600,
  autoplay: true,
  pauseOnHover: false,
  autoplaySpeed: 5000,
  responsive: [
    {
      breakpoint: 1199,
      settings: {
        arrows: false,
        dots: true,
        infinite: true
      }
    },
    {
      breakpoint: 991,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 2
      }
    },
    {
      breakpoint: 767,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1
      }
    }
  ]
});


// Header Sticky
var stickyTop = jQuery(".fixed-top").offset().top;
jQuery(window).scroll(function() {
  var windowTop = jQuery(window).scrollTop();
  if (windowTop > stickyTop) {
    jQuery(".fixed-top").addClass("sticky");
  } else {   
    jQuery(".fixed-top").removeClass("sticky");
  }
}
);


// Popup Js
try{
  jQuery(document).ready(function() {
    jQuery('.popup-youtube, .popup-vimeo').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,
  
      fixedContentPos: false
    });
});
}catch(err){}





// PopUp
jQuery(document).ready(function() {
	jQuery('.popup-with-form').magnificPopup({
		type: 'inline',
		preloader: false,
		focus: '#name',

		// When elemened is focused, some mobile browsers in some cases zoom in
		// It looks not nice, so we disable it:
		callbacks: {
			beforeOpen: function() {
				if($(window).width() < 700) {
					this.st.focus = false;
				} else {
					this.st.focus = '#name';
				}
			}
		}
	});
});
// PopUp
jQuery(document).ready(function() {
	jQuery('.popup-with-team').magnificPopup({
		type: 'inline',
		preloader: false,
		focus: '#name',

		// When elemened is focused, some mobile browsers in some cases zoom in
		// It looks not nice, so we disable it:
		callbacks: {
			beforeOpen: function() {
				if($(window).width() < 700) {
					this.st.focus = false;
				} else {
					this.st.focus = '#name';
				}
			}
		}
	});
});



// Counsellors Slider
jQuery('.counsellors-slider').slick({
  dots: false,
  arrows: true,
  infinite: true,slidesToShow: 3, slidesToScroll: 1,
  speed: 600,
  autoplay: false,
  pauseOnHover: false,
  autoplaySpeed: 5000,
  responsive: [
    {
      breakpoint: 1199,
      settings: {
        arrows: false,
        dots: true
      }
    },
    {
      breakpoint: 991,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 2
      }
    },
    {
      breakpoint: 767,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1
      }
    }
  ]
});

// Counsellors Slider
jQuery('.video-testimonials-slider').slick({
  dots: false,
  arrows: true,
  infinite: false,slidesToShow: 1, slidesToScroll: 1,
  speed: 600,
  autoplay: false,
  pauseOnHover: false,
  autoplaySpeed: 5000,
  responsive: [
    {
      breakpoint: 1199,
      settings: {
        arrows: false,
        dots: true
      }
    }
  ]
});

// // Testimonials Masonry
 try{
jQuery(function(){
     // Masonry
     jQuery(".grid").masonry({ itemSelector: ".grid-item" });
   });
}catch(err){}



// Program Filter
try{
  jQuery(function(){
    // Masonry
    //jQuery(".grid").masonry({ itemSelector: ".grid-item" });
    
    
    // Filter
    jQuery(".controlls").on("click", ".control", function () {
        var a = jQuery(".program-filter").isotope({});
        var e = jQuery(this).attr("data-filter");
        a.isotope({ filter: e });
    });
    jQuery(".controlls").on("click", ".control", function () {
      jQuery(this).addClass("active").siblings().removeClass("active");
    });
  });
  }catch(err){}

  // Onclick Program Add Remove Class
  try{
    jQuery(function () {
      jQuery(".programs-popup").hide();
      var $checkboxes = $('.program-filter .grid-item input[type="checkbox"]');
      $checkboxes.change(function(){
      var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
      if (countCheckedCheckboxes > 0) {
        jQuery(this).parents('.program-block').toggleClass("selected", this.checked)
          jQuery(".programs-popup").slideDown();
      } else { 
          jQuery(".programs-popup").slideUp();
          jQuery(this).parents('.program-block').removeClass("selected");
      }
    // jQuery(".program-filter .grid-item").each(function(){
    //   jQuery(".grid-item .form-check-input").on('click',function() {
    //     jQuery(this).parents('.program-block').toggleClass("selected", this.checked)
    //   }).change();
      });
    });
    }catch(err){}






    