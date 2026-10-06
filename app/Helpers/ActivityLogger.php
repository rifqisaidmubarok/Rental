<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log(
        string $activity,
        ?string $description = null
    ): void {
        ActivityLog::create([
            'user_id' => auth()->id(),

            'activity' => $activity,

            'description' => $description,

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),
        ]);
    }
}