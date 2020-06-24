<!-- MEMANGGIL MASTER TEMPLATE YANG SUDAH DIBUAT SEBELUMNYA, YAKNI admin.blade.php -->
@extends('layouts.admin')

@section('title')
<title>List kategori</title>
@endsection

@section('content')
<main class="main">

  <ol class="breadcrumb">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item active">Kategori</li>
  </ol>

  <div class="container-fluid">
    <div class="animated fadeIn">

      <div class="row">

        <!--BAGIAN INI AKAN MENG-HANDLE FORM INPUT NEW CATEGORY  -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Kategori Baru</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('category.store')}}" method="post">
                @csrf
                <div class="form-group">
                  <label for="name">Kategori</label>
                  <input type="text" name="name" id="" class="form-control" required>
                  <p class="text-danger">{{ $errors->first('name') }}</p>
                </div>
                <div class="form-group">
                  <label for="parent_id">Kategori</label>
                  <!-- VARIABLE $PARENT PADA METHOD INDEX KITA GUNAKAN DISINI -->
                  <!-- UNTUK MENAMPILKAN DATA CATEGORY YANG PARENT_ID NYA NULL -->
                  <!-- UNTUK DIPILIH SEBAGAI PARENT TAPI SIFATNYA OPTIONAL -->
                  <select name="parent_id" id="" class="form-control">
                    <option value="">None</option>
                    @foreach ($parent as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                  </select>
                  <p class="text-danger">{{ $errors->first('name') }}</p>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary btn-sm">Tambah</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- end BAGIAN INI AKAN MENG-HANDLE FORM INPUT NEW CATEGORY  -->

        <!-- BAGIAN INI AKAN MENG-HANDLE TABLE LIST CATEGORY  -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">List Categori</h4>
            </div>
            <div class="card-body">
              <!-- ketika ada session sukses -->
              @if (session('success'))
              <div class="alert alert-success">{{session('success')}}</div>
              @endif

              <!-- ketika ada session error -->
              @if (session('error'))
              <div class="alert alert-danger">{{session('error')}}</div>
              @endif

              <div class="table-responsive">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Kategori</th>
                      <th>Parent</th>
                      <th>Created At</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- loading data kategori sesuai jumlah data yg ada di variable $category -->
                    @forelse ($category as $val)
                    <tr>
                      <td></td>
                      <td><strong>{{ $val->name }}</strong></td>

                      <!-- menggunakan ternary operator untuk mengejek jika $val->parent ada maka tampilkan nama parentnya. selain itu maka tampilkan string -->
                      <td>{{ $val->parent? $val->parent->name:'-' }}</td>

                      <!-- format tanggal ketika kategori diinput sesuai format indonesia -->
                      <td>{{ $val->created_at->format('d-m-Y') }}</td>
                      <td>

                        <!-- form action untuk method delete -->
                        <form action="{{ route('category.destroy', $val->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <a href="{{ route('category.edit', $val->id) }}" class="btn btn-warning btn-sm">Edit</a>
                          <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>

                      </td>

                    </tr>

                    <!-- jika data katedori kosong, maka akan di render kolom dibawah ini -->
                    @empty
                    <tr>
                      <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- fungsi ini akan secara otomatis mengenerate tombol pagination -->
              {!! $category->links() !!}
            </div>
          </div>
        </div>
        <!-- end bagian menghandle list kategory -->
      </div>

    </div>
  </div>
</main>
@endsection