<?php

/**
 * Description of gooShort
 *
 * @author driverInside
 * 
 */
class gooShort {
    
    // Your API Key. More Info: code.google.com/intl/es-MX/apis/urlshortener/v1/getting_started.html
    private $apiKey = "AIzaSyA-RP5sQhTYobS8Nd9c5caJihVVyIv4Ums";
    // The API url
    private $apiUrl = "https://www.googleapis.com/urlshortener/v1/url";
    
    /**
     * 
     * 
     * @param string $apikey The API key.
     * @return void
     */
    public function gooShort($apikey){
        
        if($apikey){
            
            $this->apiKey = $apikey;
        }
    }
}

?>
