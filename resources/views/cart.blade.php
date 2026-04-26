<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang — Kasih Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>

<!-- bagian untuk navbar -->
<nav class="cart-nav">
    <div class="container-fluid px-4 d-flex justify-content-between align-items-center h-100">
        <a href="/" class="nav-logo" style="text-decoration:none;">
            <span class="logo-script">Kasih</span>
            <span class="logo-sans">COLLECTION</span>
        </a>
        <a href="/" class="nav-back-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Lanjut Belanja
        </a>
    </div>
</nav>

<!-- bagian tampilan utama -->
<main class="cart-main">
    <div class="container">

        <!-- page header -->
        <div class="cart-page-header">
            <p class="page-eyebrow">Kasih Collection</p>
            <h1 class="page-title">Keranjang Belanja</h1>
            <div class="page-divider"></div>
        </div>

        @if(empty($cartItems))
        <!-- tampilan jika data kosong -->
        <div class="cart-empty-page">
            <div class="empty-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
            </div>
            <h3 class="empty-title">Keranjang masih kosong</h3>
            <p class="empty-sub">Temukan produk favoritmu dan tambahkan ke keranjang</p>
            <a href="/" class="btn-shop-now">Mulai Belanja</a>
        </div>

        @else

        <div class="row g-5">
            <!-- tampilan produk-produk yang sudah ditambahkan admin -->
            <div class="col-lg-8">
                <div class="cart-items-wrap">

                    <div class="cart-items-header">
                        <span>Produk</span>
                        <span>Harga</span>
                    </div>

                    @php $total = 0; @endphp
                    @foreach ($cartItems as $id)
                        @php
                            $product = \App\Models\Product::find($id);
                            if ($product) $total += $product->price;
                        @endphp
                        @if($product)
                        <div class="cart-row">
                            <!-- bagian nampilin gambar produk -->
                            <div class="cart-row-img">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="cart-row-img-placeholder">📷</div>
                                @endif
                            </div>

                            <!-- bagian info produk -->
                            <div class="cart-row-info">
                                <h5 class="cart-row-name">{{ $product->name }}</h5>
                                <div class="cart-row-cats">
                                    @foreach($product->categories->take(3) as $cat)
                                        <span class="cart-row-tag">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                                @if($product->description)
                                    <p class="cart-row-desc">{{ Str::limit($product->description, 80) }}</p>
                                @endif
                                <!-- bagian untuk tombol hapus (mobile) -->
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST" class="cart-remove-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-remove-link">Hapus</button>
                                </form>
                            </div>

                            <!-- bagian harga dan tombol hapus -->
                            <div class="cart-row-right">
                                <span class="cart-row-price">Rp {{ number_format($product->price) }}</span>
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST" class="d-none d-md-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-row-delete" title="Hapus">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                            <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endforeach

                </div>
            </div>

            <!-- bagiamn ringkasan pemesanan -->
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4 class="summary-title">Ringkasan</h4>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Pengiriman</span>
                        <span class="summary-free">Dihitung saat checkout</span>
                    </div>
                    <div class="summary-total-row">
                        <span>Total</span>
                        <span>Rp {{ number_format($total) }}</span>
                    </div>
                    <button class="summary-checkout-btn">Lanjut ke Checkout</button>
                    @if($total >= 300000)
                        <p class="summary-promo">🎉 Kamu mendapat gratis ongkir!</p>
                    @else
                        <p class="summary-promo-hint">
                            Belanja Rp {{ number_format(300000 - $total) }} lagi untuk gratis ongkir
                        </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>
</main>

<!-- tampilan footer -->
<footer class="cart-footer">
    <p>© 2026 Kasih Collection</p>
</footer>

</body>
</html>
