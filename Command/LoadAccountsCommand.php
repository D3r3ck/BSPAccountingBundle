<?php

namespace BSP\AccountingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class LoadAccountsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('bsp:accounting:load')
        ->setDescription('Loads the deafault accounts file');
    }
    
    protected function parseAccounts( &$data, $arr, $baseName = '' )
    {
        if ( is_array( $arr ) )
        {
            foreach ( $arr as $key => $value )
            {
                $name = ($baseName == '')? ($key) : $baseName . '.' . $key;
                $this->parseAccounts( $data, $arr[$key], $name );
            }
        }
        else
        {
            $data[$baseName] = $arr;
        }
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $this->getContainer()->getParameter('bsp_accounting.system_accounts');
        $manipulator = $this->getContainer()->get('bsp_accounting.manipulator');
        $loader = Yaml::parse($filename);
        $accounts = array();
        $this->parseAccounts( $accounts, $loader['accounts'] );
        foreach ( $accounts as $name => $id )
        {
            $manipulator->createAccount( $name, 'EUR', 'manual', array( $id ) );            
        }
    }
}
