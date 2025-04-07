<?php

if (!function_exists('formatDateTime')) {
    /**
     * Format a datetime string into a specific format.
     *
     * @param string $datetime
     * @return string
     */
    function formatDateTime($datetime)
    {
        return \Carbon\Carbon::parse($datetime)->format('d-m-Y h:i A');
    }
}
