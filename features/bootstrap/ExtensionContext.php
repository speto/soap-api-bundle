<?php
/**
 * File: FeatureContext.php
 * Created at: 2014-12-02 06:33
 */

namespace Webit\Bundle\SoapApiBundle\Features;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use PHPUnit_Framework_Assert as Assert;

/**
 * Class FeatureContext
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class ExtensionContext implements Context, SnippetAcceptingContext
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $this->container->setParameter('kernel.debug', true);
        $this->container->setParameter('kernel.bundles', array());
        $this->container->setParameter('kernel.cache_dir', sys_get_temp_dir());
    }

    /**
     * @Given Extension :extensionClass is loaded
     */
    public function extensionIsLoaded($extensionClass)
    {
        $this->extensionIsLoadedWithConfig($extensionClass);
    }

    /**
     * @Given Extension :extensionClass is loaded with :config
     */
    public function extensionIsLoadedWithConfig($extensionClass, $config = null)
    {
        /** @var Extension $extension */
        $extension = new $extensionClass;
        $configs = $config ? array($config) : array();
        $extension->load($configs, $this->container);
    }

    /**
     * @When I load extension :extensionClass
     */
    public function iLoadExtension($extensionClass)
    {
        /** @var Extension $extension */
        $extension = new $extensionClass;
        $extension->load(array(), $this->container);
    }

    /**
     * @Then There should be following services in container:
     */
    public function thereShouldBeFollowingServicesInContainer(PyStringNode $string)
    {
        foreach ($string->getStrings() as $line) {
            $arServices = explode(',', $line);
            foreach ($arServices as $serviceName) {
                $serviceName = trim($serviceName);
                if (empty($serviceName)) {continue;}
                Assert::assertTrue(
                    $this->container->has($serviceName),
                    sprintf('Required service "%s" has not been registered in Container', $serviceName)
                );
            }
        }
    }
}
