<?php
/**
 * File: WebitSoapApiExtension.php
 * Created at: 2014-12-02 05:09
 */
 
namespace Webit\Bundle\SoapApiBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class WebitSoapApiExtension
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class WebitSoapApiExtension  extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
