<?php

namespace BSP\AccountingBundle\Document;

use BSP\AccountingBundle\Model\AccountingEntry as BaseAccountingEntry;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation\Timestampable;

/**
 * @MongoDB\EmbeddedDocument
 */
class AccountingEntry extends BaseAccountingEntry
{
    /**
     * @MongoDB\ReferenceOne(targetDocument="BSP\AccountingBundle\Document\Account",simple=true)
     */
    protected $account;

    /**
     * @MongoDB\Int
     */
    protected $amount;

    /**
     * @MongoDB\String
     */
    protected $units;

    /**
     * @MongoDB\String
     */
    protected $description;

    /**
     * @MongoDB\String
     */
    protected $trackingId;

    /**
     * @MongoDB\Int
     */
    protected $transactionType;

    /**
     * @MongoDB\Date
     * @Timestampable(on="create")
     */
    protected $createdAt;

}
