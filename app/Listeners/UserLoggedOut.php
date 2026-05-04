<?php

namespace App\Listeners;

use App\Services\AuditService;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class UserLoggedOut
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private AuditService $auditService,
        private Request $request
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if ($event->user) {
            $this->auditService->logLogout($event->user, $this->request);
        }
    }
}
