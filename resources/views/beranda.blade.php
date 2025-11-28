@extends('layouts.app')

@section('title', 'Beranda | MI-Al Ihsan')

@section('page-style')
/* Carousel full screen */
.carousel-item {
    height: 100vh;
    overflow: hidden;
    position: relative;
}
.carousel-item img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    transition: transform 10s linear;
}
.carousel-item.active img {
    transform: scale(1.15);
}

/* Overlay gelap transparan */
.carousel-item::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent 40%);
    z-index: 1;
}

/* Indikator carousel menjadi garis */
.carousel-indicators [data-bs-target] {
    width: 50px; height: 5px;
    border-radius: 0;
    margin: 0 10px;
    background-color: rgba(255, 255, 255, 0.5);
}
.carousel-indicators .active {
    background-color: #ffffff;
}

/* Kotak kutipan */
.quote-container {
    position: absolute;
    bottom: 80px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    width: 100%;
    max-width: 800px;
    color: white;
    text-align: center;
    padding: 0 1rem;
}
.quote-text {
    font-size: 1.5rem;
    font-weight: 500;
    font-style: italic;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
    margin-bottom: 0.5rem;
}
.quote-author {
    font-size: 1rem;
    font-weight: 300;
}

/* Sejarah, Visi Misi */
.section-content {
    padding: 3rem 1rem;
}
.row-beranda {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    justify-content: center;
}
.col-left, .col-right {
    flex: 1;
    min-width: 300px;
    max-width: 600px;
}
.misi-list {
    padding-left: 1.5rem;
    line-height: 1.6;
}

/* Responsif */
@media (max-width: 768px) {
    .quote-text { font-size: 1.2rem; }
    .quote-container { bottom: 100px; }
    .section-content p, .section-content li { text-align: justify; margin-bottom: 0.8rem; }
}
@endsection

@section('content')
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    {{-- Indikator Carousel --}}
    <div class="carousel-indicators">
        @foreach($gambarBeranda as $i => $gambar)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}" 
                class="{{ $i==0 ? 'active' : '' }}" aria-current="{{ $i==0 ? 'true' : '' }}" 
                aria-label="Slide {{ $i+1 }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner">
        @foreach($gambarBeranda as $i => $gambar)
        <div class="carousel-item {{ $i==0 ? 'active' : '' }}">
            <img src="{{ asset('beranda/'.$gambar->gambar) }}" class="d-block w-100" alt="Slide {{ $i+1 }}">
        </div>
        @endforeach
    </div>

    {{-- Kotak kutipan --}}
    <div class="quote-container">
        <p class="quote-text animate__animated" id="auto-quote"></p>
        <span class="quote-author animate__animated" id="auto-author"></span>
    </div>
</div>

