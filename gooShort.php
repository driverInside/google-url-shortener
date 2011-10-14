<?php

/**
 * PHP class to get a short url using the Google API (goo.gl).
 * 
 *
 * @author driverInside | @driverInside | hiram.eps [at] gmail.com
 * @copyright CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) More Info: creativecommons.org/licenses/by-sa/3.0/
 */
class gooShort {
    
    // Your API Key. More Info: code.google.com/intl/es-MX/apis/urlshortener/v1/getting_started.html
    private $apiKey = "";
    // The API url
    private $apiUrl = "https://www.googleapis.com/urlshortener/v1/url";
    
    /**
     * Constructor
     * 
     * @param string $apikey The API key. Is higjly recommended
     * @return void
     */
    public function gooShort($apikey = ''){
        
        if($apikey != ""){
            
            $this->apiKey = $apikey;
        }
    }
        
    /**
     * 
     * Get the result (as array) of short an url using the google api
     * 
     * 
     * @param string $longUrl The long url
     * @return array The result as a array
     */
    public function short_Array($longUrl){
        
       if( $longUrl == "" ){
           
           return array("");
       }
       
       $url = $this->apiUrl;
       
       if( $this->apiKey != ""){
           
           $url .= '?key=' . $this->apiKey;
       }
       
       // curl init
       $ch = curl_init($url);
       //set options
       $options = array(CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => '{"longUrl": "' . $longUrl . '"}');
       
       curl_setopt_array($ch, $options);
       
       // curl exec
       $res = curl_exec($ch);
       // converting to array
       $res = json_decode($res, true);
       
       return $res;
    }
    
    /**
     *
     * @param string $longUrl The long url
     * @return string The url shortened
     */
    public  function short($longUrl){
        
        $arr = $this->short_Array($longUrl);
        
        // if doesn't exist
        if( isset ($arr['error']) ){
            // return error message
            return $arr['error']['message'];
        }
        
        return $arr['id'];
        
    }
    
    /**
     * 
     * Get an array and the long url from one shortened 
     * 
     * @param string $shortUrl The short url to long
     * 
     */
    public function getLong_Array($shortUrl, $analytics = false){
            
            
            $url = $this->apiUrl;
            // adding the shorturl
            $url .= '?shortUrl=' . $shortUrl;
            
            if($analytics){
                // if analytics is enabled
                $url .= '&projection=FULL';
            }
            if($this->apiKey){
                // not necesary, but is recommended
                $url .= '&key=' . $this->apiKey;
            }
            
            // curl init
            $ch = curl_init($url);
            // set options
            $options = array(CURLOPT_RETURNTRANSFER => true,
                             CURLOPT_SSL_VERIFYPEER => false);
            curl_setopt_array($ch, $options);
            
            $res = curl_exec($ch);
            // converting to array
            $res = json_decode($res, true);
            
            return $res;
    }
    
    /**
     *
     * Get the original long url from one shortened 
     * Use gooShort::getLong_Array() if more data is needed.
     *  
     * 
     * @param string $shortUrl The short url to long
     * @return string  The original url if doesn't exist, return "" (an empty string).
     */
    public function getLong($shortUrl){
        
        $arr = $this->getLong_Array($shortUrl, false);
        
        // if doesn't exist
        if( isset ($arr['error']) ){
            // return error message
            return $arr['error']['message'];
        }
        
        return $arr['longUrl'];
    }
}

?>
