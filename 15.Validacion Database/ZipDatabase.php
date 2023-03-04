<?php
// src/Validator/Constraints/ZipDatabase.php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class  ZipDatabase extends Constraint
{
    public $message = 'El zip "{{ string }}" no valido';
    
     
    public function validatedBy()
    {
        var_dump( \get_class($this).'Validator' );
       return \get_class($this).'Validator';
    }
}
