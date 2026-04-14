<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
</head>
<body>

    <div class="container">
        <h1>Edit Product</h1>

        <div style="margin-bottom: 20px; display: flex; gap: 10px;">
            <a href="/categories" class="btn-edit">Manage Categories</a>
        </div>

        @if ($errors->any())
            <div style="margin-bottom: 16px; color: #c0392b;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($categories->isEmpty())
            <div style="margin-bottom: 16px; color: #c0392b;">
                You need at least one category before updating products.
            </div>
        @else
            <form action="/products/{{ $product->id }}" method="POST" class="product-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name123">Name:</label>
                    <input type="text" id="name123" name="name123" value="{{ old('name123', $product->name) }}">
                </div>

                <div class="form-group">
                    <label for="price123">Price:</label>
                    <input type="text" id="price123" name="price123" value="{{ old('price123', $product->price) }}">
                </div>

                <div class="form-group">
                    <label for="category_id123">Category:</label>
                    <select id="category_id123" name="category_id123">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id123', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-submit">Update Product</button>
            </form>
        @endif

        <div style="margin-top: 20px;">
            <a href="/products" class="btn-edit">Back to Product List</a>
        </div>
    </div>

</body>
</html>
