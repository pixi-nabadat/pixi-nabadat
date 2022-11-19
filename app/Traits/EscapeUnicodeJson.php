<?php

namespace App\Traits;

trait EscapeUnicodeJson
{

    // must used in model
    /**
     * Encode the given value as JSON.
     *
     * @param mixed $value
     * @return string
     */
    protected function asJson($value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

}
