@extends('layouts.admin')

@section('title')
<title>Edit kategori</title>
@endsection

@section('content')
<main class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item active">Edit kategori</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">

        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Edit Kategori</h4>
            </div>
            <div class="card-body">
              <!-- routingnya mengirimkan id kategori yg di edit -->
              <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label for="name">Kategori</label>
                  <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                  <p class="text-danger">{{ $errors->first('name') }}</p>
                </div>
                <div class="form-group">
                  <label for="parent_id">Kategori</label>
                  <select name="parent_id" id="" class="form-control">
                    <option value="">None</option>
                    @foreach ($parent as $row)

                    <!-- terdapat ternri operator untuk mengcek jika parent id sama dengan id categori pada list parent maka otomatis selected -->
                    <option value="{{ $row->id }}" {{ $category->parent_id == $row->id ? 'selected':'' }}>{{ $row->name }}</option>
                    @endforeach
                  </select>
                  <p class="text-danger">{{ $errors->first('name') }}</p>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary btn-sm">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>
@endsection