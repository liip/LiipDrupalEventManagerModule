<?php

namespace Liip\Drupal\Modules\EventManager;

use Assert\Assertion;
use Liip\Drupal\Modules\Registry\RegistryException;

class SubjectFactoryTest extends EventManagerTestCase
{
    /**
     * Provides a fake object of the \Liip\Drupal\Modules\Registry\RegistryInterface.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRegistryFake()
    {
        return $this->getMockBuilder('\\Liip\\Drupal\\Modules\\Registry\\RegistryInterface')
            ->disableOriginalConstructor()
            ->setMethods(
                array(
                    'register', 'unregister',
                    'isRegistered', 'getContent',
                    'getContentById', 'destroy',
                    'replace'
                )
            )
            ->getMockForAbstractClass();
    }


    /**
     * @covers \Liip\Drupal\Modules\EventManager\SubjectFactory::getSubject
     * @covers \Liip\Drupal\Modules\EventManager\SubjectFactory::__construct
     */
    public function testGetSubject()
    {
        $factory = new SubjectFactory($this->getRegistryFake(), $this->getAssertionObjectMock());

        $this->assertInstanceOf(
            '\\Liip\\Drupal\\Modules\\EventManager\\EventSubject',
            $factory->getSubject('tux')
        );
    }

    /**
     * @dataProvider initSubjectDataprovider
     * @covers \Liip\Drupal\Modules\EventManager\SubjectFactory::initSubject
     */
    public function testInitSubject($return)
    {
        $registry = $this->getRegistryFake();
        $registry
            ->expects($this->once())
            ->method('isRegistered')
            ->will($this->returnValue($return));

        $factory = new SubjectFactory($registry, $this->getAssertionObjectMock());
        $factory->initSubject('tux');

        $subjects = $this->readAttribute($factory, 'subjects');
        $this->assertInstanceOf(
            '\\Liip\\Drupal\\Modules\\EventManager\\EventSubject',
            $subjects['tux']
        );
    }
    public static function initSubjectDataprovider()
    {
        return array(
            'generate new subject' => array(true),
            'get subject from cache' => array(false),
        );
    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\SubjectFactory::initSubject
     */
    public function testInitSubjectExpectingException()
    {
        $connectorFactory = $this->getDrupalConnectorFactoryMock(array('getCommonConnector'));
        $connectorFactory
            ->staticExpects($this->exactly(2))
            ->method('getCommonConnector')
            ->will($this->returnValue($this->getDrupalCommonConnectorMock()));

        $registry = $this->getRegistryFake();
        $registry
            ->expects($this->once())
            ->method('getContent')
            ->will(
                $this->returnValue(array('Tux' => 'invalid Content'))
            );
        $registry
            ->expects($this->once())
            ->method('isRegistered')
            ->will(
                $this->throwException(
                    new RegistryException(RegistryException::DUPLICATE_INITIATION_ATTEMPT_TEXT)
                )
            );

        $factory = $this->getProxyBuilder('\\Liip\\Drupal\\Modules\\EventManager\\SubjectFactory')
            ->setMethods(array('fetchSubjectsFromRegistry'))
            ->setConstructorArgs(array(
                $registry,
                new Assertion()
            ))
            ->setProperties(array('connectorFactory'))
            ->getProxy();

        $factory->connectorFactory = $connectorFactory;
        $factory->initSubject('Tux');

    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\SubjectFactory::fetchSubjectsFromRegistry
     */
    public function testFetchSubjectsFromRegistrationResetRegistryItemValue()
    {
        $connectorFactory = $this->getDrupalConnectorFactoryMock(array('getCommonConnector'));
        $connectorFactory
            ->staticExpects($this->once())
            ->method('getCommonConnector')
            ->will($this->returnValue($this->getDrupalCommonConnectorMock()));

        $registry = $this->getRegistryFake();
        $registry
            ->expects($this->once())
            ->method('getContent')
            ->will(
                $this->returnValue(array('Tux' => 'invalid Content'))
            );

        $factory = $this->getProxyBuilder('\\Liip\\Drupal\\Modules\\EventManager\\SubjectFactory')
            ->setMethods(array('fetchSubjectsFromRegistry'))
            ->setConstructorArgs(array(
                $registry,
                new Assertion()
            ))
            ->setProperties(array('connectorFactory'))
            ->getProxy();

        $factory->connectorFactory = $connectorFactory;

        $factory->fetchSubjectsFromRegistry('Tux');

        $this->assertAttributeInternalType('array', 'subjects', $factory);
    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\SubjectFactory::getDrupalConnectorFactory
     */
    public function testGetDrupalConnectorFactory()
    {
        $factory = $this->getProxyBuilder('\\Liip\\Drupal\\Modules\\EventManager\\SubjectFactory')
            ->setMethods(array('getDrupalConnectorFactory'))
            ->setConstructorArgs(array(
                $this->getRegistryFake(),
                new Assertion()
            ))
            ->getProxy();

        $actual = $factory->getDrupalConnectorFactory();
        $this->assertInstanceOf('\\Liip\\Drupal\\Modules\\DrupalConnector\\ConnectorFactory', $actual);
        $this->assertSame($actual, $factory->getDrupalConnectorFactory());
    }
}
