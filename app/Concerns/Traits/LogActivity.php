<?php

namespace App\Concerns\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

trait LogActivity
{
    /**
     * Main activity logger.
     */
    protected function logActivity(string $type, string $action, ?string $message = null, array $context = [], ?Throwable $exception = null): void
    {
        $user = Auth::user();

        $logMessage = strtoupper($type) . " [ACTION: {$action}]";

        $logMessage .= $user
            ? " by {$user->name} (ID: {$user->id})"
            : " by guest";

        if ($message) {
            $logMessage .= " - {$message}";
        }

        $defaultContext = [
            'type' => $type,
            'action' => $action,
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'ip' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
            'url' => request()?->fullUrl(),
        ];

        if ($exception) {
            $defaultContext['exception'] = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
        }

        $context = array_merge($defaultContext, $context);

        $logLevel = match ($type) {
            'success' => 'info',
            'warning' => 'warning',
            'error' => 'error',
            default => 'info',
        };

        Log::channel('daily')->{$logLevel}($logMessage, $context);
    }

    /**
     * Success log.
     */
    protected function logSuccess(string $action, ?string $message = null, array $context = []): void
    {
        $this->logActivity('success', $action, $message, $context);
    }

    /**
     * Info log.
     */
    protected function logInfo(string $action, ?string $message = null, array $context = []): void
    {
        $this->logActivity('info', $action, $message, $context);
    }

    /**
     * Warning log.
     */
    protected function logWarning(string $action, ?string $message = null, array $context = []): void
    {
        $this->logActivity('warning', $action, $message, $context);
    }

    /**
     * Error log.
     */
    protected function logError(string $action, ?string $message = null, array $context = [], ?Throwable $exception = null): void
    {
        $this->logActivity('error', $action, $message, $context, $exception);
    }
}
