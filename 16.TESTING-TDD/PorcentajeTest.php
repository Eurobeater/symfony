<?php
// Tests\PorcentajeTest.php
namespace App\Tests;

use PHPUnit\Framework\TestCase;

use App\Helper\PorcentajeHelper;

class PorcentajeTest extends TestCase
{
    
	public function testPorcentaje(): void
    {
        $valor = 100;
		
		$porcentaje = 10;
		
								
		$value = PorcentajeHelper::porcentaje( $valor, $porcentaje);
		
		$this->assertSame ($value, 10);
    }
	/*
	public function testPorcentajeExcepcion(): void
    {
        $valor = 100;
		
		$porcentaje = 1000;
		
					
		$value = PorcentajeHelper::porcentaje( $valor, $porcentaje);
		
		//$test = "PorcentajeHelper::porcentaje";
		//assertException(callable $callback, $expectedException = 'Exception', $expectedCode = null, $expectedMessage = null)
		$this->expectException(InvalidArgumentException::class);
		//$this->assertException( $test, $valor, $porcentaje, 'InvalidArgumentException');
		
    }
	*/
}
