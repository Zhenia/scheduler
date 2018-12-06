<?php

namespace App;

class SourceManager
{
    private $curl;

    public function __construct(){
        $this->curl = curl_init();
    }

    /**
     * Load Application by curl
     * @params integer $id
     * @return string
     */
    public function loadApplicationById($id){
        curl_setopt_array($this->curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://internal-interviews.ascendify.works/getRunTimes/'.$id
        ));
        $result = curl_exec($this->curl);
        return $result;
    }

    public function __destruct(){
        curl_close($this->curl);
    }

}