{{-- Sejarah, Visi & Misi --}}
<div class="section-content container">
    <div class="mb-5" data-aos="fade-up">
        <h2 class="fw-bold text-center">Sejarah MI Al-Ihsan Tebel Gedangan Sidoarjo</h2><br>
        <p style="text-align: justify; line-height: 1.6;">
            MI Al-Ihsan berdiri sejak tahun 1994. Keberadaan MI Al-Ihsan ini didirikan karena kebutuhan masyarakat Tebel 
            untuk memasukkan putra-putri mereka di Sekolah Madrasah yang lebih dekat bagi masyarakat setempat. 
            Mengingat pentingnya Lembaga Sekolah Madrasah bagi putra-putri masyarakat Kelurahan Tebel, atas prakarsa 
            tokoh masyarakat dan aparat pemerintah, didirikanlah Sekolah Madrasah Ibtidaiyah yang disebut MI Al-Ihsan.
        </p>
    </div>

    <div class="row-beranda">
        {{-- Visi --}}
        <div class="col-left" data-aos="fade-up">
            <div class="card shadow-sm p-3 mb-4">
                <h4 class="fw-bold">Visi</h4>
                <p style="text-align: justify;">
                    UNGGUL DALAM BERAKHLAK MULIA, BERMARTABAT, BERPRESTASI, DAN BERWAWASAN LINGKUNGAN ISLAMI. 
                    <br><br>
                    Indikator keberhasilan visi:
                    <ul>
                        <li><strong>Akhlak Mulia:</strong> Peserta didik taat beribadah, santun, disiplin, bertanggung jawab, unggul dalam prestasi akademik dan non-akademik, serta peduli lingkungan.</li>
                        <li><strong>Bermartabat:</strong> Peserta didik jujur, amanah, disiplin, percaya diri, menghormati guru, orang tua, dan sesama.</li>
                        <li><strong>Berprestasi:</strong> Kesadaran dan motivasi berkompetisi di bidang akademik/non-akademik, meningkatnya daya saing lulusan di pendidikan, dunia usaha, dan masyarakat.</li>
                        <li><strong>Berwawasan Lingkungan Islami:</strong> Madrasah bersih, sehat, aman, nyaman, peduli pelestarian alam dan lingkungan sekitar.</li>
                    </ul>
                </p>
            </div>
        </div>

        {{-- Misi --}}
        <div class="col-right" data-aos="fade-up">
            <div class="card shadow-sm p-3 mb-4">
                <h4 class="fw-bold">Misi</h4>
                <ol class="misi-list">
                    <li>1. Menyusun kurikulum madrasah yang berkarakter Islami, aktual, dan sesuai dengan landasan konstitusi.</li>
                    <li>2. Membudayakan penghayatan dan pengamalan ajaran Islam dalam aktivitas sehari-hari di Madrasah.</li>
                    <li>3. Meningkatkan kualitas KBM berbasis IPTEK sebagai upaya peningkatan prestasi Murid.</li>
                    <li>4. Melaksanakan pembelajaran dan pembimbingan secara efektif untuk mengoptimalkan potensi, minat, dan ketrampilan murid yang berkarakter dan berwawasan lingkungan.</li>
                    <li>5. Membudayakan literasi melalui pemanfaatan perpustakaan konvensional dan digital untuk mengoptimalkan kemampuan murid dalam berpikir logis, kritis, sistematis, dan inovatif.</li>
                    <li>6. Membiasakan kegiatan belajar mandiri yang terbimbing kepada murid dengan berbasis UKBM dan E-Learning.</li>
                    <li>7. Mengikutsertakan warga madrasah dalam berbagai kegiatan akademik maupun non-akademik.</li>
                    <li>8. Mewujudkan mutu lulusan madrasah yang berakhlakul karimah, berdaya saing, dan siap berkolaborasi di masyarakat.</li>
                    <li>9. Mengoptimalkan kompetensi Pendidik dan Tenaga Kependidikan yang inovatif, profesional, amanah, dan peduli lingkungan.</li>
                    <li>10.Menyelenggarakan pengelolaan madrasah yang tertib, transparan, dan akuntabel, serta berwawasan lingkungan.</li>
                    <li>11.Melaksanakan evaluasi pembelajaran berbasis CBT sebagai upaya mewujudkan penilaian yang autentik dan dapat dipertanggungjawabkan.</li>
                    <li>12.Melengkapi dan mengoptimalkan Sistem Informasi Madrasah untuk mewujudkan manajemen madrasah yang terpusat.</li>
                    <li>13.Membudayakan hidup bersih dan sehat kepada seluruh warga madrasah dan sekitarnya.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
    // Carousel otomatis
    const myCarousel = document.querySelector('#heroCarousel');
    new bootstrap.Carousel(myCarousel, { interval: 6000, ride: 'carousel', pause: false });

    // Kutipan motivasi acak
    const quotes = @json($motivasi->map(fn($m) => ['text' => $m->teks, 'author' => '']));
    const quoteElement = document.getElementById('auto-quote');
    const authorElement = document.getElementById('auto-author');

    if(quotes.length > 0){
        let currentQuoteIndex = Math.floor(Math.random() * quotes.length);

        function showQuote(index){
            const q = quotes[index];
            quoteElement.textContent = `"${q.text}"`;
            authorElement.textContent = q.author ? `- ${q.author}` : '';
        }

        showQuote(currentQuoteIndex);

        setInterval(() => {
            let nextIndex;
            do { nextIndex = Math.floor(Math.random() * quotes.length); }
            while(nextIndex === currentQuoteIndex && quotes.length > 1);

            currentQuoteIndex = nextIndex;
            showQuote(currentQuoteIndex);
        }, 6000);
    }
</script>

{{-- AOS --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });
</script>

{{-- Animate.css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
