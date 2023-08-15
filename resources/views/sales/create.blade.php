@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header">{{ __('Create New Item') }}</div>

              <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif

                  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
                  </head>
                  <body>
                  <div class="container">
                    <form action="{{ route("item.store") }}" method="post" enctype="multipart/form-data">
                      {!! csrf_field() !!}
                      <label>Nama</label></br>
                      <input type="text" name="nama" id="nama" class="form-control"></br>
                      <label>Deskripsi</label></br>
                      <input type="text" name="deskripsi" id="deskripsi" class="form-control"></br>
                      <label>Jenis Barang</label></br>
                      <input type="text" name="jenis" id="jenis" class="form-control"></br>
                      <label>Stok</label></br>
                      <input type="number" name="stok" id="stok" class="form-control"></br>
                      <label>Harga Beli</label></br>
                      <input type="number" name="hargabeli" id="hargabeli" class="form-control"></br>
                      <label>Harga Jual</label></br>
                      <input type="number" name="hargajual" id="hargajual" class="form-control"></br>
                      <label>Gambar</label></br>
                      <input type="file" name="gambar" id="hargajual" class="form-control" accept="image/*"></br>
                      <input type="submit" value="Save" class="btn btn-success"></br>
                  </form>
                  </div>
                  </body>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection