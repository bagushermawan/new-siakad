<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SidebarMenu extends Model
{
    protected $fillable = [
        'title',
        'route_name',
        'icon',
        'group',
        'order',
        'is_submenu',
        'parent_id',
        'roles'
    ];

    protected $casts = [
        'is_submenu' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(SidebarMenu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(SidebarMenu::class, 'parent_id');
    }

    public static function getGroupedMenus()
    {
        return self::with(['children' => function ($query) {
            $query->orderBy('order');
        }])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get()
            ->groupBy('group');
    }
}
