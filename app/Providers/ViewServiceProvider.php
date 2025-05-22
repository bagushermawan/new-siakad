<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\SidebarMenu;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $roles = $user->getRoleNames()->toArray();

                $allMenus = SidebarMenu::where(function ($query) use ($roles) {
                    $query->whereNull('roles')
                        ->orWhere(function ($q) use ($roles) {
                            foreach ($roles as $role) {
                                $q->orWhere('roles', 'like', '%' . $role . '%');
                            }
                        });
                })->orderBy('order')->get();

                $mainMenus = $allMenus->where('is_submenu', false)
                    ->whereNotNull('group')
                    ->map(function ($menu) use ($allMenus) {
                        $menu->children = $allMenus->where('parent_id', $menu->id);
                        return $menu;
                    });

                $groupedMenus = $mainMenus->groupBy('group');

                $view->with('sidebarMenus', $groupedMenus);
            }
        });
    }
}
