<?php

namespace BSP\AccountingBundle\Model;

interface FinancialTransactionInterface
{
    const STATE_CANCELED = 100;
    const STATE_FAILED   = 200;
    const STATE_NEW      = 300;
    const STATE_PENDING  = 400;
    const STATE_SUCCESS  = 500;

    public function getId();

    public function incrementUpdatedAt();

    public function isOpen();

    public function getState();

    public function setState($state);

    public function getReference();

    public function setReference($reference);

    public function getCreatedAt();

    public function getUpdatedAt();

    public function getAccountingEntries();

    public function setAccountingEntries($accountingEntries);

    public function addAcountingEntry($accountingEntry);

    public function getExtendedData();

    // function setExtendedData( ExtendedDataInterface $extendedData );
    public function setExtendedData($extendedData);
}
