@extends('frontend.layouts.app')

@section('title', 'Visi dan Misi - SALUT UT Samarinda')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header Halaman --}}
            <div class="mb-4">
                <h1 class="display-5 fw-bold" style="color: #214594;">Visi dan Misi</h1>
                <div class="border-bottom border-warning border-3 mb-4" style="width: 80px;"></div>
            </div>

            {{-- Konten Halaman --}}
            <div class="page-content bg-white p-4 rounded shadow-sm">
                <div class="content-text" style="line-height: 1.8; font-size: 1.05rem;">
                    
                    {{-- Header SALUT --}}
                    <div class="text-center mb-5">
                        <h2 class="fw-bold" style="color: #214594; font-size: 2rem;">SALUT KOTA SAMARINDA</h2>
                        <p class="fst-italic fs-5" style="color: #555;">"Salut Kota Samarinda Pintu Terdekat Menuju Kampus Terbuka."</p>
                    </div>

                    {{-- Visi --}}
                    <div class="mb-5">
                        <h2 class="fw-bold mb-3" style="color: #214594; border-bottom: 3px solid #fcdd01; padding-bottom: 0.5rem;">Visi</h2>
                        <p class="text-justify" style="text-align: justify;">
                            "Menjadi pusat layanan pendidikan tinggi terbuka dan jarak jauh yang unggul, mudah diakses, serta terpercaya di Kota Samarinda, untuk mendukung terwujudnya masyarakat berdaya saing melalui perluasan akses pendidikan sepanjang masa."
                        </p>
                    </div>

                    {{-- Misi --}}
                    <div class="mb-4">
                        <h2 class="fw-bold mb-3" style="color: #214594; border-bottom: 3px solid #fcdd01; padding-bottom: 0.5rem;">Misi</h2>
                        <ol class="misi-list">
                            <li>Menyelenggarakan layanan administrasi dan akademik yang cepat, tepat, transparan, dan berorientasi pada kepuasan mahasiswa melalui pemanfaatan teknologi dan peningkatan kualitas layanan.</li>
                            <li>Memfasilitasi kegiatan akademik, bimbingan belajar, serta kegiatan pengembangan mahasiswa guna mendukung keberhasilan studi dan peningkatan kualitas lulusan Universitas Terbuka.</li>
                            <li>Melakukan sosialisasi, promosi, dan edukasi tentang sistem pendidikan terbuka dan jarak jauh kepada masyarakat Samarinda dan sekitarnya untuk meningkatkan pemahaman dan kepercayaan terhadap Universitas Terbuka.</li>
                            <li>Melaksanakan kegiatan perekrutan calon mahasiswa secara aktif, inklusif, dan berkelanjutan demi memperluas akses pendidikan tinggi dan meningkatkan angka partisipasi mahasiswa UT.</li>
                            <li>Membangun kemitraan strategis dengan instansi pemerintah, lembaga pendidikan, dunia usaha, dan komunitas lokal untuk mendukung pengembangan layanan, kegiatan akademik, dan pemberdayaan masyarakat.</li>
                            <li>Menjamin kenyamanan, aksesibilitas, dan kedekatan layanan bagi seluruh pemangku kepentingan sehingga SALUT menjadi pusat rujukan layanan UT yang mudah dijangkau dan responsif.</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .page-content {
        background: #ffffff;
    }
    
    .content-text {
        color: #333;
    }
    
    .misi-list {
        margin-left: 1.5rem;
        padding-left: 0.5rem;
    }
    
    .misi-list li {
        margin-bottom: 1rem;
        line-height: 1.8;
        text-align: justify;
        padding-left: 0.5rem;
    }
    
    .misi-list li::marker {
        color: #214594;
        font-weight: 700;
        font-size: 1.1em;
    }
</style>
@endpush
@endsection
