<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ isset($category) ? $category->name . ' - ' : '' }}Portal Berita</title>
        <link>{{ route('home') }}</link>
        <description>{{ isset($category) ? 'Berita terbaru seputar ' . $category->name : 'Berita terkini dan terupdate dari Portal Berita Indonesia' }}</description>
        <language>id-ID</language>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        <atom:link href="{{ request()->url() }}" rel="self" type="application/rss+xml" />

        @foreach($articles as $article)
        <item>
            <title>{{ $article->title }}</title>
            <link>{{ route('article.show', $article->slug) }}</link>
            <description><![CDATA[{{ $article->excerpt }}]]></description>
            <author>{{ $article->author->email }} ({{ $article->author->name }})</author>
            <category>{{ $article->category->name }}</category>
            <pubDate>{{ $article->published_at->toRssString() }}</pubDate>
            <guid isPermaLink="true">{{ route('article.show', $article->slug) }}</guid>
            @if($article->cover_image)
            <enclosure url="{{ $article->cover_image_url }}" type="image/jpeg" />
            @endif
        </item>
        @endforeach
    </channel>
</rss>
