<?php

namespace App;

class Application{
    private $id;
    private $checks;

    public function __construct($id = null,$checks = []) {
        $this->id = $id;
        $this->checks = $checks;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = (int)$id;
        return $this;
    }

    public function setChecks($checks = []){
        $this->checks = $checks;
    }

    public function getChecks(){
        return $this->checks;
    }

    /**
     * Get next $count times of the check after current date
     * @param integer $count
     * @return array
    */
    public function getNextChecks($count){
        $timeUTC = date('G')*60+date('i')/10*10;
        $i=0;
        $result = [];
        foreach($this->checks as $key=>$check){
            if($timeUTC<$check){
               $result[$key] = $check;
               $i++;
            }
            if ($i == $count or !next($this->checks)){
               break;
            }
        }
        return $result;
    }


}