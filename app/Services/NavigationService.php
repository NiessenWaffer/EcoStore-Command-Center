<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class NavigationService
{
    /**
     * Determine the active top-level section based on current route.
     */
    public function getActiveSection(): string
    {
        $routeName = Route::currentRouteName();

        if (str_contains($routeName, 'resale') || str_contains($routeName, 'passport')) {
            return 'Circularity';
        }

        if (str_contains($routeName, 'governance') || str_contains($routeName, 'referral') || str_contains($routeName, 'mission')) {
            return 'Community';
        }

        if (str_contains($routeName, 'shop') || str_contains($routeName, 'product')) {
            return 'Shop';
        }

        return '';
    }
}
