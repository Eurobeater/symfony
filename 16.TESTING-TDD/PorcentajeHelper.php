<?php
// Helper/Porcentaje.php
namespace App\Helper;


class PorcentajeHelper
{
    
	
    static function porcentaje( $valor, $porcentaje) 
    {
        
		/*
		if (!is_numeric($valor) ) {
            throw new \Exception('Invalid value '. $valor);
        }
		
		if (!is_numeric($porcentaje) ) {
            throw new \Exception('Invalid value percent '. $porcentaje);
        }
		
		if( $porcentaje < 0 || $porcentaje > 100 ) {
			
            //throw new \Exception('Invalid value percent '.$porcentaje);
			throw new \InvalidArgumentException('Fake Exception');
        }
		*/
		
		$value = $valor * $porcentaje / 100;
		return( $value );
		
    }
	
	
      
}
    
   
  
   