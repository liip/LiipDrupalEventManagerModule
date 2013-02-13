<?php
namespace Liip\Drupal\Modules\EventManager;

interface EventSubjectInterface
{
    /**
     * Attach an observer
     *
     * @param \Liip\Drupal\Modules\EventManager\EventObserverInterface $observer
     *
     * @return
     * @link http://php.net/manual/en/splsubject.attach.php
     */
    public function attach(EventObserverInterface $observer);

    /**
     * Detach an observer
     *
     * @param \Liip\Drupal\Modules\EventManager\EventObserverInterface $observer
     *
     * @return void
     * @link http://php.net/manual/en/splsubject.detach.php
     */
    public function detach(EventObserverInterface $observer);

    /**
     * Notify an observer
     *
     * @link http://php.net/manual/en/splsubject.notify.php
     */
    public function notify();

    /**
     * Provides the stored information.
     * @return void
     */
    public function getData();

    /**
     * Stores information to be passed to every observer notified.
     *
     * @param mixed $data
     */
    public function setData($data);

}
