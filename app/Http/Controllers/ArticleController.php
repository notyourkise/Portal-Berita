<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function show(Request $request, $slug)
    {
        $article = Article::published()
            ->with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views (only on first page)
        if (!$request->has('page') || $request->page == 1) {
            $article->incrementViews();
        }

        // Pagination setup
        $charsPerPage = 5000; // 5000 karakter per halaman
        $currentPage = (int) $request->get('page', 1);
        
        // Strip HTML untuk hitung karakter, tapi simpan HTML asli
        $bodyText = strip_tags($article->body);
        $totalChars = mb_strlen($bodyText);
        $totalPages = (int) ceil($totalChars / $charsPerPage);
        
        // Pastikan current page valid
        if ($currentPage < 1) $currentPage = 1;
        if ($currentPage > $totalPages) $currentPage = $totalPages;
        
        // Split content by paragraphs untuk pembagian yang lebih natural
        $bodyContent = $article->body;
        $pages = $this->splitContentIntoPages($bodyContent, $charsPerPage);
        $currentContent = $pages[$currentPage - 1] ?? $bodyContent;

        // Related articles (same category, exclude current)
        $relatedArticles = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.article.show', compact(
            'article', 
            'relatedArticles',
            'currentContent',
            'currentPage',
            'totalPages'
        ));
    }

    /**
     * Split content into pages while preserving HTML and paragraph structure
     */
    private function splitContentIntoPages($html, $charsPerPage)
    {
        // Strip tags untuk hitung karakter yang sebenarnya
        $plainText = strip_tags($html);
        $totalChars = mb_strlen($plainText);
        
        // Jika konten pendek, return as single page
        if ($totalChars <= $charsPerPage) {
            return [$html];
        }

        // Hitung jumlah halaman yang dibutuhkan
        $totalPages = (int) ceil($totalChars / $charsPerPage);
        $pages = [];
        
        // Split berdasarkan paragraf
        // Deteksi paragraf dengan berbagai format: <p>, <br>, <h1-6>, <div>
        $paragraphs = preg_split('/(<p[^>]*>.*?<\/p>|<h[1-6][^>]*>.*?<\/h[1-6]>|<div[^>]*>.*?<\/div>)/is', $html, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        
        $currentPageContent = '';
        $currentPageLength = 0;
        
        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);
            if (empty($paragraph)) continue;
            
            // Hitung panjang text tanpa HTML
            $paragraphTextLength = mb_strlen(strip_tags($paragraph));
            
            // Jika menambah paragraph akan melebihi batas DAN sudah ada content di current page
            if ($currentPageLength > 0 && ($currentPageLength + $paragraphTextLength) > $charsPerPage) {
                // Simpan halaman saat ini
                $pages[] = $currentPageContent;
                // Reset untuk halaman baru
                $currentPageContent = $paragraph;
                $currentPageLength = $paragraphTextLength;
            } else {
                // Tambahkan ke halaman saat ini
                $currentPageContent .= $paragraph;
                $currentPageLength += $paragraphTextLength;
            }
        }
        
        // Tambahkan halaman terakhir jika ada content
        if (!empty(trim($currentPageContent))) {
            $pages[] = $currentPageContent;
        }
        
        // Fallback: jika masih kosong, return original content
        return empty($pages) ? [$html] : $pages;
    }
}

