<?php

namespace BSP\AccountingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BSPAccountingExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load(sprintf('%s.yml', $config['db_driver']));
        $loader->load('services.yml');
        
        $this->setType($config['db_driver']);
        
        if (isset($config['account'])) {
        	$this->configureAccount($config['account'], $container);
        }
    }
    
    protected function configureAccount(array $config, ContainerBuilder $container)
    {
        if (isset($config['account'])) {
            $container->setParameter('bsp_accounting.account.class', $config['class']);
        }
    }
    
    protected function setType( $driver )
    {
    	switch ($driver)
    	{
    		case 'mongodb':
    			\Doctrine\ODM\MongoDB\Mapping\Types\Type::addType( 'EncryptedData', 'BSP\AccountingBundle\Type\ExtendedDataType' );
    			break;
    		default:
    			break;
    	}
    }
}
