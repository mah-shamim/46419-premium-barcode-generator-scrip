var progressLevel = 0;
var hashCode = 0;
var pendingStats = 0;
var domainCount = 2;
var domainType = 2;
var passScore = 0;
var improveScore = 0;
var errorScore = 0;
var splitCode = '::!!::';
var myDomainsArr = new Array();
var websiteUrl, competitorUrl;
var siteData;

$(document).ready(function() {
    $("#sitevssite").click(function() {
        var capKeys = getCapKeys($('#capType').val());
        websiteUrl = cleanUrl($('#websiteUrl').val());
        competitorUrl = cleanUrl($('#competitorUrl').val());
    	var regular = /^([www\.]*)+(([a-zA-Z0-9_\-\.])+\.)+([a-zA-Z0-9]{2,4})+$/;
    	if(!regular.test(websiteUrl)){
   		    sweetAlert(oopsStr, errWebsite, "error");
    		return;
    	}
        if(!regular.test(competitorUrl)){
    		sweetAlert(oopsStr, errCompetitor, "error");
    		return;
    	}
        if(containsAny(websiteUrl, badWords) !== null){
            sweetAlert("Oops...", badStr , "error");
            return false;
        }
        if(containsAny(competitorUrl, badWords) !== null){
            sweetAlert("Oops...", badStr , "error");
            return false;
        }
        swal({
          title: '<br><br><div class="fxLoader" ></div>',
          text: processingStr + '<br><br> <div class="progress"><div id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%">1%</div></div><div id="progress-label"></div>',
          html: true,
          showConfirmButton: false
        });
        
        siteData = {sitevssite:'1', websiteUrl:websiteUrl, competitorUrl:competitorUrl};
        
        if(capKeys[0])
            siteData[capKeys[1]] = capKeys[2];
            
        $.post(apiPath,siteData,function(data){
            data=jQuery.trim(data);
            myDomainsArr = data.split(splitCode);
            if(myDomainsArr[0] == 'verificationfail'){
                //Image Verification Failed
                sweetAlert("Oops...", myDomainsArr[1] , "error");
            }else if(myDomainsArr[0] == 'go'){
                //Domains found on DB
                updateProgress(100,anCompleted);
                comparePath = comparePath.replace("[domain1]", websiteUrl).replace("[domain2]", competitorUrl);
                window.location.href = comparePath;
            }else if(myDomainsArr[0] == '3'){
                //Domains not found on DB
                pendingStats = 1;
                if(myDomainsArr[1] == '0' && myDomainsArr[2] == '0'){
                    $('#progress-label').html('<span style="color: #c0392b;">'+errorStr+': '+inputError1+'</span>');
                }else{
                    var hashCodeFirst = myDomainsArr[1];
                    var hashCodeSec = myDomainsArr[2];
                    domainType = 1;
                    processUrl(hashCodeFirst,hashCodeSec);
                }
            }else if(myDomainsArr[0] == '2'){
                //Competitor domain not found on DB
                if(myDomainsArr[1] == '0'){
                    $('#progress-label').html('<span style="color: #c0392b;">'+errorStr+': '+inputError2+'</span>');
                }else{
                    domainCount = 1;
                    var hashCode = myDomainsArr[1];
                    domainType = 2;
                    processUrl('0',hashCode);
                }
            }else if(myDomainsArr[0] == '1'){
                //User domain not found on DB
                if(myDomainsArr[1] == '0'){
                    $('#progress-label').html('<span style="color: #c0392b;">'+errorStr+': '+inputError1+'</span>');
                }else{
                    domainCount = 1;
                    domainType = 1;
                    var hashCode = myDomainsArr[1];
                    processUrl(hashCode,'0');
                }
            }else{
                //Failed
                $('#progress-label').html('<span style="color: #c0392b;">'+errorStr+': '+data+'</span>');
            }
        });
        
    });
});

function processUrl(hashCodeFirst,hashCodeSec){
    var inputHost;
    if(pendingStats == 1){
        inputHost = competitorUrl;
        hashCode = hashCodeSec;
    }else{
        if(domainType == 1){
            inputHost = websiteUrl;
            hashCode = hashCodeFirst;
        }else{
            inputHost = competitorUrl;
            hashCode = hashCodeSec;
        }
    }
    var myArr = new Array();
    $.post(domainPath,{meta:'1', metaOut:'1', hashcode:hashCode, url:inputHost},function(data){
        $.get(domainPath+'&getImage&site='+inputHost,function(data){
        });
        updateProgress(5,str1);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox").html(myArr[0]);updateScore();
        $("#seoBox").html(myArr[1]);updateScore();
        $.post(domainPath,{heading:'1', headingOut:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str2);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{image:'1', loaddom:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str3);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{keycloud:'1', keycloudOut:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str4);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{keyConsistency:'1', meta:'1', heading:'1', keycloud:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str5);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{textRatio:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str6);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{gzip:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str7);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{www_resolve:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str8);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{ip_can:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str9);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{in_page:'1', loaddom:'1', inPageoutput:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(3,str10);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox").html(myArr[0]);updateScore();
        $("#seoBox").html(myArr[1]);updateScore();
        $("#seoBox").html(myArr[2]);updateScore();
        $.post(domainPath,{in_page:'1', loaddom:'1', brokenlinks:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str11);
        $("#seoBox").html(data);updateScore();
        });//End of Broken Links
        $.post(domainPath,{sitemap:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str12);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{robot:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str13);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{embedded:'1', loaddom:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str14);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{iframe:'1', loaddom:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str15);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{whois:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2,str16);
        $.post(domainPath,{indexedPages:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str17);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{backlinks:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(3,str18);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox").html(myArr[0]);updateScore();
        $.post(domainPath,{urlLength:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2,str19);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox").html(myArr[0]);updateScore();
        $.post(domainPath,{errorPage:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str20);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{pageLoad:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(3,str21);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox").html(myArr[0]);updateScore();
        $("#seoBox").html(myArr[1]);updateScore();
        $("#seoBox").html(myArr[2]);updateScore();
        $.post(domainPath,{pageSpeedInsightChecker:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2,str22);
        myArr = data.split('!!!!8!!!!');
        //$("#seoBox").html(myArr[0]);updateScore();
        //$("#seoBox").html(myArr[1]);updateScore();
        $.post(domainPath,{availabilityChecker:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2,str23);
        $.post(domainPath,{emailPrivacy:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str24);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{safeBrowsing:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str25);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{mobileCheck:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2,str26);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox").html(myArr[0]);updateScore();
        $.post(domainPath,{mobileCom:'1', loaddom:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str27);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{serverIP:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str28);
        $.post(domainPath,{speedTips:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str29);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{docType:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(2,str30);
        myArr = data.split('!!!!8!!!!');
        $("#seoBox").html(myArr[0]);updateScore();
        $("#seoBox").html(myArr[1]);updateScore();
        $.post(domainPath,{w3c:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str31);
        $.post(domainPath,{encoding:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str32);
        $("#seoBox").html(data);updateScore();
        $.post(domainPath,{socialData:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str33);
        $.post(domainPath,{visitorsData:'1', hashcode:hashCode, url:inputHost},function(data){
        updateProgress(1,str34);
        //$("a#pdfLink").attr("href", pdfUrl);
        //$('#pdfLink').unbind('click');
        $.post(domainPath,{cleanOut:'1', passscore:passScore, improvescore:improveScore, errorscore:errorScore, hashcode:hashCode, url:inputHost},function(data){
        if(pendingStats == 0){
            updateProgress(100,anCompleted);
            comparePath = comparePath.replace("[domain1]", websiteUrl).replace("[domain2]", competitorUrl);
            window.location.href = comparePath;
        }else{
            pendingStats = 0;
            passScore = 0;
            improveScore = 0;
            errorScore = 0;
            processUrl(hashCodeFirst,hashCodeSec);
        }
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
}

function cleanUrl(myURL){
    myURL=jQuery.trim(myURL);
   	if (myURL.indexOf("https://") == 0){myURL=myURL.substring(8);}
    if (myURL.indexOf("http://") == 0){myURL=myURL.substring(7);}
   	if (myURL.indexOf("/") != -1){var xGH=myURL.indexOf("/");myURL=myURL.substring(0,xGH);}
	if (myURL.indexOf(".") == -1 ){myURL+=".com";}
	if (myURL.indexOf(".") == (myURL.length-1)){myURL+="com";}
    return myURL;
}

function updateProgress(Asif,str){
    var color;
    if(domainCount == 1)
        Asif = Asif * 2;
    progressLevel = progressLevel + Asif;
    if(progressLevel < 25)
        color = '#c0392b';
    else if (progressLevel < 50)
        color = '#d35400';
    else if(progressLevel < 75)
        color = '#f39c12';
    else
        color = '#27ae60';
   if(progressLevel > 100)
        progressLevel = 100;
    
    $("#progress-bar").css({"width":progressLevel+"%"});
    $("#progress-bar").text(progressLevel+"%");
    $('#progress-label').html('<span style="color: '+color+';"> '+str+' </span>');
}

function updateScore(){
    var score = document.getElementById("seoBox").childNodes[0].className.toLowerCase();
    if(score == 'passedbox'){
        passScore = passScore+3;
    }else if(score == 'improvebox'){
        improveScore = improveScore+3;
    }else{
        errorScore = errorScore+3;
    }
}