<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasih Collection</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

<!-- untuk bagian navbar -->
<nav class="kc-navbar" id="mainNav">
    <div class="container-fluid px-4 d-flex justify-content-between align-items-center h-100">
        <div class="nav-logo">
            <span class="logo-script">Kasih</span>
            <span class="logo-sans">COLLECTION</span>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('cart') }}" class="nav-icon-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
                <span>Keranjang</span>
            </a>

            <button id="btn-theme" class="nav-icon-btn theme-btn" title="Toggle Dark Mode">
                <span class="theme-icon">☽</span>
            </button>

            @auth
                <div class="user-pill">
                    <span>{{ auth()->user()->name }}</span>
                </div>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.index') }}" class="kc-btn-outline">
                        Dashboard
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="kc-btn-outline">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="kc-btn-outline">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- bagian hero section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <p class="hero-eyebrow">Koleksi Terbaru 2026</p>
        <h1 class="hero-title">Kasih<em>Collection</em></h1>
        <p class="hero-sub">Temukan keanggunan dalam setiap helai kain</p>
        <a href="#products" class="hero-cta">Jelajahi Koleksi</a>
    </div>
    <div class="hero-scroll-hint">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>
</section>

<!-- stats -->
<section class="stats-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 col-md-3 text-center stat-item">
                <div class="stat-number">{{ $products->count() }}</div>
                <div class="stat-label">Produk</div>
            </div>
            <div class="col-6 col-md-3 text-center stat-item">
                <div class="stat-number">{{ \App\Models\Category::count() }}</div>
                <div class="stat-label">Kategori</div>
            </div>
            <div class="col-6 col-md-3 text-center stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Original</div>
            </div>
            <div class="col-6 col-md-3 text-center stat-item">
                <div class="stat-number">★ 4.9</div>
                <div class="stat-label">Rating</div>
            </div>
        </div>
    </div>
</section>

<!-- tampilkan produk -->
<section class="products-section" id="products">
    <div class="container">
        <div class="section-header">
            <p class="section-eyebrow">Pilihan Kami</p>
            <h2 class="section-title">Daftar Produk</h2>
            <div class="section-divider"></div>
        </div>

        <div class="row g-4">
            @forelse ($products as $product)
            <div class="col-sm-6 col-lg-4 product-col">
                <div class="product-card">
                    <div class="product-img-wrap">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                        @else
                            <img src="https://via.placeholder.com/400x500" alt="{{ $product->name }}" class="product-img">
                        @endif
                        <div class="product-overlay">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button class="overlay-btn">+ Keranjang</button>
                            </form>
                        </div>
                        <div class="product-categories">
                            @foreach ($product->categories as $category)
                                <span class="cat-tag">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">{{ $product->name }}</h5>
                        <p class="product-price">Rp {{ number_format($product->price) }}</p>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12 text-center empty-state">
                    <p>Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- tampilan footer -->
<footer class="kc-footer">
    <div class="container">
        <div class="footer-brand">
            <span class="logo-script">Kasih</span>
            <span class="logo-sans">COLLECTION</span>
        </div>
        <p class="footer-tagline">Keanggunan yang abadi, style yang selalu relevan.</p>
        <p class="footer-copy">© 2026 Kasih Collection. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
