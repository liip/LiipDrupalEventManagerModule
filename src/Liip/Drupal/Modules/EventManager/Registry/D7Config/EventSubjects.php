<?php

namespace Liip\Drupal\Modules\EventManager\Registry\D7Config;

use Assert\Assertion;
use Liip\Drupal\Modules\Registry\Drupal\D7Config;

class EventSubjects extends D7Config
{
    /**
     * @param \Assert\Assertion $assertion
     *
     */
    public function __construct(Assertion $assertion)
    {
        parent::__construct('registry_eventSubject', $assertion);
    }
}
