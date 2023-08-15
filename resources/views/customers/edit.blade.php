@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header">{{ __('Edit User') }}</div>

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
                    <form action="{{ route('customer.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                      {!! csrf_field() !!}
                      <label>Nama</label></br>
                      <input type="text" name="name" id="nama" value="{{ $customer->name }}" class="form-control"></br>
                      <label>Email</label></br>
                      <input type="email" name="email" id="deskripsi" value="{{ $customer->email }}" class="form-control"></br>
                      <label>Jenis Kelamin</label></br>
                      <select class="form-control" name="gender">
                        <option value="" disabled>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" @if($customer->gender == 'Laki-laki') {{ "selected" }} @endif>Laki-laki</option>
                        <option value="Perempuan" @if($customer->gender == 'Perempuan') {{ "selected" }} @endif>Perempuan</option>
                      </select><br />
                      <label>Tempat Lahir</label></br>
                      <input type="text" name="born_place" id="stok" value="{{ $customer->born_place }}" class="form-control"></br>
                      <label>Tanggal Lahir</label></br>
                      <input type="date" name="born_date" id="hargabeli" value="{{ $customer->born_date }}" class="form-control"></br>
                      <label>Address</label></br>
                      <textarea name="address" class="form-control">{{ $customer->address }}</textarea> <br />
                      <label>Foto KTP</label></br>
                      <input type="file" name="ktp" id="hargajual" class="form-control" accept="image/*"></br>
                      <img src="{{ $customer->ktp_path }}" /> <br />
                      <input type="submit" value="Update" class="btn btn-warning mt-5"></br>
                  </form>
                  </div>
                  </body>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection