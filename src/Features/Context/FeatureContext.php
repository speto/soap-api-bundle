<?php
/**
 * File: FeatureContext.php
 * Created at: 2014-12-02 06:33
 */


namespace Webit\Bundle\SoapApiBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use PHPUnit_Framework_Assert as Assert;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class FeatureContext
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class FeatureContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    /**
     * @var \AppKernel
     */
    private $kernel;

    /**
     * @When application is up
     */
    public function applicationIsUp()
    {
        $this->kernel->boot();
    }

    /**
     * @Then There should be following services in container:
     * @param PyStringNode $string
     */
    public function thereShouldBeFollowingServicesInContainer(PyStringNode $string)
    {
        foreach ($string->getStrings() as $line) {
            $arServices = explode(',', $line);
            foreach ($arServices as $serviceName) {
                $serviceName = trim($serviceName);
                if (empty($serviceName)) {continue;}
                Assert::assertTrue(
                    $this->kernel->getContainer()->has($serviceName),
                    sprintf('Required service "%s" has not been registered in Container', $serviceName)
                );

                $service = $this->kernel->getContainer()->get($serviceName);
                Assert::assertNotEmpty($service);
            }
        }
    }

    /**
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
}
