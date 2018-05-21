<?php 

$_conf = [
    'status' => [
        'Objeto entregue ao destinatário' => 'completed'
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

define('CONF',$_conf);
?>