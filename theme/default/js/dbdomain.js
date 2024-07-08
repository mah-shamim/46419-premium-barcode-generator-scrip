var overScore = 0;
var showSuggestionBox = 0;

function showSuggestion(sugBox) {
    showSuggestionBox = sugBox;
	$('.'+sugBox).slideToggle(100);	
}

function finalScore(){
    $("#passScore").css("width", passScore+'%');
    $("#improveScore").css("width", improveScore+'%');
    $("#errorScore").css("width", errorScore+'%');
    
    $('.second.circle').circleProgress({
    value: passScore / 100,
    animation: false
    });
    $("#overallscore").html(passScore+'<i class="newI">'+scoreTxt+'</i>');
}

$(".seoBox").on("click","a",function(event){
    showSuggestion(showSuggestionBox);
});
    
$("#seoBox4").on("click", ".showMore1", function(){
    jQuery(".hideTr1").fadeIn();
    jQuery(".showMore1").css({"display":"none"});
    jQuery(".showLess1").css({"display":"block"});
    return false;
});
$("#seoBox4").on("click", ".showLess1", function(){
    jQuery(".hideTr1").fadeOut();
    jQuery(".showLess1").css({"display":"none"});
    jQuery(".showMore1").css({"display":"block"});
    var pos = $('.headingResult').offset();
    $('body,html').animate({ scrollTop: pos.top },800);
    return false;
});
$("#seoBox6").on("click", ".showMore2", function(){
    jQuery(".hideTr2").fadeIn();
    jQuery(".showMore2").css({"display":"none"});
    jQuery(".showLess2").css({"display":"block"});
    return false;
});
$("#seoBox6").on("click", ".showLess2", function(){
    jQuery(".hideTr2").fadeOut();
    jQuery(".showLess2").css({"display":"none"});
    jQuery(".showMore2").css({"display":"block"});
    var pos = $('.altImgResult').offset();
    $('body,html').animate({ scrollTop: pos.top },800);
    return false;
});
$("#seoBox8").on("click", ".showMore3", function(){
    jQuery(".hideTr3").fadeIn();
    jQuery(".showMore3").css({"display":"none"});
    jQuery(".showLess3").css({"display":"block"});
    return false;
});
$("#seoBox8").on("click", ".showLess3", function(){
    jQuery(".hideTr3").fadeOut();
    jQuery(".showLess3").css({"display":"none"});
    jQuery(".showMore3").css({"display":"block"});
    var pos = $('.keyConsResult').offset();
    $('body,html').animate({ scrollTop: pos.top },800);
    return false;
});
$("#seoBox13").on("click", ".showMore4", function(){
    jQuery(".hideTr4").fadeIn();
    jQuery(".showMore4").css({"display":"none"});
    jQuery(".showLess4").css({"display":"block"});
    return false;
});
$("#seoBox13").on("click", ".showLess4", function(){
    jQuery(".hideTr4").fadeOut();
    jQuery(".showLess4").css({"display":"none"});
    jQuery(".showMore4").css({"display":"block"});
    var pos = $('.inPage').offset();
    $('body,html').animate({ scrollTop: pos.top },800);
    return false;
});
$("#seoBox14").on("click", ".showMore5", function(){
    jQuery(".hideTr5").fadeIn();
    jQuery(".showMore5").css({"display":"none"});
    jQuery(".showLess5").css({"display":"block"});
    return false;
});
$("#seoBox14").on("click", ".showLess5", function(){
    jQuery(".hideTr5").fadeOut();
    jQuery(".showLess5").css({"display":"none"});
    jQuery(".showMore5").css({"display":"block"});
    var pos = $('.brokenLinks').offset();
    $('body,html').animate({ scrollTop: pos.top },800);
    return false;
});

$("#seoBox22").on("click", ".showMore6", function(){
    jQuery(".hideTr6").fadeIn();
    jQuery(".showMore6").css({"display":"none"});
    jQuery(".showLess6").css({"display":"block"});
    return false;
});
$("#seoBox22").on("click", ".showLess6", function(){
    jQuery(".hideTr6").fadeOut();
    jQuery(".showLess6").css({"display":"none"});
    jQuery(".showMore6").css({"display":"block"});
    var pos = $('.whois').offset();
    $('body,html').animate({ scrollTop: pos.top },800);
    return false;
});

$(document).ready(function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    jQuery.get(domainPath+'&getImage&site='+inputHost,function(data){
         $("#screenshotData").html('<img src="data:image/jpeg;base64,'+data+'"/>');
    });
    finalScore();
});//End of Main Statement