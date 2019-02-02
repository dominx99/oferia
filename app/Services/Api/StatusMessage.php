<?php

namespace App\Services\Api;

class StatusMessage
{
    const OK    = 'success';
    const ERROR = 'fail';

    const VALIDATION_ERROR    = 'validation has failed';
    const INVALID_CREDENTIALS = 'Invalid email or password';
}
