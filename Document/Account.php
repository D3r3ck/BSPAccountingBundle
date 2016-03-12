<?php

namespace BSP\AccountingBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use BSP\AccountingBundle\Model\Account as BaseAccount;

/**
 * @MongoDB\Document(collection="accounts")
 */
class Account extends BaseAccount
{
    /**
     * @MongoDB\Id(strategy="INCREMENT")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\Int
     */
    protected $status;

    /**
     * @MongoDB\String
     */
    protected $units;

    /**
     * @MongoDB\Date
     */
    protected $createdAt;

    /** @MongoDB\PrePersist */
    public function prePersistAccount()
    {
        parent::setCreatedAt();
    }

}
