<?php

namespace Liip\Drupal\Modules\EventManager\Subjects;


use Liip\Drupal\Modules\EventManager\EventObserverInterface;
use Liip\Drupal\Modules\EventManager\EventSubjectInterface;

class Noop implements EventSubjectInterface
{
    /**
     * Attach an observer
     *
     * @param \Liip\Drupal\Modules\EventManager\EventObserverInterface $observer
     *
     * @return void
     * @link http://php.net/manual/en/splsubject.attach.php
     */
    public function attach(EventObserverInterface $observer)
    {
       // intentionally left blank
    }

    /**
     * Detach an observer
     *
     * @param \Liip\Drupal\Modules\EventManager\EventObserverInterface $observer
     *
     * @return void
     * @link http://php.net/manual/en/splsubject.detach.php
     */
    public function detach(EventObserverInterface $observer)
    {
        // intentionally left blank
    }

    /**
     * Notify an observer
     *
     * @link http://php.net/manual/en/splsubject.notify.php
     */
    public function notify()
    {
        // intentionally left blank
    }

    /**
     * Provides the stored information.
     *
     * @return void
     */
    public function getData()
    {
        // intentionally left blank
    }

    /**
     * Stores information to be passed to every observer notified.
     *
     * @param mixed $data
     */
    public function setData($data)
    {
        // intentionally left blank
    }

}
