<?php

namespace App;

class SourceManager
{
    private $curl;
    private $url;

    /**
     * @param string $url
     */
    public function __construct($url){
        $this->curl = curl_init();
        $this->url = $url;
    }

    /**
     * Load Application by curl
     * @param integer $id
     * @return string
     */
    public function loadApplicationById($id = 0){
        curl_setopt_array($this->curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->url.$id
        ));
        $result = curl_exec($this->curl);
        return $result;
    }

    public function __destruct(){
        curl_close($this->curl);
    }

}