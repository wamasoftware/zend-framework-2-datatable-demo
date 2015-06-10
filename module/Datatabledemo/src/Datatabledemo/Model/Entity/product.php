<?php

/**
 * @author Samier Sompura <>
 */

namespace Datatabledemo\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu Doctroine Entity Class 
 * @ORM\Entity
 * @ORM\Table(name="product")
 */

class product
{
	/**
	 * @ORM\id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $Id;
	
	/**
	 * @ORM\Column(length=200);
	 */
	protected $name;
        
        /**
	 * @ORM\Column(length=100);
	 */
	protected $qty;
	
	/**
	 * Magic getter to expose protected properties.
	 * @param string $property
	 * @return mixed
	 */
	public function __get($property) 
	{
		return $this->$property;
	}
	
	/**
	 * Magic setter to save protected properties.
	 * @param string $property
	 * @param mixed $value
	 */
	public function __set($property, $value) 
	{
		$this->$property = $value;
	}
	
	/**
	 * Populate from an array.
	 * @param array $data
	 */ 
	public function populate($data = array()) 
	{	
		foreach ($data as $key => $value)
	  	{
			if (property_exists (__class__,$key)) 
				$this->$key  = $value;
	  	}	
	}
}