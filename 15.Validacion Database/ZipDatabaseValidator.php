<?php
// src/Validator/Constraints/ZipDatabaseValidator.php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


use Doctrine\Persistence\ManagerRegistry;

use Doctrine\DBAL\Connection;
use App\Entity\Zip;
class ZipDatabaseValidator extends ConstraintValidator
{

    /**
     *
     * @var Connection
     */
   private $connection;

   public function __construct(Connection $dbalConnection, ManagerRegistry $doctrine)  {

        $this->connection = $dbalConnection;
		$this->doctrine =$doctrine;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ZipDatabase) {
            throw new UnexpectedTypeException($constraint, ZipDatabase::class);
        }
		
        //$query = $this->connection->query( 'select z from AppBundle:Zip z where z.zip = :zip');
		/*$query = $this->connection->query( 'select zip.* from zip z where z.zip = :zip');
		$query->setParameter( 'zip',$value );
		$zip = $query->getSimpleResult();
		
        */
		/*/$sql = 'SELECT * FROM zips WHERE zip = :zip';
		$query = $this->connection->prepare($sql); 
		$query-> bindParam( 'zip',$value );
        $query->execute();
		$zip = $query->fetchAll();
		if (!$zip) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
		*/
		$zip = $this->doctrine->getRepository(Zip::class)->findByZip($value);
		
		if (!$zip) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
		}
	}	
	
	
}
