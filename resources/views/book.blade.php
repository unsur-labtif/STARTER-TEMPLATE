@extends('adminlte::page')

@section('title', 'Home Page')

@section('content_header')
    <h1>Data Buku</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                {{ __('pengelolaan Buku') }}
            </div>

            <div class="card-body">
                <button type="button" class="btn btn-primary" data-toogle="modal" data-target="#tambahBukuModal"> <i
                        class="fa fa-plus"></i>
                    Tambah Data</button>

                {{-- Modal --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Buku</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> <span
                                        aria-hidden="true">&times;</span> </button>
                            </div>


                            <div class="modal-body">

                                <form action="{{ route('admin.book.submit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="judul">Judul Buku</label>
                                        <input type="text" class="form-control" name="judul" id="judul" required />

                                    </div>
                                    <div class="form-group">
                                        <label for="penulis">Judul </label>
                                        <input type="text" class="form-control" name="penulis" id="penulis" required />
                                    </div>

                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>




                {{-- table --}}
                <table id="table-data" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>JUDUL</th>
                            <th>PENULIS</th>
                            <th>TAHUN</th>
                            <th>PENERBIT</th>
                            <th>COVER</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $book->judul }}</td>
                                <td>{{ $book->penulis }}</td>
                                <td>{{ $book->tahun }}</td>
                                <td>{{ $book->penerbit }}</td>
                                <td>
                                    @if ($book->cover !== null)
                                        <img src="{{ asset('storage/cover_buku/' . $book->cover) }}" alt=""
                                            width="100px">
                                    @else
                                        [gambar tidak tersedia]
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
