@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header">{{ __('Edit Item') }}</div>

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
                    <form action="{{ route('item.update', $items->id) }}" method="post" enctype="multipart/form-data">
                      {!! csrf_field() !!}
                      <input type="hidden" name="id" id="id" value="{{$items->id}}" id="id" />
                      <label>Nama</label></br>
                      <input type="text" name="BookName" id="nama" value="{{$items->BookName}}" class="form-control" required></br>
                      <label>Deskripsi</label></br>
                      <input type="text" name="Description" id="deskripsi" value="{{$items->Description}}" class="form-control" required></br>
                      <label>Jenis</label></br>
                      <select class="form-control" name="BookTypeID" required>
                          <option value="" disabled>Pilih Jenis Buku</option>
              
                          
                      @foreach ($cat as $c)
                          
                      <option value="{{$c->id}}" {{$c->id==$items->BookTypeID?'selected':''}} >{{$c->BookType}}</option>
                      @endforeach
                      </select><br />
                      <label>Stok</label></br>
                      <input type="number" name="Stock" id="stok" value="{{$items->Stock}}" class="form-control" required></br>
                      <label>Penerbit</label></br>
                      <input type="text" name="Publisher" id="Penerbit" class="form-control" value="{{$items->Publisher}}" required/></br>
                      <label>Tahun</label></br>
                      <input type="number" name="Year" id="Year" class="form-control" value="{{$items->Year}}" required/></br>
                      <input type="submit" value="Update" class="btn btn-success"></br>
                  </form>
                  </div>
                  </body>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection