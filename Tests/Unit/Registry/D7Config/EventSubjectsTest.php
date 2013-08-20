<?php
namespace Liip\Drupal\Modules\EventManager\Registry\D7Config;

use Liip\Drupal\Modules\EventManager\EventManagerTestCase;

class EventSubjectsTest extends EventManagerTestCase
{
    /**
     * @covers \Liip\Drupal\Modules\EventManager\Registry\D7Config\EventSubjects::__construct
     */
    public function test__construct()
    {
        $assertions = $this->getAssertionObjectMock();

        $typ = new EventSubjects($assertions);

        $this->assertFalse($typ->isRegistered('Tux'));
    }
}
