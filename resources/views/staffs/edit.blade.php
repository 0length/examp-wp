@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header">{{ __('Edit Admin') }}</div>

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
                    <form action="{{ route('staff.update', $staff->id) }}" method="post" enctype="multipart/form-data">
                      {!! csrf_field() !!}
                      <label>Nama</label></br>
                      <input type="text" name="name" id="nama" value="{{ $staff->name }}" class="form-control"></br>
                      <label>Email</label></br>
                      <input type="email" name="email" id="deskripsi" value="{{ $staff->email }}" class="form-control"></br>
                      <label>Jenis Kelamin</label></br>
                      <select class="form-control" name="gender">
                        <option value="" disabled>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" @if($staff->gender == 'Laki-laki') {{ "selected" }} @endif>Laki-laki</option>
                        <option value="Perempuan" @if($staff->gender == 'Perempuan') {{ "selected" }} @endif>Perempuan</option>
                      </select><br />
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