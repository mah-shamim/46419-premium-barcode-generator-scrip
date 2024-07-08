<?php

/*
* @author MD ARIFUL HAQUE
* @name Rainbow PHP Framework
* @copyright � 2015 KOVATZ.COM
*
*/


class domainAvailability {
    
    //Response Code - Reason
    //2 - Domain is already taken!
    //3 - Domain is available
    //4 - No WHOIS entry was found for that TLD
    //5 - WHOIS Query failed
    
    protected $servers;
    protected $port = 43;
    protected $response;
    protected $server;
    
    public function __construct($serverList){
        $this->servers = $serverList;
    }
    
    public function parse($domain){
        $domainParse = array();
        $domainParse['domain'] = $domain;
        $domain = explode('.',$domain);
        $domainParse['domain_word'] = $domain[0];
        $domainParse['tld'] = end($domain);
        return $domainParse;
    }
    
    public function isAvailable($domain, $quickCheck = true)
    {
        if ($quickCheck) {
            // Check domain is already taken using DNS / IP Methods!
            if (gethostbyname($domain) !== $domain) {
                return '2';
            }
        }

        $domainParse = $this->parse($domain);

        if (!isset($this->servers[$domainParse["tld"]])) {
            return '4';
        }

        $whoisServerInfo = $this->servers[$domainParse["tld"]];

        if (isset($whoisServerInfo["port"])) {
            $this->setPort($whoisServerInfo["port"]);
        }

        // Fetch the WHOIS server from the serverlist
        $this->setServer($whoisServerInfo["server"]);

        // If the query fails, it returns false
        if (!$this->query($domainParse["domain"])) {
           return '5';
        }

        // Fetch the response from the WHOIS server.
        $whoisData = $this->getResponse();

        // Check if the WHOIS data contains the "not found"-string
        if (strpos($whoisData, $whoisServerInfo["not_found"]) !== false) {
            // The domain is available
            return '3';
        }

        // If we've come this far, the domain is not available.
        return '2';
    }
        
    public function query($domain)
    {
        $response = null;

        $filePointer = @fsockopen($this->server, $this->port, $errno, $errstr, 10);

        // Check if we have a file pointer
        if ($filePointer) {

            // Send our query to the file pointer
            fwrite($filePointer, $this->formatQueryString($domain));

            // Append the response from the server to the response variable until end of file is reached
            while (!feof($filePointer)) {
                $response .= fgets($filePointer, 128);
            }

            // Close the file pointer
            fclose($filePointer);
        } else {
            return false;
        }

        // return the response, even if we never sent a request
        $this->response = $response;

        return true;
    }

    public function formatQueryString($queryString) {
        $temp = strtolower($queryString);
        $temp = trim($temp);
        
        if ($this->server == 'whois.denic.de')    
            $temp = '-T dn ' . $temp;
             
        // Format the domain query according to RFC3912
        return $temp . "\r\n";
    }

    public function getResponse() {
        return $this->response;
    }

    public function getServer() {
        return $this->server;
    }
    
    public function setServer($server) {
        $this->server = $server;
    }

    public function getPort() {
        return $this->port;
    }

    public function setPort($port) {
        $this->port = $port;
    }
}

?>