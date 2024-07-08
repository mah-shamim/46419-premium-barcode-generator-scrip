<?php

/*
 * @author MD ARIFUL HAQUE
 * @name: A to Z SEO Tools v3
 * @copyright 2021 KOVATZ.COM
 *
 */

class whois
{
    private $WHOIS_SERVERS = array(
        "com" => array("whois.verisign-grs.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "net" => array("whois.verisign-grs.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "org" => array("whois.pir.org", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "info" => array("whois.afilias.info", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "biz" => array("whois.neulevel.biz", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "co" => array("whois.verisign-grs.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiration Date:(.*)/"),
        "io" => array("whois.nic.io", "/First Registered :(.*)/", "/Last Updated :(.*)/", "/Expiry :(.*)/"),
        "us" => array("whois.nic.us", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "uk" => array("whois.nic.uk", "/Registered on:(.*)/", "/Last updated:(.*)/", "/Expiry date:(.*)/"),
        "ca" => array("whois.cira.ca", "/Creation date:(.*)/", "/Updated date:(.*)/", "/Expiry date:(.*)/"),
        "in" => array("whois.registry.in", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date: (.*)/"),
        "me" => array("whois.nic.me",  "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ng" => array("whois.nic.net.ng",  "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "tel" => array("whois.nic.tel", "/Domain Registration Date:(.*)/", "/Domain Last Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "mobi" => array("whois.dotmobiregistry.net", "/Created On:(.*)/", "/Last Updated On:(.*)/", "/Expiration Date:(.*)/"),
        "edu" => array("whois.educause.net", "/Domain record activated:(.*)/", "/Domain record last updated:(.*)/", "/Domain expires:(.*)/"),
        "gov" => array("whois.nic.gov", "/created:(.*)/", "/Last update of whois database:(.*)/", "/paid-till:(.*)/"),
        "tv" => array("whois.nic.tv", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ru" => array("whois.tcinet.ru", "/created:(.*)/", "/Last updated on(.*)/", "/paid-till:(.*)/"),
        "ro" => array("whois.rotld.ro", "/Registered On:(.*)/", "/Last Updated:(.*)/", "/Expiry Date:(.*)/"),
        "rs" => array("whois.rnids.rs", "/Registration date:(.*)/", "/Modification date:(.*)/", "/Expiration date:(.*)/"),
        "fr" => array("whois.nic.fr", "/created:(.*)/", "/last-update:(.*)/", "/Expiry Date:(.*)/"),
        "it" => array("whois.nic.it", "/Created:(.*)/", "/Last Update:(.*)/", "/Expire Date:(.*)/"),
        "nl" => array("whois.sidn.nl", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expire Date:(.*)/"),
        "tw" => array("whois.twnic.net.tw", "/Record created on(.*)/", "/Last Update:(.*)/", "/Record expires on(.*)/"),
        "ch" => array("whois.nic.ch", "/First registration date:\n(.*)/", "/Last Update:(.*)/", "/Record expires on(.*)/"),
        "hk" => array("whois.hknic.net.hk", "/Domain Name Commencement Date:(.*)/", "/Last Update:(.*)/", "/Expiry Date:(.*)/"),
        "au" => array("whois.auda.org.au", "/Creation Date:(.*)/", "/Last Modified:(.*)/", "/Expiration Date:(.*)/"),
        "de" => array("whois.denic.de", "/Creation Date:(.*)/", "/Changed:(.*)/", "/Expiration Date:(.*)/"),
        "cn" => array("whois.cnnic.net.cn", "/Registration Date:(.*)/", "/Changed:(.*)/", "/Expiration Date:(.*)/"),
        "asia" => array("whois.nic.asia", "/Domain Create Date:(.*)/", "/Domain Last Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "name" => array("whois.nic.name", "/Created On:(.*)/", "/Expires On:(.*)/", "/Updated On:(.*)/"),
        "aero" => array("whois.aero", "/Created On:(.*)/", "/Updated On:(.*)/", "/Expires On:(.*)/"),
        "pro" => array("whois.registrypro.pro", "/Created On:(.*)/", "/Last Updated On:(.*)/", "/Expiration Date:(.*)/"),
        "travel" => array("whois.nic.travel", "/Domain Registration Date:(.*)/", "/Domain Last Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "ie" => array("whois.iedr.ie", "/registration:(.*)/", "/renewal:(.*)/", "/Expiration Date:(.*)/"),
        "li" => array("whois.nic.li", "/First registration date:\n(.*)/", "/Last Update:(.*)/", "/Record expires on(.*)/"),
        "no" => array("whois.norid.no", "/Created:(.*)/", "/Last updated:(.*)/", "/Record expires on(.*)/"),
        "cc" => array("ccwhois.verisign-grs.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "eu" => array("whois.eu", "/Created On:(.*)/", "/Updated On:(.*)/", "/Expires On:(.*)/"),
        "nu" => array("whois.nic.nu", "/created:(.*)/", "/modified:(.*)/", "/expires:(.*)/"),
        "ws" => array("whois.worldsite.ws", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registrar Registration Expiration Date:(.*)/"),
        "sc" => array("whois2.afilias-grs.net", "/Created On:(.*)/", "/Last Updated On:(.*)/", "/Expiration Date:(.*)/"),
        "at" => array("whois.nic.at", "/Created On:(.*)/", "/changed:(.*)/", "/Expires On:(.*)/"),
        "be" => array("whois.dns.be", "/Registered:(.*)/", "/Updated:(.*)/", "/Expires On:(.*)/"),
        "se" => array("whois.iis.se", "/created:(.*)/", "/modified:(.*)/", "/expires:(.*)/"),
        "nz" => array("whois.srs.net.nz", "/domain_dateregistered:(.*)/", "/domain_datelastmodified:(.*)/", "/domain_datebilleduntil:(.*)/"),
        "mx" => array("whois.mx", "/Created On:(.*)/", "/Last Updated On:(.*)/", "/Expiration Date:(.*)/"),
        "ac" => array("whois.nic.ac", "/First Registered :(.*)/", "/Last Updated :(.*)/", "/Expiry :(.*)/"),
        "sh" => array("whois.nic.sh", "/First Registered :(.*)/", "/Last Updated :(.*)/", "/Expiry :(.*)/"),
        "ae" => array("whois.aeda.net.ae", "/First Registered :(.*)/", "/Last Updated :(.*)/", "/Expiry :(.*)/"),
        "af" => array("whois.nic.af", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ag" => array("whois.nic.ag", "/Created On:(.*)/", "/Last Updated On:(.*)/", "/Expiration Date:(.*)/"),
        "al" => array("whois.ripe.net", "/Created On:(.*)/", "/Last Updated On:(.*)/", "/Expiration Date:(.*)/"),
        "am" => array("whois.amnic.net", "/Registered:(.*)/", "/Last modified:(.*)/", "/Expires:(.*)/"),
        "as" => array("whois.nic.as", "/Registered on (.*)/", "/Last modified:(.*)/", "/Expires:(.*)/"),
        "az" => array("whois.ripe.net", "/Registered:(.*)/", "/Last modified:(.*)/", "/Expires:(.*)/"),
        "ba" => array("whois.ripe.net", "/Registered:(.*)/", "/Last modified:(.*)/", "/Expires:(.*)/"),
        "bg" => array("whois.register.bg", "/activated on:(.*)/", "/Last modified:(.*)/", "/expires at:(.*)/"),
        "bi" => array("whois1.nic.bi", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "bj" => array("whois.nic.bj", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "br" => array("whois.registro.br", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "bt" => array("whois.ripe.net", "/Creation date :(.*)/", "/Last Renewed :(.*)/", "/Expiration date:(.*)/"),
        "by" => array("whois.cctld.by", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiration Date:(.*)/"),
        "bz" => array("whois.belizenic.bz", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiration Date:(.*)/"),
        "cd" => array("whois.nic.cd", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiration Date:(.*)/"),
        "ck" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiration Date:(.*)/"),
        "cl" => array("whois.nic.cl", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "coop" => array("whois.nic.coop", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "cx" => array("whois.nic.cx", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "cy" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "cz" => array("whois.nic.cz", "/registered:(.*)/", "/changed:(.*)/", "/expire:(.*)/"),
        "dk" => array("whois.dk-hostmaster.dk", "/Registered:(.*)/", "/changed:(.*)/", "/Expires:(.*)/"),
        "dm" => array("whois.nic.dm", "/created date:(.*)/", "/updated date:(.*)/", "/expiration date:(.*)/"),
        "dz" => array("whois.nic.dz", "/Date de creation#. . . . . . . . . . . . . . . . .(.*)/", "/updated date:(.*)/", "/expiration date:(.*)/"),
        "ee" => array("whois.eenet.ee", "/registered:(.*)/", "/changed:(.*)/", "/expire:(.*)/"),
        "eg" => array("whois.ripe.net", "/registered:(.*)/", "/changed:(.*)/", "/expire:(.*)/"),
        "es" => array("whois.nic.es", "/registered:(.*)/", "/changed:(.*)/", "/expire:(.*)/"),
        "fi" => array("whois.ficora.fi", "/created:(.*)/", "/modified:(.*)/", "/expires:(.*)/"),
        "fo" => array("whois.nic.fo", "/created:(.*)/", "/modified:(.*)/", "/expires:(.*)/"),
        "gb" => array("whois.ripe.net", "/created:(.*)/", "/modified:(.*)/", "/expires:(.*)/"),
        "2ls" => array("whois.2ls.me", "/registered:(.*)/", "/changed:(.*)/", "/expire:(.*)/"),
        "ge" => array("whois.ripe.net", "/created:(.*)/", "/modified:(.*)/", "/expires:(.*)/"),
        "gl" => array("whois.nic.gl", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "gm" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "gr" => array("whois.ripe.net", "/created:(.*)/", "/modified:(.*)/", "/expires:(.*)/"),
        "gs" => array("whois.nic.gs", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "hm" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "hn" => array("whois.nic.hn", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "hr" => array("whois.dns.hr", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "hu" => array("whois.nic.hu", "/record created:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "il" => array("whois.isoc.org.il", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "int" => array("whois.iana.org", "/created:(.*)/", "/changed:(.*)/", "/expires:(.*)/"),
        "iq" => array("whois.cmc.iq", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ir" => array("whois.nic.ir", "/created-date:(.*)/", "/last-updated:(.*)/", "/expire-date:(.*)/"),
        "is" => array("whois.isnic.is", "/created:(.*)/", "/last-updated:(.*)/", "/expires:(.*)/"),
        "je" => array("whois.je", "/Registered on (.*)/", "/last-updated:(.*)/", "/expires:(.*)/"),
        "jp" => array("whois.jprs.jp", "/Registered on (.*)/", "/last-updated:(.*)/", "/expires:(.*)/"),
        "kg" => array("whois.domain.kg", "/Record created:(.*)/", "/Record last updated on (.*)/", "/Record expires on(.*)/"),
        "kr" => array("whois.kr", "/Registered Date             :(.*)/", "/Last Updated Date           :(.*)/", "/Expiration Date             :(.*)/"),
        "la" => array("whois.nic.la", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "lt" => array("whois.domreg.lt", "/Registered:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "lu" => array("whois.dns.lu", "/registered:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "lv" => array("whois.nic.lv", "/Changed:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ly" => array("whois.nic.ly", "/Created:(.*)/", "/Updated:(.*)/", "/Expired:(.*)/"),
        "ma" => array("whois.registre.ma", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "mc" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "md" => array("whois.nic.md", "/Created:(.*)/", "/Updated Date:(.*)/", "/Expiration date:(.*)/"),
        "mil" => array("whois.ripe.net", "/Created:(.*)/", "/Updated Date:(.*)/", "/Expiration date:(.*)/"),
        "mk" => array("whois.marnet.mk", "/registered:(.*)/", "/changed:(.*)/", "/expire:(.*)/"),
        "ms" => array("whois.nic.ms", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "mt" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "mu" => array("whois.nic.mu", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ir" => array("whois.nic.ir", "/Creation Date:(.*)/", "/last-updated:(.*)/", "/expire-date:(.*)/"),
        //"my" => array("whois.mynic.my", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "za" => array("net-whois.registry.net.za", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "capetown" => array("whois.nic.capetown", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "durban" => array("whois.nic.durban", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "joburg" => array("whois.nic.joburg", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "nf" => array("whois.nic.nf", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "pl" => array("whois.dns.pl", "/created:(.*)/", "/last modified:(.*)/", "/renewal date:(.*)/"),
        "pr" => array("whois.nic.pr", "/Created On:(.*)/", "/last modified:(.*)/", "/Expires On:(.*)/"),
        "pt" => array("whois.dns.pt", "/Creation Date(.*)/", "/last modified:(.*)/", "/Expiration Date(.*)/"),
        "sa" => array("saudinic.net.sa", "/Created on(.*)/", "/Last Updated on:(.*)/", "/Expiration Date(.*)/"),
        "sb" => array("whois.nic.net.sb", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "sg" => array("whois.nic.net.sg", "/Creation Date:		(.*)/", "/Modified Date:		(.*)/", "/Expiration Date:		(.*)/"),
        "si" => array("whois.register.si", "/created:(.*)/", "/Updated Date:(.*)/", "/expire:(.*)/"),
        "sk" => array("whois.sk-nic.sk", "/created:(.*)/", "/Last-update(.*)/", "/Valid-date(.*)/"),
        "sm" => array("whois.nic.sm", "/Registration date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "st" => array("whois.nic.st", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiration Date:(.*)/"),
        "su" => array("whois.tcinet.ru", "/created:(.*)/", "/Updated Date:(.*)/", "/paid-till:(.*)/"),
        "tc" => array("whois.adamsnames.tc", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "tf" => array("whois.nic.tf", "/created:(.*)/", "/last-update:(.*)/", "/Expiry Date:(.*)/"),
        "th" => array("whois.thnic.co.th", "/Created date:(.*)/", "/Updated date:(.*)/", "/Exp date:(.*)/"),
        "tj" => array("whois.ripe.net", "/Created date:(.*)/", "/Updated date:(.*)/", "/Exp date:(.*)/"),
        "tk" => array("whois.nic.tk", "/Domain registered:(.*)/", "/Updated date:(.*)/", "/Record will expire on:(.*)/"),
        "tl" => array("whois.nic.tl", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "tm" => array("whois.nic.tm", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiry :(.*)/"),
        "tn" => array("whois.ati.tn", "/Activation:.........(.*)/", "/Updated Date:(.*)/", "/Expiry :(.*)/"),
        "to" => array("whois.tonic.to", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiry :(.*)/"),
        "tp" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Expiry :(.*)/"),
        "tr" => array("whois.nic.tr", "/Created on..............:(.*)/", "/Updated Date:(.*)/", "/Expires on..............:(.*)/"),
        "ua" => array("whois.ua", "/Record created:(.*)/", "/Record last updated:(.*)/", "/Record expires:(.*)/"),
        "uy" => array("whois.nic.org.uy", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "uz" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "va" => array("whois.ripe.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "vc" => array("whois2.afilias-grs.net", "/Created On:(.*)/", "/Last Updated On:(.*)/", "/Expiration Date:(.*)/"),
        "ve" => array("whois.nic.ve", "/Fecha de CreaciÃ³n:(.*)/", "/Ultima ActualizaciÃ³n:(.*)/", "/Expiration Date:(.*)/"),
        "vg" => array("whois.nic.vg", "/created date:(.*)/", "/updated date:(.*)/", "/expiration date:(.*)/"),
        "sexy" => array("whois.nic.sexy", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "berlin" => array("whois.nic.berlin", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "academy" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "bargains" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "best" => array("whois.nic.best", "/Domain Registration Date:(.*)/", "/Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "bid" => array("whois.nic.bid", "/Domain Registration Date:(.*)/", "/Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "bike" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "black" => array("whois.afilias.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "blue" => array("whois.afilias.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "boutique" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "builders" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "build" => array("whois.nic.build", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "buzz" => array("whois.nic.buzz", "/Domain Registration Date:(.*)/", "/Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "cab" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "camera" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "camp" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "capital" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "cards" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "careers" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "catering" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "center" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ceo" => array("whois.nic.ceo", "/Domain Registration Date:(.*)/", "/Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "cheap" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "cleaning" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "clothing" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "club" => array("whois.nic.club", "/Domain Registration Date:(.*)/", "/Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "kiwi" => array("whois.nic.kiwi", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "cm" => array("whois.netcom.cm", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "codes" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "coffee" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "community" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "company" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "computer" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "construction" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "consulting" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "contractors" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "cool" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "cruises" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "dance" => array("whois.unitedtld.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "dating" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "democrat" => array("whois.unitedtld.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "diamonds" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "directory" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "domains" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "education" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "email" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "engineering" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "enterprises" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "equipment" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "estate" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "events" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "exchange" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "expert" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "exposed" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "farm" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "fish" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "flights" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "florist" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "foundation" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "gallery" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "gift" => array("whois.uniregistry.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "glass" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "graphics" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "gripe" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "guitars" => array("whois.uniregistry.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "guru" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "holdings" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "holiday" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "house" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ink" => array("whois.centralnic.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "institute" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "international" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "kaufen" => array("whois.unitedtld.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "kim" => array("whois.afilias.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "kitchen" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "land" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "lighting" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "limo" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "link" => array("whois.uniregistry.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "luxury" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "maison" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "management" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "marketing" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "meet" => array("whois.afilias.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "menu" => array("whois.nic.menu", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "moda" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ninja" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "onl" => array("whois.afilias-srs.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "partners" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "parts" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "photography" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "photos" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "photo" => array("whois.uniregistry.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "pics" => array("whois.uniregistry.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "pink" => array("whois.afilias.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "plumbing" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "productions" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "properties" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "pub" => array("whois.unitedtld.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "recipes" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "red" => array("whois.afilias.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "rentals" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "repair" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "report" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "reviews" => array("whois.unitedtld.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "rich" => array("whois.afilias-srs.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "rocks" => array("whois.unitedtld.com", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "services" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "shiksha" => array("whois.afilias.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "shoes" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "singles" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "solar" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "solutions" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "supply" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "support" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "systems" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "tattoo" => array("whois.uniregistry.net", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "technology" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "tips" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "today" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "tools" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "trade" => array("whois.nic.trade", "/Domain Registration Date:(.*)/", "/Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "training" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "uno" => array("whois.nic.uno", "/Domain Registration Date:(.*)/", "/Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "vacations" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "ventures" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "viajes" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "villas" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "vision" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "voyage" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "watch" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "webcam" => array("whois.nic.webcam", "/Domain Registration Date:(.*)/", "/Updated Date:(.*)/", "/Domain Expiration Date:(.*)/"),
        "wiki" => array("whois.nic.wiki", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "works" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "xxx" => array("whois.nic.xxx", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "xyz" => array("whois.nic.xyz", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"),
        "zone" => array("whois.donuts.co", "/Creation Date:(.*)/", "/Updated Date:(.*)/", "/Registry Expiry Date:(.*)/"));

    public function whoislookup($domain) {
        $domainAge = $createdDate = $updatedDate = $expiredDate = 'Not Available';
        $domain = Trim($domain);
        if (substr(strtolower($domain), 0, 7) == "http://")
            $domain = substr($domain, 7);
        if (substr(strtolower($domain), 0, 4) == "www.")
            $domain = substr($domain, 4);
        if (preg_match("/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/",
                       $domain))
            return $this->queryWhois("whois.lacnic.net", $domain);
        elseif (preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $domain)){
            $domain_parts = explode('.', $domain);
            $tld = strtolower(array_pop($domain_parts));
            $server = $this->WHOIS_SERVERS[$tld][0];
            if (!$server){
                return array("Error: No appropriate Whois server found for $domain domain!",
                    $domainAge,
                    $createdDate,
                    $updatedDate,
                    $expiredDate);
            }
            if($server == 'net-whois.registry.net.za'){
                if(substr($domain,-5) == 'co.za')
                    $server = 'coza-whois.registry.net.za';
                if(substr($domain,-6) == 'org.za')
                    $server = 'org-whois.registry.net.za';
                if(substr($domain,-6) == 'web.za')
                    $server = 'web-whois.registry.net.za';
            }
            $res = $this->queryWhois($server, $domain);
            if (preg_match($this->WHOIS_SERVERS[$tld][1], $res, $match)){
                $createdDate = Trim($match[1]);
                $createdDate = $this->cleanDate($createdDate,$tld);
                $domainAge = $this->converToAge($createdDate);
            }
            if (preg_match($this->WHOIS_SERVERS[$tld][2], $res, $match)){
                $updatedDate = Trim($match[1]);
                $updatedDate = $this->cleanDate($updatedDate,$tld);
            }
            if (preg_match($this->WHOIS_SERVERS[$tld][3], $res, $match)){
                $expiredDate = Trim($match[1]);
                $expiredDate = $this->cleanDate($expiredDate,$tld);
            }
            if(preg_match_all("/WHOIS Server: (.*)/", $res, $matches)){
                $server = trim(array_pop($matches[1]));
                $resTemp = $this->queryWhois($server, $domain);
                if(trim($resTemp) != '')
                    $res = $resTemp;
            }
            return array($res, $domainAge, $createdDate, $updatedDate, $expiredDate);
        } else
            return array('Invalid Input', $domainAge, $createdDate, $updatedDate, $expiredDate);
    }

    private function queryWhois($server, $domain) {
        $serverIP = gethostbyname(trim($server));
        $extraCom = false;
        if($serverIP != ''){
            if ($server == 'whois.verisign-grs.com' || $server == 'whois.nic.name') {
                $domain = '=' . $domain;
                $extraCom = true;
            }
            if ($server == 'whois.sidn.nl') {
                $domain = ' ' . $domain;
                $extraCom = true;
            }

            if ($server == 'whois.denic.de'){
                $domain = '-T dn ' . $domain;
                $extraCom = true;
            }


            if ($server == 'whois.nic.io' || $server == 'whois.nic.ac' || $server == 'whois.nic.sh'){
                $domain = ' ' . $domain;
                $extraCom = true;
            }

            if($extraCom) {
                $fp = @fsockopen($serverIP, 43, $errno, $errstr, 20) or $out = "Socket Error " . $errno . " - " . $errstr;
                fputs($fp, $domain . "\r\n");
                $out = '';
                while (!feof($fp)) {
                    $out .= fgets($fp);
                }
                fclose($fp);
            }else {

                if(!defined('TMP_DIR'))
                    define('TMP_DIR', APP_DIR.'temp'.D_S);

                $queryFile = TMP_DIR . 'query.txt';

                putMyData($queryFile, $domain . "\r\n");
                $fp = fopen($queryFile, "r");

                if (!function_exists('readFunc')) {
                    function readFunc($ch, $fh, $length = false)
                    {
                        return fread($fh, $length);
                    }
                }

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "telnet://$serverIP:43");
                curl_setopt($ch, CURLOPT_PORT, 43);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_NOPROGRESS, TRUE);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_TELNET);
                curl_setopt($ch, CURLOPT_INFILE, $fp);
                curl_setopt($ch, CURLOPT_INFILESIZE, filesize($queryFile));
                curl_setopt($ch, CURLOPT_READFUNCTION, 'readFunc');
                curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

                $data = curl_exec($ch);
                curl_close($ch);
                $out = nl2br($data);
            }
        }else{
            return 'Unable to resolve WHOIS server IP';
        }
        return $out;
    }

    private function converToAge($age) {
        date_default_timezone_set('UTC');
        $time = time() - strtotime($age);
        $years = floor($time / 31556926);
        $days = floor(($time % 31556926) / 86400);
        if ($years == '1')
            $y = '1 Year';
        else
            $y = $years . ' Years';
        if ($days == '1')
            $d = '1 Day';
        else
            $d = $days . ' Days';

        return "$y, $d";
    }

    private function getMyData($url,$ref_url) {
        $cookie=tempnam("/tmp","CURLCOOKIE");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt ($ch, CURLOPT_REFERER, $ref_url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private function cleanDate($date,$tld) {
        $date = trim(strip_tags($date));
        if ($tld == 'tr')
            $date = Trim(str_replace('.','',$date));
        $date = str_replace('.','/',$date);
        $date = str_replace('(YYYY-MM-DD)','',$date);
        if($tld == 'pt')
            $date = Trim(str_replace('(dd/mm/yyyy):','',$date));
        if ($tld == 'fr' || $tld == 'bg' || $tld == 'lu' || $tld == 'mk' || $tld == 'pt' || $tld == 'tf' || $tld == 'tn')
            $date = str_replace('/','-',$date);
        if ($tld == 'ee' || $tld == 'fi')
            $date = str_replace('/','.',$date);
        if ($tld == 'kr'){
            $date = explode('/',$date);
            $date = Trim($date[0]).'/'.Trim($date[1]).'/'.Trim($date[2]);
        }
        if ($date == 'before Aug-1996')
            $date = '01-Aug-1996';
        $date = explode('T0',$date);
        $date = $date[0];
        $date = explode('T1',$date);
        $date = $date[0];
        $date = explode('T2',$date);
        $date = $date[0];
        $date = date('jS-M-Y',strtotime($date));
        return $date;
    }
    public function cleanUrl($site) {
        $site = strtolower(trim($site));
        $site = str_replace(array('http://','https://','www.'), '', $site);
        $site = parse_url('http://www.'.$site);
        return $site['host'];
    }
}