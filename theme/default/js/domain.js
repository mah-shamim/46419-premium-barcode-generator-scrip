var passScore = 0;
var improveScore = 0;
var errorScore = 0;
var overScore = 0;
var showSuggestionBox = 0;
var progressLevel = 0;

function showSuggestion(sugBox) {
    showSuggestionBox = sugBox;
	$('.'+sugBox).slideToggle(100);	
}

function updateProgress(Asif){
    var color;
    Asif = Asif * 2;
    progressLevel = progressLevel + Asif;
    
   if(progressLevel > 100)
        progressLevel = 100;
    
    $("#progressbar").css({"width":progressLevel+"%"});
    $("#progress-label").html(progressLevel+"%");
}

function initialScore(){
    $("#passScore").css("width", passScore+'%');
    $("#improveScore").css("width", improveScore+'%');
    $("#errorScore").css("width", errorScore+'%');
}

function updateScore(score){
    if(score == 'passedbox'){
        passScore = passScore+3;
    }else if(score == 'improvebox'){
        improveScore = improveScore+3;
    }else{
        errorScore = errorScore+3;
    }
    
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

$(document).ready(function() {
    $("#pdfLink").click(function() {
        alert(pdfMsg);
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    jQuery.get(domainPath+'&getImage&site='+inputHost,function(data){
         $("#screenshotData").html('<img src="data:image/jpeg;base64,'+data+'"/>');
    });
    updateProgress(1);
    var myArr = new Array();
    initialScore();
    $("a#pdfLink").attr("href", '#');
    $.post(domainPath,{meta:'1', metaOut:'1', hashcode:hashCode, url:inputHost},function(data){
        myArr = data.split('!!!!8!!!!');
        updateProgress(5);
        $("#seoBox1").html(myArr[0]);
        updateScore(document.getElementById("seoBox1").childNodes[0].className.toLowerCase());
        $("#seoBox2").html(myArr[1]);
        updateScore(document.getElementById("seoBox2").childNodes[0].className.toLowerCase());
        $("#seoBox3").html(myArr[2]);
        $("#seoBox5").html(myArr[3]);
        $.post(domainPath,{heading:'1', headingOut:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox4").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox4").childNodes[0].className.toLowerCase());
        $.post(domainPath,{image:'1', loaddom:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox6").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox6").childNodes[0].className.toLowerCase());
        $.post(domainPath,{keycloud:'1', keycloudOut:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox7").html(data);
        updateProgress(1);
        $.post(domainPath,{keyConsistency:'1', meta:'1', heading:'1', keycloud:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox8").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox8").childNodes[0].className.toLowerCase());
        $.post(domainPath,{textRatio:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox9").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox9").childNodes[0].className.toLowerCase());
        $.post(domainPath,{gzip:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox10").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox10").childNodes[0].className.toLowerCase());
        $.post(domainPath,{www_resolve:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox11").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox11").childNodes[0].className.toLowerCase());
        $.post(domainPath,{ip_can:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox12").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox12").childNodes[0].className.toLowerCase());
        $.post(domainPath,{in_page:'1', loaddom:'1', inPageoutput:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(3);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox13").html(myArr[0]);
        updateScore(document.getElementById("seoBox13").childNodes[0].className.toLowerCase());
        $("#seoBox17").html(myArr[1]);
        updateScore(document.getElementById("seoBox17").childNodes[0].className.toLowerCase());
        $("#seoBox18").html(myArr[2]);
        updateScore(document.getElementById("seoBox18").childNodes[0].className.toLowerCase());
        $.post(domainPath,{in_page:'1', loaddom:'1', brokenlinks:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox14").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox14").childNodes[0].className.toLowerCase());
        });//End of Broken Links
        $.post(domainPath,{sitemap:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox15").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox15").childNodes[0].className.toLowerCase());
        $.post(domainPath,{robot:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox16").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox16").childNodes[0].className.toLowerCase());
        $.post(domainPath,{embedded:'1', loaddom:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox19").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox19").childNodes[0].className.toLowerCase());
        $.post(domainPath,{iframe:'1', loaddom:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox20").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox20").childNodes[0].className.toLowerCase());
        $.post(domainPath,{whois:'1', hashcode:hashCode, url:inputHost},function(data){
        myArr = data.split('!!!!8!!!!');
        $("#seoBox21").html(myArr[0]);
        $("#seoBox22").html(myArr[1]);
        updateProgress(2);
        $.post(domainPath,{indexedPages:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox42").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox42").childNodes[0].className.toLowerCase());
        $.post(domainPath,{backlinks:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(3);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox43").html(myArr[0]);
        updateScore(document.getElementById("seoBox43").childNodes[0].className.toLowerCase());
        $("#seoBox45").html(myArr[1]);
        $("#seoBox46").html(myArr[2]);
        $.post(domainPath,{urlLength:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox26").html(myArr[0]);
        updateScore(document.getElementById("seoBox26").childNodes[0].className.toLowerCase());
        $("#seoBox27").html(myArr[1]);
        $.post(domainPath,{errorPage:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox28").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox28").childNodes[0].className.toLowerCase());
        $.post(domainPath,{pageLoad:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(3);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox29").html(myArr[0]);
        updateScore(document.getElementById("seoBox29").childNodes[0].className.toLowerCase());
        $("#seoBox30").html(myArr[1]);
        updateScore(document.getElementById("seoBox30").childNodes[0].className.toLowerCase());
        $("#seoBox31").html(myArr[2]);
        updateScore(document.getElementById("seoBox31").childNodes[0].className.toLowerCase());
        $.post(domainPath,{pageSpeedInsightChecker:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox48").html(myArr[0]);
        $("#seoBox49").html(myArr[1]);
        updateScore(document.getElementById("seoBox48").childNodes[0].className.toLowerCase());
        updateScore(document.getElementById("seoBox49").childNodes[0].className.toLowerCase()); 
        $.post(domainPath,{availabilityChecker:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox32").html(myArr[0]);
        $("#seoBox33").html(myArr[1]);
        $.post(domainPath,{emailPrivacy:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1);
        $("#seoBox34").html(data);
        updateScore(document.getElementById("seoBox34").childNodes[0].className.toLowerCase());
        $.post(domainPath,{safeBrowsing:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox35").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox35").childNodes[0].className.toLowerCase());
        $.post(domainPath,{mobileCheck:'1', hashcode:hashCode, url:inputHost},function(data){
        myArr = data.split('!!!!8!!!!');
        $("#seoBox23").html(myArr[0]);
        updateScore(document.getElementById("seoBox23").childNodes[0].className.toLowerCase());
        $("#seoBox24").html(myArr[1]);
        updateProgress(2);
        $.post(domainPath,{mobileCom:'1', loaddom:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox25").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox25").childNodes[0].className.toLowerCase());
        $.post(domainPath,{serverIP:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox36").html(data);
        updateProgress(1);
        $.post(domainPath,{speedTips:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox37").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox37").childNodes[0].className.toLowerCase());
        $.post(domainPath,{docType:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox38").html(myArr[0]);
        updateScore(document.getElementById("seoBox38").childNodes[0].className.toLowerCase());
        $("#seoBox40").html(myArr[1]);
        updateScore(document.getElementById("seoBox40").childNodes[0].className.toLowerCase());
        $.post(domainPath,{w3c:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox39").html(data);
        updateProgress(1);
        $.post(domainPath,{encoding:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox41").html(data);
        updateProgress(1);
        updateScore(document.getElementById("seoBox41").childNodes[0].className.toLowerCase());
        $.post(domainPath,{socialData:'1', hashcode:hashCode, url:inputHost},function(data){
        $("#seoBox44").html(data);
        updateProgress(1);
        $.post(domainPath,{visitorsData:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(100);
        $("#seoBox47").html(data);
        $("a#pdfLink").attr("href", pdfUrl);
        $('#pdfLink').unbind('click');
        $('#progress-bar').fadeOut();
        $.post(domainPath,{cleanOut:'1', passscore:passScore, improvescore:improveScore, errorscore:errorScore, hashcode:hashCode, url:inputHost},function(data){
        });//End Statement
        });//End of PageSpeed Insights
        });//End of Visitors Localization
        });//End of Social Data
        });//End of Backlink Counter / Traffic / Worth
        });//End of Indexed Pages
        });//End of Encoding Type
        });//End of W3C Validity
        });//End of Analytics & Doc Type
        });//End of Speed Tips
        });//End of Server IP
        });//End of Safe Browsing
        });//End of Email Privacy Checker
        });//End of Domain & Typo Availability Checker
        });//End of Page Size / Load Time / Language
        });//End of Custom 404 Page
        });//End of URL Length & Favicon
        });//End of Mobile Compatibility
        });//End of Mobile Friendly Test
        });//End of WHOIS Data
        });//End of Iframe
        });//End of Embedded Object
        });//End of XML Sitemap
        });//End of Robots.txt
        });//End of In-Page Links
        });//End of IP Canonicalization
        });//End of WWW Resolve
        });//End of Gzip
        });//End of Text/HTML Ratio
        });//End of Keywords Consistency
        });//End of Keywords Cloud
        });//End of Image Tag
        });//End of Heading Tag
    });//End of Meta Tag
});//End of Main Statement