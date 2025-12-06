<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_active',
        'order',
        'show_in_navbar',
        'navbar_order',
        'navbar_icon',
        'navbar_parent',
        'menu_type',
        'dropdown_items',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_navbar' => 'boolean',
        'dropdown_items' => 'array',
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
        
        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Scope: Get active pages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get pages that should show in navbar
     */
    public function scopeInNavbar($query)
    {
        return $query->where('show_in_navbar', true)
                     ->where('is_active', true)
                     ->orderBy('navbar_order');
    }

    /**
     * Scope: Get parent navbar items (no parent)
     */
    public function scopeNavbarParents($query)
    {
        return $query->inNavbar()->whereNull('navbar_parent');
    }

    /**
     * Scope: Get children of a navbar parent
     */
    public function scopeNavbarChildren($query, $parent)
    {
        return $query->inNavbar()->where('navbar_parent', $parent);
    }

    /**
     * Get navbar children for this page
     */
    public function getNavbarChildrenAttribute()
    {
        return static::navbarChildren($this->slug)->get();
    }
}
