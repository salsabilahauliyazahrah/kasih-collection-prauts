<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk — Kasih Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/admin.js') }}" defer></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark px-4">
    <a class="navbar-brand" href="{{ route('admin.index') }}"><em>Kasih</em> Collection</a>
    <div class="ms-auto d-flex align-items-center gap-2">
        <span class="text-white-50">{{ auth()->user()->name }}</span>
    </div>
</nav>

<div class="container" style="margin-top: calc(68px + 28px) !important; max-width: 720px;">

    <!-- Breadcrumb -->
    <div style="margin-bottom:24px;">
        <a href="{{ route('admin.index') }}" style="color:var(--muted);font-size:0.8rem;letter-spacing:1px;text-decoration:none;">
            ← Kembali ke Daftar Produk
        </a>
    </div>

    <h2>Tambah Produk</h2>

    <div class="form-container">
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Preview Gambar -->
            <div class="mb-4">
                <label>Gambar Produk</label>
                <div id="imagePreviewBox" style="
                    width:100%; height:200px; background:var(--cream-dk);
                    border-radius:8px; border:2px dashed var(--rose-lt);
                    display:flex; align-items:center; justify-content:center;
                    margin-bottom:10px; overflow:hidden; cursor:pointer;
                    transition:border-color 0.2s;
                " onclick="document.getElementById('imageInput').click()">
                    <div id="previewPlaceholder" style="text-align:center;color:var(--muted);">
                        <div style="font-size:2rem;margin-bottom:6px;">📷</div>
                        <div style="font-size:0.78rem;letter-spacing:1px;">Klik untuk upload gambar</div>
                    </div>
                    <img id="previewImg" src="" style="display:none;width:100%;height:100%;object-fit:cover;">
                </div>
                <input type="file" id="imageInput" name="image" class="form-control" accept="image/*" required
                       onchange="previewImage(this)" style="display:none;">
                <div style="font-size:0.75rem;color:var(--muted);margin-top:4px;">Format: JPG, PNG, WebP (maks 2MB)</div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label for="name">Nama Produk</label>
                    <input type="text" id="name" name="name" class="form-control"
                           placeholder="Contoh: Dress Batik Pandan" required>
                </div>
                <div class="col-md-4">
                    <label for="stock">Stok</label>
                    <input type="number" id="stock" name="stock" class="form-control"
                           placeholder="0" min="0" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="price">Harga</label>
                <div class="position-relative">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:0.88rem;">Rp</span>
                    <input type="number" id="price" name="price" class="form-control"
                           placeholder="150000" style="padding-left:36px;" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-control"
                          placeholder="Ceritakan produk ini secara singkat..." required></textarea>
            </div>

            <!-- Kategori -->
            <div class="mb-4">
                <label class="form-label">Kategori</label>
                <div class="row g-2">
                    @foreach($categories as $category)
                    <div class="col-6 col-md-4">
                        <label class="d-flex align-items-center gap-2" style="
                            background:var(--cream);border:1px solid var(--cream-dk);
                            border-radius:6px;padding:10px 14px;cursor:pointer;
                            transition:all 0.2s;text-transform:none;letter-spacing:0;
                            font-size:0.85rem;color:var(--charcoal);font-weight:400;
                        " onmouseover="this.style.borderColor='var(--rose-lt)'"
                           onmouseout="this.style.borderColor='var(--cream-dk)'">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                   class="form-check-input m-0" id="cat{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success flex-grow-1">Simpan Produk</button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewImg').style.display = 'block';
            document.getElementById('previewPlaceholder').style.display = 'none';
            document.getElementById('imagePreviewBox').style.borderColor = 'var(--rose)';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
