<?php

namespace BSP\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BSP\AccountingBundle\Model\FinancialTransaction as BaseFinancialTransaction;

/**
 * @ORM\Table(name="transactions")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class FinancialTransaction extends BaseFinancialTransaction
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="state", type="integer", nullable=false)
     */
    protected $state;

    /**
     * @ORM\Column(name="reference", type="string", length=255, nullable=false)
     */
    protected $reference;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="BSP\AccountingBundle\Entity\AccountingEntry", mappedBy="transaction")
     */
    protected $accountingEntries;

    /**
     * @ORM\Column(name="extended_data",type="array")
     */
    protected $extendedData;

    /** @ORM\PreUpdate */
    public function preUpdateTransaction()
    {
        parent::incrementUpdatedAt();
    }

}
