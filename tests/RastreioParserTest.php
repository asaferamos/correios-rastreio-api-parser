<?php
/**
 * Correios Rastreio API Parser
 * 2018
 *
 * @author    Asafe Ramos <asafe@asaferamos.com>
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 */


class RastreioParserTest extends PHPUnit_Framework_TestCase{
	
	public function testIsThereAnySyntaxError(){
		$var = new Baru\Correios\RastreioParser;
		$this->assertTrue(is_object($var));
		unset($var);
	}
  
	public function testCode(){
		$C = new Baru\Correios\RastreioParser;

		$C->setCode('RE881745030BR');
		$this->assertEquals('RE881745030BR',$C->getCode());
		
		unset($C);
	}
	
	public function testGetEventsList(){
		$C = new Baru\Correios\RastreioParser;

		$C->setCode('RE881745030BR');
		$E = $C->getEventsList();

		foreach ($E as $key => $value) {
			var_dump($value);
		}
		
		unset($C);
	}
}