<?php

namespace Liip\Drupal\Modules\EventManager;

class EventManagerException extends \Exception
{
    const TRIGGER_FAILED_CODE = 10;
    const TRIGGER_FAILED_TEXT = "Failed to trigger event!";

    const TRIGGER_UNSUPPORTED_HTTP_METHOD_CODE = 11;
    const TRIGGER_UNSUPPORTED_HTTP_METHOD_TEXT = "The used Http method is not supported.";
}
