<?php
namespace App\Controllers;

class CorreiosController{
    
    private $_conf;
    
    public function __construct($_conf) {
        $this->_conf = CONF;
    }
    
    public function getListEvents($correiosTrack){
        $data = array(
            'objetos' => $correiosTrack
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
            preg_match_all($this->_conf['regexp']['dtEvent'], $vTr, $vTd);
            $new_str = str_replace("&nbsp;", ' ', strip_tags($vTd[0][0]));
            $lines = explode("\n", $new_str);
            
            foreach ($lines as $i => $line) {
                $line = ltrim($line);
                if(!empty($line)){
                    if(preg_match($this->_conf['regexp']['date'],$line)){
                        $events[$event_id]['date'] = $line;
                    }else{
                        if(preg_match($this->_conf['regexp']['hour'],$line)){
                            $events[$event_id]['hour'] = $line;
                        }else{
                            $events[$event_id]['location'] = $line;
                        }
                    }
                }
            }
            
            preg_match_all($this->_conf['regexp']['lbEvent'], $vTr, $vTd);

            $new_str = str_replace("&nbsp;", ' ', strip_tags($vTd[0][0]));
            $lines = explode("\n", $new_str);
            
            foreach ($lines as $line) {
                $line = ltrim($line);
                if(!empty($line))
                    $events[$event_id]['label'] = $line;
            }
        }
        
        return $events;
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