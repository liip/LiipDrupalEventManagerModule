<?php

namespace Liip\Drupal\Modules\EventManager;

class EventSubjectTest extends EventManagerTestCase
{
    /**
     * @covers \Liip\Drupal\Modules\EventManager\EventSubject::attach
     * @covers \Liip\Drupal\Modules\EventManager\EventSubject::__construct
     */
    public function testAttach()
    {
        $observer = $this->getObserverMock();
        $key = sha1(serialize($observer));

        $subject = new EventSubject('Tux');
        $subject->attach($observer);

        $observers = $this->readAttribute($subject, 'observers');

        $this->assertArrayHasKey($key, $observers);
        $this->assertContains($observer, $observers);
    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\EventSubject::attach
     */
    public function testMultipleAttach()
    {
        $observer = $this->getObserverMock();

        $subject = new EventSubject('Tux');
        $subject->attach($observer);
        $subject->attach($observer);
        $subject->attach($observer);

        $observers = $this->readAttribute($subject, 'observers');

        $this->assertContains($observer, $observers);
        $this->assertCount(1, $observers);
    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\EventSubject::detach
     */
    public function testDetach()
    {
        $observer = $this->getObserverMock();

        $subject = new EventSubject('Tux');
        $subject->attach($observer);
        $subject->detach($observer);

        $observers = $this->readAttribute($subject, 'observers');

        $this->assertNotContains($observer, $observers);
    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\EventSubject::notify
     */
    public function testNotify()
    {
        $observer = $this->getObserverMock();
        $observer
            ->expects($this->once())
            ->method('update')
            ->with(
                $this->isInstanceOf('\\Liip\\Drupal\\Modules\\EventManager\\EventSubjectInterface')
            );

        $subject = new EventSubject('Tux');
        $subject->attach($observer);

        $subject->notify();
    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\EventSubject::setData
     */
    public function testSetData()
    {
        $subject = new EventSubject('Tux');
        $subject->setData(array('tux'));

        $this->assertAttributeEquals(array('tux'), 'data', $subject);
    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\EventSubject::getData
     */
    public function testGetData()
    {
        $subject = new EventSubject('Tux');
        $subject->setData(array('tux'));

        $this->assertEquals(array('tux'), $subject->getData());
    }

    /**
     * @covers \Liip\Drupal\Modules\EventManager\EventSubject::getRegistrationKey
     */
    public function testGetRegistrationKey()
    {
        $observer = $this->getObserverMock();
        $key = sha1(serialize($observer));

        $subject = $this->getProxyBuilder('\\Liip\\Drupal\\Modules\\EventManager\\EventSubject')
            ->disableOriginalConstructor()
            ->setMethods(array('getRegistrationKey'))
            ->getProxy();

        $this->assertEquals($key, $subject->getRegistrationKey($observer));
    }
}
