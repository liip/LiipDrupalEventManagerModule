<?php

namespace Liip\Drupal\Modules\EventManager;

use lapistano\ProxyObject\ProxyBuilder;
use Liip\Drupal\Modules\DrupalConnector\ConnectorFactory;

class EventManagerTestCase extends \PHPUnit_Framework_Testcase
{
     /**
     * Provides a stub for the Common class of the DrupalConnector Module.
     *
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject|\Liip\Drupal\Modules\DrupalConnector\Common
     */
    protected function getDrupalCommonConnectorMock(array $methods = array())
    {
        return $this->getMockBuilder('\\Liip\\Drupal\\Modules\\DrupalConnector\\Common')
            ->setMethods($methods)
            ->getMock();
    }

     /**
     * Provides a stub for the Factory class of the DrupalConnector Module.
     *
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject|ConnectorFactory
     */
    protected function getDrupalConnectorFactoryMock(array $methods = array())
    {
        return $this->getMockBuilder('\\Liip\\Drupal\\Modules\\DrupalConnector\\ConnectorFactory')
            ->setMethods($methods)
            ->getMock();
    }

    /**
     * Provides a fixture of the Common class of the Drupal Connector
     *
     * @param array $methods
     * @return  \PHPUnit_Framework_MockObject_MockObject|\Liip\Drupal\Modules\DrupalConnector\Common
     */
    protected function getDrupalCommonConnectorFixture(array $methods = array())
    {
        $methods = array_merge($methods, array('variable_get'));

        $drupalCommonConnector = $this->getDrupalCommonConnectorMock($methods);
        $drupalCommonConnector
            ->expects($this->once())
            ->method('variable_get')
            ->with(
            $this->isType('string'),
            $this->isType('array')
        )
            ->will(
            $this->returnValue(array())
        );

        if (in_array('variable_set', $methods)) {
            $drupalCommonConnector
                ->expects($this->once())
                ->method('variable_set')
                ->with(
                $this->isType('string')
            );
        }

        if (in_array('t', $methods)) {
            $drupalCommonConnector
                ->expects($this->once())
                ->method('t')
                ->with(
                $this->isType('string')
            );
        }

        return $drupalCommonConnector;
    }

    /**
     * Provides a stub of the \Assert\Assertion class;
     *
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject|\Assert\Assertion
     */
    protected function getAssertionObjectMock(array $methods = array())
    {
        return $this->getMockBuilder('\\Assert\\Assertion')
            ->setMethods($methods)
            ->getMock();
    }

    /**
     * Provides an instance of the ProxyBuilder
     *
     * @param string $className
     *
     * @return \lapistano\ProxyObject\ProxyBuilder
     */
    protected function getProxyBuilder($className)
    {
        return new ProxyBuilder($className);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Liip\Drupal\Modules\EventManager\EventObserverInterface
     */
    protected function getObserverMock()
    {
        return $this->getMockBuilder('\\Liip\\Drupal\\Modules\\EventManager\\EventObserverInterface')
            ->setMethods(array('update'))
            ->getMockForAbstractClass();
    }
}
