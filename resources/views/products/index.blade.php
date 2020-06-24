@extends('layouts.admin')

@section('title')
<title>List Product</title>
@endsection

@section('content')
<main class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item active">Product</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                List Product
                <!-- BUAT TOMBOL UNTUK MENGARAHKAN KE HALAMAN ADD PRODUK -->
                <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm float-right">Tambah</a>
              </h4>
            </div>
            <div class="card-body">
              <!-- jika terdapat flash session maka tampilkan -->
              @if (session('success'))
              <div class="aler alert-success">{{ session('success') }}</div>
              @endif

              @if (session('error'))
              <div class="aler alert-success">{{ session('error') }}</div>
              @endif
              <!-- end flash session -->

              <!-- buat form untuk pencarian- methodnya adalah get -->
              <form action="{{ route('product.index') }}" method="get">
                <div class="input-group mb-3 col-md-3 float-right">
                  <!-- kemudian name nya adalah Q yang akan meampung data pencarian -->
                  <input type="text" name="q" id="" class="form-control" placeholder="Cari..." value="{{ request()->q }}">
                  <div class="input-group-append">
                    <button class="btn btn-secondary" type="button">Cari</button>
                  </div>
                </div>
              </form>

              <!-- table untuk menampilkan produk -->
              <div class="table-responsive">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Product</th>
                      <th>Harga</th>
                      <th>Created at</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- looping menggunakan forelse -->
                    @forelse ($product as $row)

                    <tr>
                      <td>
                        <!-- tampilkan gambar dari folder publik/storage/product -->
                        <img src="{{ asset('storage/products/' . $row->image) }}" width="100px" height="100px" alt="{{ $row->name }}">
                      </td>
                      <td>
                        <strong>{{ $row->name }}</strong><br />
                        <!-- apapun nama kategorinya diambil dari hasil relasi produk dan kategori -->
                        <label>Kategori: <span class="badge badge-info">{{ $row->category->name }}</span></label><br />
                        <label>Berat: <span class="badge badge-info">{{ $row->weight }}</span></label>
                      </td>
                      <td>Rp {{ number_format($row->price) }}</td>
                      <td>{{ $row->created_at->format('d-m-Y') }}</td>

                      <!-- karena berisi html maka kita gunakan { !! untuk mencetak data -->
                      <td>{!! $row->status_label !!}</td>
                      <td>
                        <!-- form untuk menghapus data produk -->
                        <form action="{{ route('product.destroy', $row->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <a href="{{ route('category.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                          <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                      </td>

                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- membuat link paginate jika ada -->
              {!! $product->links() !!}

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection