<?php

/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright 2022 KOVATZ.COM
*
*/

//Helper -> ISO Language Codes

function lang_code_to_lnag ($code ){
    $lang = null;
    if( $code == 'ab' ) $lang = 'Abkhazian';
    if( $code == 'aa' ) $lang = 'Afar';
    if( $code == 'af' ) $lang = 'Afrikaans';
    if( $code == 'sq' ) $lang = 'Albanian';
    if( $code == 'am' ) $lang = 'Amharic';
    if( $code == 'ar' ) $lang = 'Arabic';
    if( $code == 'an' ) $lang = 'Aragonese';
    if( $code == 'hy' ) $lang = 'Armenian';
    if( $code == 'as' ) $lang = 'Assamese';
    if( $code == 'ay' ) $lang = 'Aymara';
    if( $code == 'az' ) $lang = 'Azerbaijani';
    if( $code == 'ba' ) $lang = 'Bashkir';
    if( $code == 'eu' ) $lang = 'Basque';
    if( $code == 'bn' ) $lang = 'Bengali (Bangla)';
    if( $code == 'dz' ) $lang = 'Bhutani';
    if( $code == 'bh' ) $lang = 'Bihari';
    if( $code == 'bi' ) $lang = 'Bislama';
    if( $code == 'br' ) $lang = 'Breton';
    if( $code == 'bg' ) $lang = 'Bulgarian';
    if( $code == 'my' ) $lang = 'Burmese';
    if( $code == 'be' ) $lang = 'Byelorussian (Belarusian)';
    if( $code == 'km' ) $lang = 'Cambodian';
    if( $code == 'ca' ) $lang = 'Catalan';
    if( $code == 'zh' ) $lang = 'Chinese';
    if( $code == 'zh-Hans' ) $lang = 'Chinese (Simplified)';
    if( $code == 'zh-Hant' ) $lang = 'Chinese (Traditional)';
    if( $code == 'co' ) $lang = 'Corsican';
    if( $code == 'hr' ) $lang = 'Croatian';
    if( $code == 'cs' ) $lang = 'Czech';
    if( $code == 'da' ) $lang = 'Danish';
    if( $code == 'nl' ) $lang = 'Dutch';
    if( $code == 'en' ) $lang = 'English';
    if( $code == 'eo' ) $lang = 'Esperanto';
    if( $code == 'et' ) $lang = 'Estonian';
    if( $code == 'fo' ) $lang = 'Faeroese';
    if( $code == 'fa' ) $lang = 'Farsi';
    if( $code == 'fj' ) $lang = 'Fiji';
    if( $code == 'fi' ) $lang = 'Finnish';
    if( $code == 'fr' ) $lang = 'French';
    if( $code == 'fy' ) $lang = 'Frisian';
    if( $code == 'gl' ) $lang = 'Galician';
    if( $code == 'gd' ) $lang = 'Gaelic (Scottish)';
    if( $code == 'gv' ) $lang = 'Gaelic (Manx)';
    if( $code == 'ka' ) $lang = 'Georgian';
    if( $code == 'de' ) $lang = 'German';
    if( $code == 'el' ) $lang = 'Greek';
    if( $code == 'kl' ) $lang = 'Greenlandic';
    if( $code == 'gn' ) $lang = 'Guarani';
    if( $code == 'gu' ) $lang = 'Gujarati';
    if( $code == 'ht' ) $lang = 'Haitian Creole';
    if( $code == 'ha' ) $lang = 'Hausa';
    if( $code == 'he' ) $lang = 'Hebrew';
    if( $code == 'iw' ) $lang = 'Hebrew';
    if( $code == 'hi' ) $lang = 'Hindi';
    if( $code == 'hu' ) $lang = 'Hungarian';
    if( $code == 'is' ) $lang = 'Icelandic';
    if( $code == 'io' ) $lang = 'Ido';
    if( $code == 'id' ) $lang = 'Indonesian';
    if( $code == 'in' ) $lang = 'Indonesian';
    if( $code == 'ia' ) $lang = 'Interlingua';
    if( $code == 'ie' ) $lang = 'Interlingue';
    if( $code == 'iu' ) $lang = 'Inuktitut';
    if( $code == 'ik' ) $lang = 'Inupiak';
    if( $code == 'ga' ) $lang = 'Irish';
    if( $code == 'it' ) $lang = 'Italian';
    if( $code == 'ja' ) $lang = 'Japanese';
    if( $code == 'jv' ) $lang = 'Javanese';
    if( $code == 'kn' ) $lang = 'Kannada';
    if( $code == 'ks' ) $lang = 'Kashmiri';
    if( $code == 'kk' ) $lang = 'Kazakh';
    if( $code == 'rw' ) $lang = 'Kinyarwanda (Ruanda)';
    if( $code == 'ky' ) $lang = 'Kirghiz';
    if( $code == 'rn' ) $lang = 'Kirundi (Rundi)';
    if( $code == 'ko' ) $lang = 'Korean';
    if( $code == 'ku' ) $lang = 'Kurdish';
    if( $code == 'lo' ) $lang = 'Laothian';
    if( $code == 'la' ) $lang = 'Latin';
    if( $code == 'lv' ) $lang = 'Latvian (Lettish)';
    if( $code == 'li' ) $lang = 'Limburgish ( Limburger)';
    if( $code == 'ln' ) $lang = 'Lingala';
    if( $code == 'lt' ) $lang = 'Lithuanian';
    if( $code == 'mk' ) $lang = 'Macedonian';
    if( $code == 'mg' ) $lang = 'Malagasy';
    if( $code == 'ms' ) $lang = 'Malay';
    if( $code == 'ml' ) $lang = 'Malayalam';
    if( $code == 'mt' ) $lang = 'Maltese';
    if( $code == 'mi' ) $lang = 'Maori';
    if( $code == 'mr' ) $lang = 'Marathi';
    if( $code == 'mo' ) $lang = 'Moldavian';
    if( $code == 'mn' ) $lang = 'Mongolian';
    if( $code == 'na' ) $lang = 'Nauru';
    if( $code == 'ne' ) $lang = 'Nepali';
    if( $code == 'no' ) $lang = 'Norwegian';
    if( $code == 'oc' ) $lang = 'Occitan';
    if( $code == 'or' ) $lang = 'Oriya';
    if( $code == 'om' ) $lang = 'Oromo (Afaan Oromo)';
    if( $code == 'ps' ) $lang = 'Pashto (Pushto)';
    if( $code == 'pl' ) $lang = 'Polish';
    if( $code == 'pt' ) $lang = 'Portuguese';
    if( $code == 'pa' ) $lang = 'Punjabi';
    if( $code == 'qu' ) $lang = 'Quechua';
    if( $code == 'rm' ) $lang = 'Rhaeto-Romance';
    if( $code == 'ro' ) $lang = 'Romanian';
    if( $code == 'ru' ) $lang = 'Russian';
    if( $code == 'sm' ) $lang = 'Samoan';
    if( $code == 'sg' ) $lang = 'Sangro';
    if( $code == 'sa' ) $lang = 'Sanskrit';
    if( $code == 'sr' ) $lang = 'Serbian';
    if( $code == 'sh' ) $lang = 'Serbo-Croatian';
    if( $code == 'st' ) $lang = 'Sesotho';
    if( $code == 'tn' ) $lang = 'Setswana';
    if( $code == 'sn' ) $lang = 'Shona';
    if( $code == 'ii' ) $lang = 'Sichuan Yi';
    if( $code == 'sd' ) $lang = 'Sindhi';
    if( $code == 'si' ) $lang = 'Sinhalese';
    if( $code == 'ss' ) $lang = 'Siswati';
    if( $code == 'sk' ) $lang = 'Slovak';
    if( $code == 'sl' ) $lang = 'Slovenian';
    if( $code == 'so' ) $lang = 'Somali';
    if( $code == 'es' ) $lang = 'Spanish';
    if( $code == 'su' ) $lang = 'Sundanese';
    if( $code == 'sw' ) $lang = 'Swahili (Kiswahili)';
    if( $code == 'sv' ) $lang = 'Swedish';
    if( $code == 'tl' ) $lang = 'Tagalog';
    if( $code == 'tg' ) $lang = 'Tajik';
    if( $code == 'ta' ) $lang = 'Tamil';
    if( $code == 'lz' ) $lang = 'Asif';
    if( $code == 'tt' ) $lang = 'Tatar';
    if( $code == 'te' ) $lang = 'Telugu';
    if( $code == 'th' ) $lang = 'Thai';
    if( $code == 'bo' ) $lang = 'Tibetan';
    if( $code == 'ti' ) $lang = 'Tigrinya';
    if( $code == 'to' ) $lang = 'Tonga';
    if( $code == 'ts' ) $lang = 'Tsonga';
    if( $code == 'tr' ) $lang = 'Turkish';
    if( $code == 'tk' ) $lang = 'Turkmen';
    if( $code == 'tw' ) $lang = 'Twi';
    if( $code == 'ug' ) $lang = 'Uighur';
    if( $code == 'uk' ) $lang = 'Ukrainian';
    if( $code == 'ur' ) $lang = 'Urdu';
    if( $code == 'uz' ) $lang = 'Uzbek';
    if( $code == 'vi' ) $lang = 'Vietnamese';
    if( $code == 'vo' ) $lang = 'Volap�k';
    if( $code == 'wa' ) $lang = 'Wallon';
    if( $code == 'cy' ) $lang = 'Welsh';
    if( $code == 'wo' ) $lang = 'Wolof';
    if( $code == 'xh' ) $lang = 'Xhosa';
    if( $code == 'yi' ) $lang = 'Yiddish';
    if( $code == 'ji' ) $lang = 'Yiddish';
    if( $code == 'yo' ) $lang = 'Yoruba';
    if( $code == 'zu' ) $lang = 'Zulu';
    if( $code == '') $lang = 'Unknown';
    if( $lang == null) $lang = strtoupper($code);
    return $lang;
}

function addLang($langData,$con){
    //Language Data -> //Sort Order //Enabled //Language Code //Language Name //Author //Hide&Show //Direction(LTR or RTL) //Hreflang att
    $allLangs = array();
    $allLangs = getAllLang($con);
    $allLangs[] = $langData;
    $allLang = serialize($allLangs);
    $query = "UPDATE interface SET available_languages='$allLang' WHERE id='1'";
    mysqli_query($con,$query);
    $query1 = "ALTER TABLE lang ADD $langData[2] text";
    mysqli_query($con,$query1);
    return true;
}

function removeLang($code,$con){
    $newLangs = $allLangs = array();
    $allLangs = getAllLang($con);
    foreach($allLangs as $lang){
        if(!in_array($code,$lang, true))
        $newLangs[] = $lang;
    }
    $newLangs = serialize($newLangs);
    $query = "UPDATE interface SET available_languages='$newLangs' WHERE id='1'";
    mysqli_query($con,$query);
    $query1 = "ALTER TABLE lang DROP COLUMN $code";
    mysqli_query($con,$query1);
    return true;
}

function langStatusChange($code, $status, $con){
    $newLangs = $allLangs = array();
    $allLangs = getAllLang($con);
    foreach($allLangs as $lang){
        if(in_array($code,$lang, true)){
            $newLangs[] = array($lang[0],$lang[1],$lang[2],$lang[3],$lang[4],$status,$lang[6]);
        }else
            $newLangs[] = $lang;
    }
    $newLangs = serialize($newLangs);
    $query = "UPDATE interface SET available_languages='$newLangs' WHERE id='1'";
    mysqli_query($con,$query);
    return true;
}

