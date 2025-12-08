<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        // Halaman statis khusus untuk visi-misi
        if ($slug === 'visi-misi') {
            return view('frontend.page.visi-misi');
        }
        
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        return view('frontend.page.show', compact('page'));
    }
    
    public function showSubmenu($pageSlug, $submenuSlug)
    {
        // Cari parent page
        $parentPage = Page::where('slug', $pageSlug)
            ->where('is_active', true)
            ->where('menu_type', 'dropdown')
            ->firstOrFail();
        
        // Cari submenu item dalam dropdown_items
        $submenuItem = collect($parentPage->dropdown_items)->firstWhere('slug', $submenuSlug);
        
        if (!$submenuItem) {
            abort(404, 'Submenu tidak ditemukan');
        }
        
        return view('frontend.page.submenu', [
            'parentPage' => $parentPage,
            'submenuItem' => $submenuItem,
            'title' => $submenuItem['label'],
            'content' => $submenuItem['content'] ?? '',
            'icon' => $submenuItem['icon'] ?? null,
        ]);
    }
}
