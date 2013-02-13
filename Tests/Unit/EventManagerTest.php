<?php

namespace Liip\Drupal\Modules\EventManager;


class EventManagerTest extends EventManagerTestCase
{
    protected function getSubjectFake()
    {
        return $this->getMockBuilder('\\Liip\\Drupal\\Modules\\EventManager\\EventSubjectInterface')
            ->setMethods(array('attach', 'detach', 'notify', 'getData', 'setData'))
            ->getMockForAbstractClass();
    }

    public function testEventManager_getSubject()
    {
        $factory = $this->getMockBuilder('\\Liip\\Drupal\\Modules\\EventManager\\SubjectFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('getSubject'))
            ->getMock();
        $factory
            ->expects($this->once())
            ->method('getSubject')
            ->will($this->returnValue($this->getSubjectFake()));

        $subject = EventManager_getSubject('Tux', $factory);

        $this->assertInstanceOf('\\Liip\\Drupal\\Modules\\EventManager\\EventSubjectInterface', $subject);
    }

    public function testEventManager_attachObserver()
    {
        $observer = $this->getObserverMock();
        $subject = $this->getSubjectFake();
        $subject
            ->expects($this->once())
            ->method('attach')
            ->with(
                $this->isInstanceOf('\\Liip\\Drupal\\Modules\\EventManager\\EventObserverInterface')
            );

        EventManager_attachObserver($observer, $subject);
    }

    public function testEventManager_detachObserver()
    {
        $observer = $this->getObserverMock();
        $subject = $this->getSubjectFake();
        $subject
            ->expects($this->once())
            ->method('detach')
            ->with(
                $this->isInstanceOf('\\Liip\\Drupal\\Modules\\EventManager\\EventObserverInterface')
            );

        EventManager_detachObserver($observer, $subject);
    }

    public function testEventManager_notifyObservers()
    {
        $subject = $this->getSubjectFake();
        $subject
            ->expects($this->once())
            ->method('notify');

        EventManager_notifyObservers($subject);
    }
}
