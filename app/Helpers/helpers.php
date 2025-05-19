<?php

declare(strict_types=1);

if (! function_exists('trans_key')) {
    /**
     * Extract the message.
     */
    function trans_key(?string $key = null): ?string
    {
        return $key;
    }
}
