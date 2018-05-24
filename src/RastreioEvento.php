<?php
/**
 * Correios Rastreio API Parser
 * 2018
 *
 * @author    Asafe Ramos <asafe@asaferamos.com>
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 */

namespace Baru\Correios;

class RastreioEvento{

    private $date, $hour, $location, $label, $description;
    
    public function __construct(){
        $this->date        = null;
        $this->hour        = null;
        $this->location    = null;
        $this->label       = null;
        $this->description = null;
    }
    public function setDate($date){
        $this->date = $date;
        return $this;
    }
    
    public function setHour($hour){
        $this->hour = $hour;
        return $this;
    }
    
    public function setLocation($location){
        $this->location = $location;
        return $this;
    }
    
    public function setLabel($label){
        $this->label = $label;
        return $this;
    }
    
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    public function getHour(){
        return $this->hour;
    }
    
    public function getLocation(){
        return $this->location;
    }
    
    public function getLabel(){
        return $this->label;
    }
    
    public function getDescription(){
        return $this->description;
    }
}