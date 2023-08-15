@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header">{{ __('Create New User') }}</div>

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
                    <form action="{{ route("customer.store") }}" method="post" enctype="multipart/form-data">
                      {!! csrf_field() !!}
                      <label>Nama</label></br>
                      <input type="text" name="name" id="nama" class="form-control"></br>
                      <label>Email</label></br>
                      <input type="email" name="email" id="deskripsi" class="form-control"></br>
                      <label>Jenis Kelamin</label></br>
                      <select class="form-control" name="gender">
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select><br />
                      <label>Tempat Lahir</label></br>
                      <input type="text" name="born_place" id="stok" class="form-control"></br>
                      <label>Tanggal Lahir</label></br>
                      <input type="date" name="born_date" id="hargabeli" class="form-control"></br>
                      <label>Address</label></br>
                      <textarea name="address" class="form-control"></textarea> <br />
                      <label>Foto KTP</label></br>
                      <input type="file" name="ktp" id="hargajual" class="form-control" accept="image/*"></br>
                      <label>Password</label></br>
                      <input type="password" name="password" id="stok" class="form-control"></br>
                      <label>Retype Password</label></br>
                      <input type="password" name="retype_password" id="stok" class="form-control"></br>
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