<?php
namespace Liip\Drupal\Modules\EventManager;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Liip\Drupal\Modules\Registry\RegistryException;
use Liip\Drupal\Modules\Registry\RegistryInterface;

class SubjectFactory
{   /**
     * @var EventSubject[]
     */
    protected $subjects;

    /**
     * @var \Liip\Drupal\Modules\Registry\RegistryInterface
     */
    protected $registry;

    /**
     * @var \Assert\Assertion
     */
    protected $assertions;


    /**
     * @param \Liip\Drupal\Modules\Registry\RegistryInterface $registry
     * @param \Assert\Assertion $assertion
     */
    public function __construct(RegistryInterface $registry, Assertion $assertion)
    {
        $this->registry = $registry;
        $this->assertions = $assertion;
    }

    /**
     * Provides an event subject identified by the given name.
     *
     * @param string $name
     *
     * @return \Liip\Drupal\Modules\EventManager\EventSubject
     *
     */
    public function getSubject($name)
    {
        if (empty($this->subjects[$name])) {

            $this->initSubject($name);
        }

        return $this->subjects[$name];
    }

    /**
     * Initiates and caches an event subject for later use.
     *
     * @param string $name
     */
    public function initSubject($name)
    {
        $this->fetchSubjectsFromRegistry($name);

        try {

            if (empty($this->subjects[$name])) {
                $this->subjects[$name] = new EventSubject($name);

                if ($this->registry->isRegistered($name)) {

                    // modify registration
                    $this->registry->replace($name, $this->subjects[$name]);

                } else {

                    $this->registry->register($name, $this->subjects[$name]);
                }
            }

        } catch (RegistryException $re) {
//      TODO: watchdog
        }
    }

    /**
     * Retrieves the set of subjects from the registry currently attached.
     *
     * @param string $name
     */
    protected function fetchSubjectsFromRegistry($name)
    {
        try {
            $this->subjects = $this->registry->getContent();
            $this->assertions->isInstanceOf(
                $this->subjects[$name],
                '\\Liip\\Drupal\\Modules\\EventManager\\EventSubjectInterface',
                'Someone sneaked wrong value in there.. neat!! Will be reset now ;)'
            );

        } catch (InvalidArgumentException $e) {
//      TODO: add watchdog

            $this->subjects[$name] = null;
        }
    }
}
