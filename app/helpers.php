<?php

use App\Models\AcademicSession;

if (!function_exists('activeSession')) {

    function activeSession()
    {
        return AcademicSession::where(
                    'is_active',
                    true
                )->first();
    }
}
