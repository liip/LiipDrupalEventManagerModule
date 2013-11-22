<?php
namespace Liip\Drupal\Modules\EventManager;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Liip\Drupal\Modules\DrupalConnector\ConnectorFactory;
use Liip\Drupal\Modules\Registry\RegistryException;
use Liip\Drupal\Modules\Registry\RegistryInterface;

class SubjectFactory
{
    /**
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
     * @var \Liip\Drupal\Modules\DrupalConnector\ConnectorFactory;
     */
    protected $connectorFactory;


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
            $this->getDrupalConnectorFactory()
                ->getCommonConnector()
                ->watchdog(
                'Liip Drupal Event Manager',
                $re->getMessage(),
                array(),
                WATCHDOG_ERROR
            );
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

            if (!empty($this->subjects[$name])) {
                $this->assertions->isInstanceOf(
                    $this->subjects[$name],
                    '\\Liip\\Drupal\\Modules\\EventManager\\EventSubjectInterface',
                    'Someone sneaked wrong value in there.. neat!! Will be reset now ;)'
                );
            }

        } catch (InvalidArgumentException $e) {
            $this->getDrupalConnectorFactory()
                ->getCommonConnector()
                ->watchdog(
                    'Liip Drupal Event Manager',
                    $e->getMessage(),
                    array(),
                    WATCHDOG_ERROR
                );

            $this->subjects[$name] = null;
        }
    }

    /**
     * Provides an instance to the connector factory.
     *
     * @return ConnectorFactory
     */
    protected function getDrupalConnectorFactory()
    {
        if (empty($this->connectorFactory)) {
            $this->connectorFactory = new ConnectorFactory();
        }

        return $this->connectorFactory;
    }
}
