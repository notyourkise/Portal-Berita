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
}
