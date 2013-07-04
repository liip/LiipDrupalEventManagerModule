<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lapistano
 * Date: 7/4/13
 * Time: 11:31 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Liip\Drupal\Modules\EventManager\Observers;


use Liip\Drupal\Modules\EventManager\EventObserverInterface;
use Liip\Drupal\Modules\EventManager\EventSubjectInterface;

class Noop implements EventObserverInterface
{
    /**
     * Callback to be invoked if the event the observer is attached to was triggered.
     *
     * @param EventSubjectInterface $subject
     *
     * @return mixed
     */
    public function update(EventSubjectInterface $subject)
    {
        // intentionally left blank.
    }
}
