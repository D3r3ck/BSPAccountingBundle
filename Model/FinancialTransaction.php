<?php

namespace BSP\AccountingBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class FinancialTransaction implements FinancialTransactionInterface
{
    protected $id;
    protected $state;
    protected $reference;
    protected $createdAt;
    protected $updatedAt;
    protected $extendedData;
    protected $accountingEntries;

    public function __construct()
    {
        $this->accountingEntries = new ArrayCollection();
        $this->state             = self::STATE_NEW;
        $this->createdAt         = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function isOpen()
    {
        return ($this->getState() == self::STATE_NEW || $this->getState() == self::STATE_PENDING);
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function close($success)
    {
        $this->checkStatus();
        $this->state = $success ? self::STATE_SUCCESS : self::STATE_FAILED;
    }

    public function cancel()
    {
        $this->checkStatus();
        $this->state = self::STATE_CANCELED;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getAccountingEntries()
    {
        return $this->accountingEntries;
    }

    public function setAccountingEntries($entries)
    {
        $this->accountingEntries = $entries;
    }

    public function addAcountingEntry($accountingEntry)
    {
        $this->checkStatus();
        $this->accountingEntries[] = $accountingEntry;
    }

    public function getExtendedData()
    {
        return $this->extendedData;
    }

    // public function setExtendedData(ExtendedDataInterface $extendedData)
    public function setExtendedData($extendedData)
    {
        $this->extendedData = $extendedData;
    }

    /**
     *
     */
    public function incrementUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @throws \Exception
     */
    protected function checkStatus()
    {
        if (!($this->state == self::STATE_NEW || $this->state == self::STATE_PENDING)) {
            Throw new \Exception('This transaction is not new, you can\'t edit');
        }
    }
}
