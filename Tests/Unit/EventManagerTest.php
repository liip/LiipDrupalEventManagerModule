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

    public function testDrupalEventManagerModule_getSubject()
    {
        $factory = $this->getMockBuilder('\\Liip\\Drupal\\Modules\\EventManager\\SubjectFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('getSubject'))
            ->getMock();
        $factory
            ->expects($this->once())
            ->method('getSubject')
            ->will($this->returnValue($this->getSubjectFake()));

        $subject = drupaleventmanagermodule_getSubject('Tux', $factory);

        $this->assertInstanceOf('\\Liip\\Drupal\\Modules\\EventManager\\EventSubjectInterface', $subject);
    }

    public function testDrupalEventManagerModule_attachObserver()
    {
        $observer = $this->getObserverMock();
        $subject = $this->getSubjectFake();
        $subject
            ->expects($this->once())
            ->method('attach')
            ->with(
                $this->isInstanceOf('\\Liip\\Drupal\\Modules\\EventManager\\EventObserverInterface')
            );

        drupaleventmanagermodule_attachObserver($observer, $subject);
    }

    public function testDrupalEventManagerModule_detachObserver()
    {
        $observer = $this->getObserverMock();
        $subject = $this->getSubjectFake();
        $subject
            ->expects($this->once())
            ->method('detach')
            ->with(
                $this->isInstanceOf('\\Liip\\Drupal\\Modules\\EventManager\\EventObserverInterface')
            );

        drupaleventmanagermodule_detachObserver($observer, $subject);
    }

    public function testDrupalEventManagerModule_notifyObservers()
    {
        $subject = $this->getSubjectFake();
        $subject
            ->expects($this->once())
            ->method('notify');

        drupaleventmanagermodule_notifyObservers($subject);
    }
}
