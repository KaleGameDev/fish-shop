<div class="mb-3">
    <label class="form-label fw-semibold">Tên sản phẩm</label>
    <input type="text" name="name" class="form-control rounded-4" value="{{ old('name', $product->name ?? '') }}">
    @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Giá</label>
        <input type="number" name="price" class="form-control rounded-4" value="{{ old('price', $product->price ?? 0) }}">
        @error('price')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Tồn kho</label>
        <input type="number" name="stock" class="form-control rounded-4" value="{{ old('stock', $product->stock ?? 0) }}">
        @error('stock')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Link ảnh</label>
    <input type="text" name="image" class="form-control rounded-4" value="{{ old('image', $product->image ?? '') }}">
    @error('image')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Mô tả</label>
    <textarea name="description" rows="5" class="form-control rounded-4">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>