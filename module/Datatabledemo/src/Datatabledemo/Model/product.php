<?php

namespace Datatabledemo\Model;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class product implements ServiceManagerAwareInterface
{
	
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY = 'Datatabledemo\Model\Entity\product';
	  
	/**
	 * @var ServiceManager
	 */
	protected $serviceManager;
	
	/**             
	 * @var Doctrine\ORM\EntityManager
 	 */                
	protected $entityManager;
	
	/**             
	 * @var Doctrine\ORM\EntityManager\Repository
 	 */                
	protected $repository;

	/**
	 * @param ServiceManager $serviceManager
	 * @return Form
	 */
	public function setServiceManager(ServiceManager $serviceManager)
	{
		$this->serviceManager = $serviceManager;
		$this->entityManager  = $serviceManager->get('doctrine.entitymanager.orm_default');
		$this->repository     = $this->entityManager->getRepository(self::ENTITY);		
		return $this;
	}
        
        /**
	 * Get all Product Details 
	 */
	public function GetAllProductDetails()
	{
            $qb = $this->entityManager->createQueryBuilder();
            return $qb->select('p')
                    ->from(self::ENTITY,'p')
                    ->getQuery()
                    ->getArrayResult();
        }
        
        public function deleteProducts($productId) 
        {
            $qb = $this->entityManager->createQueryBuilder();
            
            if(is_array($productId))
            {
                $qb->delete(self::ENTITY, 'p')
                    ->where($qb->expr()->in('p.Id', $productId))
                    ->getQuery()
                    ->execute();
                
            }
            else
            {   
                $qb->delete(self::ENTITY, 'p')
                    ->where('p.Id =' .$productId)
                    ->getQuery()
                    ->execute();
            }   
        }
        
}