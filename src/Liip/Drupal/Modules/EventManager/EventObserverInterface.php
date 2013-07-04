<?php
namespace Liip\Drupal\Modules\EventManager;

interface EventObserverInterface
{
    /**
     * Callback to be invoked if the event the observer is attached to was triggered.
     *
     * @param EventSubjectInterface $subject
     * @return mixed
     */
    public function update(EventSubjectInterface $subject);
}
