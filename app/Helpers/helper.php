<?php

use Illuminate\Support\Facades\Session;

/**
 * Set a flash message in the session.
 *
 * @param  string  $key   The key to identify the flash message.
 * @param  string  $value The message content to be stored in the session.
 * @return void
 */
function setFlashMessage($key, $value)
{
    if (is_string($key) && is_string($value)) {
        Session::flash($key, $value);
    }
}
