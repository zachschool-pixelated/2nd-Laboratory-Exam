<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
</head>
<body>

    <div class="container">
        <h1>Products</h1>
        <div style="margin-bottom: 20px; display: flex; gap: 10px;">
            <a href="/categories" class="btn-edit">Manage Categories</a>
        </div>

        @if (session('error'))
            <div style="margin-bottom: 16px; color: #c0392b;">
                {{ session('error') }}
            </div>
        @endif

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
                You need at least one category before adding products.
            </div>
        @else
            <form action="/products123" method="POST" class="product-form">
                @csrf

                <div class="form-group">
                    <label for="name123">Name:</label>
                    <input type="text" id="name123" name="name123" value="{{ old('name123') }}">
                </div>

                <div class="form-group">
                    <label for="price123">Price:</label>
                    <input type="text" id="price123" name="price123" value="{{ old('price123') }}">
                </div>

                <div class="form-group">
                    <label for="category_id123">Category:</label>
                    <select id="category_id123" name="category_id123">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id123') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-submit">Save</button>
            </form>
        @endif

        <hr>

        <table class="product-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->category?->name ?? 'N/A' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="/products/{{ $item->id }}/edit" class="btn-edit">Edit</a>

                                <form action="/products/{{ $item->id }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>