<?php

namespace BSP\AccountingBundle\Util;

use BSP\AccountingBundle\Model\Account;
use BSP\AccountingBundle\Model\AccountingEntry;
use BSP\AccountingBundle\Model\AccountInterface;
use BSP\AccountingBundle\Model\AccountManagerInterface;
use BSP\AccountingBundle\Model\FinancialTransaction;
use BSP\AccountingBundle\Model\FinancialTransactionManager as AbstractFinancialTransacionManager;

class AccountingManipulator
{
    /** @var  AccountManagerInterface $accountManager */
    protected $accountManager;
    /** @var  AbstractFinancialTransacionManager $transactionManager */
    protected $transactionManager;

    public function __construct(AccountManagerInterface $accountManager,
                                AbstractFinancialTransacionManager $transactionManager)
    {
        $this->accountManager     = $accountManager;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param            $name
     * @param            $units
     * @param string     $generator
     * @param array|null $options
     * @return Account
     */
    public function createAccount($name, $units, $generator = 'default', array $options = null)
    {
        /** @var Account $account */
        $account = $this->accountManager->createAccount($generator, $options);
        $account->setName($name);
        $account->setUnits($units);
        $this->accountManager->updateAccount($account);

        return $account;
    }

    /**
     * @param      $reference
     * @param null $extendedData
     * @return FinancialTransaction
     */
    public function createTransaction($reference, $extendedData = null)
    {
        /** @var FinancialTransaction $transaction */
        $transaction = $this->transactionManager->createTransaction();

        // Set the reference number
        $transaction->setReference($reference);

        // Set the extended data
        if ($extendedData !== null) {
            $transaction->setExtendedData($extendedData);
        }

        $this->transactionManager->updateTransaction($transaction);

        return $transaction;
    }

    /**
     * @param $account
     * @return mixed
     * @throws \Exception
     */
    public function balance($account)
    {
        $account = $this->getAccount($account);

        return $this->accountManager->balance($account, $this->transactionManager->getClass());
    }

    /**
     * @param $transaction
     * @param $success
     * @throws \Exception
     */
    public function closeTransaction($transaction, $success)
    {
        $transaction = $this->getTransaction($transaction);
        $transaction->close($success);
        $this->transactionManager->updateTransaction($transaction);
    }

    /**
     * @param $transaction
     * @throws \Exception
     */
    public function cancelTransaction($transaction)
    {
        /** @var FinancialTransaction $transaction */
        $transaction = $this->getTransaction($transaction);
        $transaction->cancel();
        $this->transactionManager->updateTransaction($transaction);
    }

    /**
     * @param      $transaction
     * @param      $account
     * @param      $type
     * @param      $amount
     * @param null $trackingId
     * @param null $description
     * @return mixed
     * @throws \Exception
     */
    public function addAccountingEntry($transaction, $account,
                                       $type, $amount,
                                       $trackingId = null, $description = null)
    {
        /** @var FinancialTransaction $transaction */
        $transaction = $this->getTransaction($transaction);
        /** @var AccountInterface $account */
        $account = $this->getAccount($account);

        // Generating the entry
        $entryClass = $this->transactionManager->getEntryClass();
        /** @var AccountingEntry $entry */
        $entry = new $entryClass();
        $entry->setAccount($account);
        $entry->setTransactionType($type);
        $entry->setAmount($amount);
        if ($trackingId) $entry->setTrackingId($trackingId);
        if ($description) $entry->setDescription($description);

        // Adding Entry
        $transaction->addAcountingEntry($entry);
        $this->transactionManager->updateTransaction($transaction);

        return $transaction;
    }

    /**
     * @return mixed
     */
    public function checkTransactions()
    {
        return $this->transactionManager->checkTransactions();
    }

    /**
     * @param $account
     * @return mixed
     */
    public function getSystemAccount($account)
    {
        return $this->accountManager->findSystemAccount($account);
    }

    /**
     * @param $transaction
     * @return mixed
     * @throws \Exception
     */
    public function getTransaction($transaction)
    {
        if (is_string($transaction)) {
            $ntransaction = $this->transactionManager->findTransactionById($transaction);

            if (!$ntransaction) {
                $ntransaction = $this->transactionManager->findTransactionByReference($transaction);
            }

            if (!$ntransaction) {
                throw new \Exception('Transaction ' . $transaction . ' not found');
            }

            return $ntransaction;
        }

        return $transaction;
    }

    /**
     * @param $account
     * @return mixed
     * @throws \Exception
     */
    public function getAccount($account)
    {
        if (is_string($account)) {
            $naccount = $this->accountManager->findAccountByName($account);
            if (!$naccount) {
                throw new \Exception('Account ' . $account . ' not found');
            }

            return $naccount;
        }

        return $account;
    }
}
