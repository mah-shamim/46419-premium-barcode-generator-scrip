var baseUrl = '/';
var badWords = [];
var badStr = 'Bad Word Found!';
var oopsStr = 'Oops...';
var emptyStr = 'Domain name field can\'t empty!';

function containsAny(str, substrings) {
    for (var i = 0; i != substrings.length; i++) {
       var substring = substrings[i];
       if (str.indexOf(substring) != - 1) {
         return substring;
       }
    }
    return null; 
}

function fixURL() {
    //Check URL
    var myUrl= jQuery.trim($('input[name=url]').val());
    if (myUrl==null || myUrl=="") {
        sweetAlert(oopsStr, emptyStr , "error");
        return false;
    }
    //Fix URL
    if (myUrl.indexOf("http://") == 0) {
        myUrl=myUrl.substring(7);
        document.getElementById("url").value = myUrl;
    }
    if (myUrl.indexOf("https://") == 0) {
        myUrl=myUrl.substring(8);
        document.getElementById("url").value = myUrl;
    }
    if(containsAny(myUrl, badWords) !== null){
        sweetAlert(oopsStr, badStr , "error");
        return false;
    }
    return true;
}

function getCapKeys(capType){
    var postName,capCode;
    var bolCheck = false;
    if(capType == 'phpcap'){
        capCode = $('input[name=scode]').val();
        postName = 'scode';
        bolCheck = true;
    }else if(capType == 'recap'){
        capCode = grecaptcha.getResponse();
        postName = 'g-recaptcha-response';
        bolCheck = true;
    }
    return [bolCheck, postName, capCode];
}

function reloadCap(){
     $('input[name="scode"]').val('');
     $('input[name="scode"]').attr("placeholder", "Loading...");
     $('input[name="scode"]').prop('disabled', true);
     $('#capImg').css("opacity","0.5");
     jQuery.get(baseUrl + 'phpcap/reload',function(data){
        $('#capImg').attr('src', jQuery.trim(data));
        $('input[name="scode"]').attr("placeholder", "");
        $('input[name="scode"]').prop('disabled', false);
        $('#capImg').css("opacity","1");
     });    
}

if (document.getElementById('headturbo')) {
    document.addEventListener('DOMContentLoaded', function () {
      particleground(document.getElementById('headturbo'), {
        dotColor: 'rgba(255,255,255, 0.1)',
        lineColor: 'rgba(255,255,255, 0.2)'
      });
      var intro = document.getElementById('headturbo-wrap');
      intro.style.marginTop = '-435px';
    }, false);
}

jQuery(document).ready(function(){

    var reviewBtnText = $("#review-btn").html();
    var shareBox = 0;
    $(".shareBox").fadeOut();
    
    jQuery("#shareBtn").click(function() {
        if(shareBox == 0){
            $(".shareBox").fadeIn();
            setTimeout(function(){
			var pos = $('#scoreBoard').offset();
			 $('body,html').animate({ scrollTop: pos.top });
			}, 100);
            shareBox = 1;
        }else{
            setTimeout(function(){
			var pos = $('#overview').offset();
			 $('body,html').animate({ scrollTop: pos.top });
			}, 100);
            $(".shareBox").fadeOut();
            shareBox = 0;
        }
    });
    
    if($(window).innerWidth() <= 751) {
        $("#scroll-nav").removeClass('nav-stacked');
        $("#scroll-nav").addClass('nav-inverse');
        $("#review-btn").html('<span class="glyphicon glyphicon-search"></span>');
    } else {
        $("#scroll-nav").removeClass('nav-inverse');
        $("#scroll-nav").addClass('nav-stacked');
        $("#review-btn").html(reviewBtnText);
    }
    
    $(window).resize(function(){

        if($(window).innerWidth() <= 751) {
            $("#scroll-nav").addClass('nav-inverse');
            $("#scroll-nav").removeClass('nav-stacked');
            $("#review-btn").html('<span class="glyphicon glyphicon-search"></span>');
        } else {
            $("#scroll-nav").addClass('nav-stacked');
            $("#scroll-nav").removeClass('nav-inverse');
            $("#review-btn").html(reviewBtnText);
        }
    });

	$(window).scroll(function(){
		if ($('.wrapper-header').offset().top > 50){
			$('.navbar-fixed-top').addClass('top-nav-collapse');
            $('.main-header').css({"padding":"10px"});
		} else {
			$('.navbar-fixed-top').removeClass('top-nav-collapse');
            $('.main-header').css({"padding":"30px"});
		}
	}); 
    
    $('.headturbo-wrap').css({
        'margin-top': -($('.headturbo-wrap').height() / 2)
    });
      
	$('.start-mobile-nav').on('click', function(){
		$('body').toggleClass('open-nav');
	});
	
	$('.wrapper-submenu > a').on('click', function(){
		$(this).next('.submenu').slideToggle();
	});

	$('.mobile-nav .selected-lang').on('click', function(){
		$(this).next('.lang-nav').slideToggle();
    });		
});