function langUpdateAll($code, $langArr, $con){
    $newLangs = $allLangs = array();
    $allLangs = getAllLang($con);
    foreach($allLangs as $lang){
        if(in_array($code,$lang, true)){
            $newLangs[] = array($langArr[0],$lang[1],$langArr[1],$langArr[2],$lang[4],$langArr[3],$langArr[4],$langArr[5]);
        }else
            $newLangs[] = $lang;
    }
    $newLangs = serialize($newLangs);
    $query = "UPDATE interface SET available_languages='$newLangs' WHERE id='1'";
    mysqli_query($con,$query);
    return true;
}

function getAvailableLanguages($con){
     $availableLanguages = array();
     $query = mysqli_query($con, "SELECT * FROM interface WHERE id='1'");
     $data = mysqli_fetch_array($query);
     $langArr = unserialize($data['available_languages']); 
     foreach($langArr as $lang){
        if($lang[5]){
            $availableLanguages[] = $lang;
        }
     }
     sort($availableLanguages);
     return $availableLanguages;
}

function langDirection($langData){
    foreach($langData as $lang){
        if($lang[2] == ACTIVE_LANG)
            return $lang[6];
    }
    return 'ltr';
}

function isRTLlang($langData){
    foreach($langData as $lang){
        if($lang[2] == ACTIVE_LANG){
            if($lang[6] == 'rtl')
                return true;
            else
                return false;
        }
    }
    return false;
}

