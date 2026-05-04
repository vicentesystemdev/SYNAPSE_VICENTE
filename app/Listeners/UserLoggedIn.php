<?php

namespace App\Listeners;

use App\Services\AuditService;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class UserLoggedIn
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
    public function handle(Login $event): void
    {
        $this->auditService->logLogin($event->user, $this->request);
    }
}
