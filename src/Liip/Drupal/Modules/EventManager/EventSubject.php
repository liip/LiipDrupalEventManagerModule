<?php
namespace Liip\Drupal\Modules\EventManager;

class EventSubject implements EventSubjectInterface
{
    /**
     * @var array
     */
    protected $observers = array();

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var mixed
     */
    protected $data;


    /**
     * @param string $name Identifier of the current subject
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Attach an EventObserver
     *
     * @param \Liip\Drupal\Modules\EventManager\EventObserverInterface $observer
     *
     * @link http://php.net/manual/en/splsubject.attach.php
     */
    public function attach(EventObserverInterface $observer)
    {
        $key = $this->getRegistrationKey($observer);

        if (empty($this->observers[$key])) {
            $this->observers[$key] = $observer;
        }
    }

    /**
     * Detach an EventObserver
     *
     * @param \Liip\Drupal\Modules\EventManager\EventObserverInterface $observer
     *
     * @link http://php.net/manual/en/splsubject.detach.php
     */
    public function detach(EventObserverInterface $observer)
    {
        $key = $this->getRegistrationKey($observer);

        if (array_key_exists($key, $this->observers)){
            unset($this->observers[$key]);
        }
    }

    /**
     * Notify every attached observer
     *
     * @link http://php.net/manual/en/splsubject.notify.php
     */
    public function notify()
    {
        if (0 < count($this->observers)) {
            foreach ($this->observers as $observer) {
                /** @var \Liip\Drupal\Modules\EventManager\EventObserverInterface $observer */
                $observer->update($this);
            }
        }
    }

    /**
     * Provides the ability to pass information to an observer of a subject.
     *
     * The structure of the data passed to the observer has to be defined
     * between subject and observer.
     *
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Returns a former set data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Generates a unique identifier of the given observer.
     *
     * @param EventObserverInterface $observer
     * @return string
     */
    protected function getRegistrationKey(EventObserverInterface $observer)
    {
        return sha1(serialize($observer));
    }
}
