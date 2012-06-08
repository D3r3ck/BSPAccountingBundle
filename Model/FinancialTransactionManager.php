<?php

namespace BSP\AccountingBundle\Model;

use BSP\AccountingBundle\Model\FinancialTransactionManagerInterface;

abstract class FinancialTransactionManager implements FinancialTransactionManagerInterface
{
	public function findTransactionById( $id )
	{
		return $this->findTransactionBy( array( 'id' => $id ) );
	}
	
	public function findTransactionsByAccount( $account_id, array $orderBy = null, $limit = null, $offset = null )
	{
		return $this->findBy( array( 'account.$id' => $account_id ), $orderBy, $limit, $offset );
	}
	
	function createTransaction( $referenceNumber )
	{
		$class = $this->getClass();
		$transaction = new $class();
		$transaction->setReferenceNumber( $referenceNumber );
		return $transaction;
	}
}