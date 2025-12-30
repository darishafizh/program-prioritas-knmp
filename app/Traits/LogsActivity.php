<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    /**
     * Log a create action.
     */
    protected function logCreate(string $modelType, int $modelId, string $description, ?array $newValues = null): void
    {
        ActivityLog::log('create', $description, $modelType, $modelId, null, $newValues);
    }

    /**
     * Log an update action.
     */
    protected function logUpdate(string $modelType, int $modelId, string $description, ?array $oldValues = null, ?array $newValues = null): void
    {
        ActivityLog::log('update', $description, $modelType, $modelId, $oldValues, $newValues);
    }

    /**
     * Log a delete action.
     */
    protected function logDelete(string $modelType, int $modelId, string $description, ?array $oldValues = null): void
    {
        ActivityLog::log('delete', $description, $modelType, $modelId, $oldValues, null);
    }

    /**
     * Log a custom action.
     */
    protected function logActivity(string $action, string $description, ?string $modelType = null, ?int $modelId = null): void
    {
        ActivityLog::log($action, $description, $modelType, $modelId);
    }
}
