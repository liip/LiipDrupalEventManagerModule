<?php

namespace Liip\Drupal\Modules\EventManager\Registry\D7Config;

use Assert\Assertion;
use Liip\Drupal\Modules\DrupalConnector\Common;
use Liip\Drupal\Modules\Registry\Drupal\D7Config;

class EventSubjects extends D7Config
{
    /**
     * @param \Liip\Drupal\Modules\DrupalConnector\Common $dcc
     * @param \Assert\Assertion $assertion
     */
    public function __construct(Common $dcc, Assertion $assertion)
    {
        parent::__construct('registry_eventSubject', $dcc, $assertion);
    }
}