function getAvailableLanguageCodes($con){
     $availableLanguages = array();
     $query = mysqli_query($con, "SELECT * FROM interface WHERE id='1'");
     $data = mysqli_fetch_array($query);
     $langArr = unserialize($data['available_languages']); 
     foreach($langArr as $lang){
        if($lang[5]){
            $availableLanguages[] = $lang[2];
        }
     }
     sort($availableLanguages);
     return $availableLanguages;
}

function getSelectedLang($selectedLang,$con){
    $query = mysqli_query($con, "SELECT * FROM interface WHERE id='1'");
    $data = mysqli_fetch_array($query);
    $langArr = unserialize($data['available_languages']); 
    foreach($langArr as $lang){
        if($lang[2] == $selectedLang){
            return $lang;
        }
    }
    return false;
}

function getLangData($langCode,$con){
    if(strlen($langCode) == 2){
        $langOkay = false;
        $langDataArr = array();
        $query = mysqli_query($con, "SELECT * FROM interface WHERE id='1'");
        $data = mysqli_fetch_array($query);
        $langArr = unserialize($data['available_languages']); 
        foreach($langArr as $lang){
            if($lang[2] == $langCode){
                if(isSelected($lang[5]))
                    $langOkay = true;
            }
        }
        if($langOkay){
            $langCodeData = mysqli_query($con, "SELECT code, $langCode FROM lang");
            while($langCodeDataRow = mysqli_fetch_array($langCodeData,MYSQLI_NUM)) {
               $langDataArr[$langCodeDataRow[0]] = htmlspecialchars_decode($langCodeDataRow[1]);
            }
            return $langDataArr;        
        }
    }
    $_SESSION['twebUserSelectedLang'] = getLang($con); 
    stop('Unable to load the requested language file!');
}

function isLangExists($langCode,$con){
    $allLangArr = getAllLang($con);
    foreach($allLangArr as $langData){
        if($langData[2] == $langCode)
            return true;
    }
    
    return false;
}

function getAllLang($con){
     $query = mysqli_query($con, "SELECT * FROM interface WHERE id='1'");
     $data = mysqli_fetch_array($query);
     return unserialize($data['available_languages']);     
}

function getDefaultLang($con){
    $query =  "SELECT * FROM interface where id='1'";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    $default_lang =  Trim($row['lang']);
    return $default_lang;
}