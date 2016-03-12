<?php

namespace BSP\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BSP\AccountingBundle\Model\AccountingEntry as BaseAccountingEntry;

/**
 * @ORM\Table(name="accounting_entries")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class AccountingEntry extends BaseAccountingEntry
{
    /**
     * @ORM\ManyToOne(targetEntity="BSP\AccountingBundle\Entity\Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    protected $account;

    /**
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    protected $amount;

    /**
     * @ORM\Column(name="reference", type="string", length=255, nullable=false)
     */
    protected $units;

    /**
     * @ORM\Column(name="reference", type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(name="reference", type="string", length=255, nullable=false)
     */
    protected $trackingId;

    /**
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    protected $transactionType;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="BSP\AccountingBundle\Entity\FinancialTransaction")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="transaction_id", referencedColumnName="id")
     * })
     */
    protected $transaction;

    /** @ORM\PrePersist */
    public function prePersistEntry()
    {
        parent::setCreatedAt();
    }

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function setTransaction( $transaction )
    {
        $this->transaction = $transaction;
    }

}
