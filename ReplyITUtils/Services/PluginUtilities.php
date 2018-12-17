<?php
/**
 * Created by PhpStorm.
 * User: brahmani
 * Date: 15/11/18
 * Time: 16.04
 */

namespace ReplyITUtils\Services;

class PluginUtilities {

    /**
     * @var \Shopware\Components\DependencyInjection\Container
     */
    private $container;

    /**
     * Entity-manager
     */
    private $entityModel;

    /**
     * Plugin's repository
     */
    private $pluginRepository;


    /**
     * PluginUtilities constructor.
     * @param \Shopware\Components\DependencyInjection\Container $container
     */
    public function __construct
    (
        \Shopware\Components\DependencyInjection\Container $container
    )
    {
        $this->container = $container;
        $this->entityModel = $this->container->get('models');
        $this->pluginRepository = $this->entityModel->getRepository('Shopware\Models\Plugin\Plugin');
    }

    /**
     * Check if a plugin exists, is installed and is already active
     * @param $pluginName
     * @return bool
     */
    public function checkIfPluginIsOperative($pluginName){
        if(is_string($pluginName) && !empty($pluginName)) {
            $builder = $this->pluginRepository->createQueryBuilder('plugin');
            $builder->Where('plugin.active = true');
            $builder->andWhere('plugin.name = :pl');
            $builder->setParameter('pl', $pluginName);
            $query = $builder->getQuery();
            $plugin = $query->execute();

            if (count($plugin)) {
                return true;
            }
        }

        return false;
    }
}
