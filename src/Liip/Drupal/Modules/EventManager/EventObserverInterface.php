<?php
namespace Liip\Drupal\Modules\EventManager;

interface EventObserverInterface
{
    /**
     * @param EventSubjectInterface $subject
     * @return mixed
     */
    public function update(EventSubjectInterface $subject);
}
