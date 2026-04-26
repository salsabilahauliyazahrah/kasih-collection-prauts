<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk — Kasih Collection</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/admin.js') }}" defer></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark px-4">
    <a class="navbar-brand" href="{{ route('admin.index') }}"><em>Kasih</em> Collection</a>
    <div class="ms-auto">
        <span class="text-white-50">{{ auth()->user()->name }}</span>
    </div>
</nav>

<div class="container edit-container">

    <div style="margin-bottom:24px;">
        <a href="{{ route('admin.index') }}" style="color:var(--muted);font-size:0.8rem;letter-spacing:1px;text-decoration:none;">
            ← Kembali ke Daftar Produk
        </a>
    </div>    

    <h2>Edit Produk</h2>

    <div class="form-container">
        <form action="{{ route('admin.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- bagian gambar -->
            <div class="mb-4">
                <label>Gambar Produk</label>

                <div id="imagePreviewBox" class="image-box"
                     onclick="document.getElementById('imageInput').click()">

                    @if($product->image)
                        <img id="previewImg"
                             src="{{ asset('storage/' . $product->image) }}"
                             class="preview-img">
                    @else
                        <div id="previewPlaceholder" class="preview-placeholder">
                            <div class="icon">📷</div>
                            <div>Klik untuk upload</div>
                        </div>
                        <img id="previewImg" src="" class="preview-img d-none">
                    @endif

                    <div class="change-label">Ganti Foto</div>
                </div>

                <input type="file" id="imageInput" name="image"
                       class="form-control d-none"
                       accept="image/*"
                       onchange="previewImage(this)">
            </div>

            <!-- bagian untuk Nama & Stok -->
            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label>Nama Produk</label>
                    <input type="text" name="name"
                           value="{{ $product->name }}"
                           class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Stok</label>
                    <input type="number" name="stock"
                           value="{{ $product->stock }}"
                           class="form-control" min="0" required>
                </div>
            </div>

            <!-- bagian Harga -->
            <div class="mb-3">
                <label>Harga</label>
                <div class="price-wrapper">
                    <span>Rp</span>
                    <input type="number" name="price"
                           value="{{ $product->price }}"
                           class="form-control price-input"
                           required>
                </div>
            </div>

            <!-- bagian deskripsi -->
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
            </div>

            <!-- bagian kategori -->
            <div class="mb-4">
                <label class="form-label">Kategori</label>

                <div class="row g-2">
                    @foreach($categories as $category)
                    <div class="col-6 col-md-4">

                        <label class="category-item d-flex align-items-center gap-2
                            {{ $product->categories->contains($category->id) ? 'active' : '' }}">

                            <input type="checkbox"
                                   name="categories[]"
                                   value="{{ $category->id }}"
                                   class="form-check-input m-0"
                                   {{ $product->categories->contains($category->id) ? 'checked' : '' }}>

                            {{ $category->name }}
                        </label>

                    </div>
                    @endforeach
                </div>
            </div>

            <!-- bagian button -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success flex-grow-1">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                    Batal
                </a>
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
            const img = document.getElementById('previewImg');
            img.src = e.target.result;
            img.classList.remove('d-none');

            const placeholder = document.getElementById('previewPlaceholder');
            if (placeholder) placeholder.style.display = 'none';

            document.getElementById('imagePreviewBox')
                .style.borderColor = 'var(--rose)';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</body>
</html>

