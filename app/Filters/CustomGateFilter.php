<?php

namespace App\Filters;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class CustomGateFilter implements FilterInterface
{
    protected $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    public function transform($item, Builder $builder)
    {
        if (! $this->isVisible($item)) {
            return false;
        }

        return $item;
    }

    protected function isVisible($item)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Allow access to 'admin/home' for students
            // if ($item['url'] === 'admin/home' && $user->type === 'student') {
            //     return true; // Allow access for students
            // }
            // if ($user->type === 'student' && in_array($item['url'], [
            //     'admin/home',
            //     'student/change-password',
            //     'student/add-info',
            // ])) {
            //     return true; // Allow access for students
            // }

            if ($user->type === 'admin' && in_array($item['url'], [
                'admin/student/update-password',
                'admin/student/submit-feedback',
                'admin/student/show/info',
            ])) {
                return false;
            }

            // Admins can see everything else
            if ($user->type === 'admin') {
                return true;
            }

            // Allow only specific routes for students
            if ($user->type === 'student' && in_array($item['url'], [
                'admin/home',
                'admin/student/update-password',
                'admin/student/submit-feedback',
                'admin/student/show/info',
            ])) {
                return true;
            }

        }

        // Existing permission checks
        if (! isset($item['can'])) {
            return true;
        }

        if (isset($item['model'])) {
            return $this->gate->allows($item['can'], $item['model']);
        }

        if (is_array($item['can'])) {
            foreach ($item['can'] as $permission) {
                if ($this->gate->allows($permission)) {
                    return true;
                }
            }
        } else {
            return $this->gate->allows($item['can']);
        }

        return false; // Deny access if none of the conditions are met
    }
}