<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Kasih Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark px-4">
    <a class="navbar-brand" href="{{ route('admin.index') }}">
        <em>Kasih</em> Collection
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">
        <a href="/" class="btn btn-sm btn-secondary">← Toko</a>
        <span class="text-white-50">{{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">Keluar</button>
        </form>
    </div>
</nav>

<div class="container mt-4" style="margin-top: calc(68px + 24px) !important;">

    <div class="header-admin">
        <h2>Daftar Produk</h2>
        <a href="{{ route('admin.create') }}" class="btn btn-success">+ Tambah Produk</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
                            @else
                                <div style="width:64px;height:64px;background:var(--cream-dk);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:1.4rem;">📷</div>
                            @endif
                            <div>
                                <div style="font-weight:500;font-size:0.92rem;">{{ $product->name }}</div>
                                <div style="font-size:0.78rem;color:var(--muted);margin-top:2px;">
                                    {{ Str::limit($product->description, 55) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight:600;color:var(--rose-dk);">
                            Rp {{ number_format($product->price) }}
                        </span>
                    </td>
                    <td>
                        @foreach($product->categories as $cat)
                            <span class="badge bg-dark">{{ $cat->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $product->stock }}</span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.destroy', $product->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
