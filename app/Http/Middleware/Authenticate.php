<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate as MiddlewareAuthenticate;
use Filament\Facades\Filament;

class Authenticate extends MiddlewareAuthenticate
{
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);

            return; /** @phpstan-ignore-line */
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        /** @var Model $user */
        $user = $guard->user();

        $panel = Filament::getCurrentPanel();
    }

}
