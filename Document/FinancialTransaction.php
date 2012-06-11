<?php

namespace BSP\AccountingBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use BSP\AccountingBundle\Model\FinancialTransaction as BaseFinancialTransaction;

/**
 * @MongoDB\Document(collection="transactions")
 */
class FinancialTransaction extends BaseFinancialTransaction
{	
	/**
	 * @MongoDB\Id
	 */
	protected $id;
	
	/**
	 * @MongoDB\Int
	 */
	protected $state;
	
	/**
	 * @MongoDB\String
	 */
	protected $referenceNumber;
	
	/**
	 * @MongoDB\Date
	 */
	protected $createdAt;
	
	/**
	 * @MongoDB\Date
	 */
	protected $updatedAt;
	
	/**
	 * @MongoDB\EmbedMany(targetDocument="BSP\AccountingBundle\Document\AccountingEntry")
	 */
	protected $accountingEntries;
	
	/** 
	 * @MongoDB\Field(type="EncryptedData" )
	 */
	protected $extendedData;
	
	/** @MongoDB\PreUpdate */
	public function preUpdateTransaction()
	{
		parent::incrementUpdatedAt();
	}
	
}