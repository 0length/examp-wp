@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Keranjang') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form action="{{ route('item.buy') }}" method="post">
                                @csrf
                                <div class="container">


                                    @if (Auth::user()->role == Auth::user()->getRoleCustomer())
                                        <button id="btn-pinjam" type="submit"
                                        onclick="localStorage.clear()"
                                        class="btn btn-success btn-sm"
                                            title="Add New Item">
                                            Pinjam 
                                        </button>
                                    @endif

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Deskripsi</th>
                                                <th>Jenis</th>
                                                  <th>Stok</th>
                                                <th>Tahun</th>
                                                <th>Penerbit</th>
                                                @if (Auth::user()->role !== Auth::user()->getRoleCustomer())
                                                    <th>Action</th>
                                                @endif
                                                @if (Auth::user()->role == Auth::user()->getRoleCustomer())
                                                    <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr id="book-{{$item->id}}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->BookName }}</td>
                                                    <td style=" white-space: nowrap;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;
                                                    max-width: 200px;">{{ $item->Description }}</td>
                                                    <td>{{ ($item->getBookType($item->BookTypeID))->BookType }}</td>
                                                    <td>{{ $item->Stock }}</td>
                                                    <td>{{ $item->Year }}</td>
                                                    <td>{{ $item->Publisher }}</td>
                                                    <td>
                                                        @if (Auth::user()->role !== Auth::user()->getRoleCustomer())
                                                            <a href="{{ route('item.show', $item->id) }}" title="View Item"
                                                                class="btn btn-info btn-sm"><i class="fa fa-eye"
                                                                    aria-hidden="true"></i> View</a> &nbsp;
                                                            <a href="{{ route('item.edit', $item->id) }}" title="Edit Item"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                Edit</a> &nbsp;
                                                            <a href="{{ route('item.delete', $item->id) }}"
                                                                title="Delete Item" class="btn btn-danger btn-sm"><i
                                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                Delete</a>
                                                        @endif
                                                        @if (Auth::user()->role == Auth::user()->getRoleCustomer() && $item->Stock)
                                                            <div class="container">
                                                                <div
                                                                    class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">

                                                                    <input type="number"
                                                                        name="id_item-{{ $item->id }}" value="1"
                                                                        placeholder="Jumlah" class="form-control" hidden>
                                                                </div>
                                                            </div>
                                </div>
                                @endif

                                </td>
                                @if (Auth::user()->role == Auth::user()->getRoleCustomer())
                                    <td>
                                        <a href="#"
                                        onclick="window.removeCart({{$item->id}})"
                                        title="View Item"
                                            class="btn btn-danger btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                            Delete</a> &nbsp;
                                    </td>
                                @endif

                                </tr>
                                @endforeach
                                </tbody>
                                </table>
                                <h6>Info: Peminjaman yang melewati 7 hari belum di kembalikan akan di kenakan denda di setiap bukunya</h6>

                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.bookData = {!!json_encode($items)!!};
          window.removeCart = (id)=>{
            if(!localStorage.getItem("cart")){
                localStorage.setItem("cart", JSON.stringify([]));
            }
            const old = JSON.parse(localStorage.getItem("cart"));
            if(old.includes(id)){
                localStorage.setItem("cart", JSON.stringify([...JSON.parse(localStorage.getItem("cart"))].filter((i)=>i!==id)));
            }
            location.href = '{{route('item.loan')}}'
          }
          window.bookData.map((i)=>{
              const old = JSON.parse(localStorage.getItem("cart"))||[];
              if(!old.includes(i.id)){
                  document.querySelector('#book-'+i.id).parentNode.removeChild(document.querySelector('#book-'+i.id))
              }
              
          })
        });
      </script>
@endsection
