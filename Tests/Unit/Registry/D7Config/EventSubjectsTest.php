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
        $dcc = $this->getDrupalCommonConnectorFixture();
        $assertions = $this->getAssertionObjectMock(array('string', 'notEmpty'));

        $typ = new EventSubjects($dcc, $assertions);

        $this->assertFalse($typ->isRegistered('Tux'));
    }
}
