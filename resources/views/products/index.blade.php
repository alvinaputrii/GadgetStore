@extends('layouts.app')

@section('content')
    <h3>Data Produk</h3>
    @if (auth()->user()?->role === 'admin')
        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
    @endif

    <form method="GET" class="row g-2 my-3">
        <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode, nama, merek">
        <select name="category_id" class="form-select">
            <option value="">Semua kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button class="btn btn-outline-primary">Cari / Filter</button>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Merek</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    @if (auth()->user()?->role === 'admin')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <div class="bg-light text-secondary rounded d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px; font-size: 11px;">
                                    No Img
                                </div>
                            @endif
                        </td>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->brand }}</td>
                        <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        @if (auth()->user()?->role === 'admin')
                            <td>
                                <a href="{{ route('products.edit', $product) }}">Edit</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()?->role === 'admin' ? 8 : 7 }}">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $products->links() }}
@endsection