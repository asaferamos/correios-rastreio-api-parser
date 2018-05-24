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

class RastreioParser{

    private $_conf;
    private $code;
    
    public function __construct($_conf = null) {
        if(is_null($_conf)){
            $_conf = [
                'status' => [
                    'completed' => 'Objeto entregue ao destinatário'
                ],
                'regexp' => [
                    'table'   => '/(?s)(?<=\<table class=\"listEvent sro\"\>)(.*?)(?=\<\/table\>)/',
                    'tr'      => '/(?s)(?<=\<tr\>)(.*?)(?=\<\/tr\>)/',
                    'dtEvent' => '/(?s)(?<=\<td class=\"sroDtEvent\" valign=\"top\">)(.*?)(?=\<\/td\>)/',
                    'lbEvent' => '/(?s)(?<=\<td class=\"sroLbEvent\">)(.*?)(?=\<\/td\>)/',
                    'hour'    => '/[0-9]{2}:[0-9]{2}/',
                    'date'    => '/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/'
                ],
                'urlParser' => 'http://www2.correios.com.br/sistemas/rastreamento/newprint.cfm'
            ];
        }
        
        $this->_conf = $_conf;
    }
    
    public function setCode($code){
        $this->code = $code;
    }
    
    public function getCode(){
        return $this->code;
    }
    
    public function getEventsList(){
        $data = array(
            'objetos' => $this->code
        );
        
        $correiosPage = self::getPage($data);
        
        /**
         * Regexp para captura da <table>
         * @var [type]
         */
        preg_match_all($this->_conf['regexp']['table'], $correiosPage, $cTable, PREG_SET_ORDER,0);
        
        /**
         * Regeexp para captura das <tr>
         * @var [type]
         */
        preg_match_all($this->_conf['regexp']['tr'], $cTable[0][0], $cTr);
        
        
        /* Percorre todas <tr> para capturar eventos */
        $events = [];
        foreach ($cTr[0] as $event_id => $vTr) {
            $Event = new RastreioEvento();
            
            preg_match_all($this->_conf['regexp']['dtEvent'], $vTr, $vTd);
            $new_str = str_replace("&nbsp;", ' ', strip_tags($vTd[0][0]));
            $lines = explode("\n", $new_str);
            
            foreach ($lines as $line) {
                $line = ltrim($line);
                if(!empty($line)){
                    if(preg_match($this->_conf['regexp']['date'],$line)){
                        $Event->setDate($line);
                    }else{
                        if(preg_match($this->_conf['regexp']['hour'],$line)){
                            $Event->setHour($line);
                        }else{
                            $Event->setLocation($line);
                        }
                    }
                }
            }
            
            preg_match_all($this->_conf['regexp']['lbEvent'], $vTr, $vTd);

            $new_str = str_replace("&nbsp;", ' ', strip_tags($vTd[0][0]));
            $lines = explode("\n", $new_str);
            
            $i = 0;
            $description = "";
            foreach ($lines as $line) {
                $line = ltrim($line);
                if(empty($line))
                    continue;
                
                $i++;
                
                if($i == 1)
                    $Event->setLabel($line);
                else {
                    $description .= $line; 
                }
            }
            
            $Event->setDescription($description);            
            $events[] = $Event;
        }
        
        return $events;
    }
    
    public function getEventLast(){        
        return self::getEventsList()[0];
    }
    
    private function getPage($data){
        $ch = curl_init($this->_conf['urlParser']);
        $postString = http_build_query($data, '', '&');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $correiosPage = utf8_encode(curl_exec($ch));
        curl_close($ch);
        
        return $correiosPage;
    }
}