@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Data Anggota</h1>
@stop

@section ('content')
<div class="container-fluid">
    <div class="card card-default">
        <div class="card-header">{{ __('Pengelolaan Anggota') }}</div>
        <div class="card-body">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahAnggotaModal"><i class="fa fa-plus"></i>Tambah Anggota</button>
            <hr>
            <table id="table-data" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>NO</th>
                        <th>NISN</th>
                        <th>NAMA</th>
                        <th>TGL LAHIR</th>
                        <th>KELAS</th>
                        <th>FOTO</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach($anggota as $anggota)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$anggota->nisn}}</td>
                        <td>{{$anggota->nama}}</td>
                        <td>{{$anggota->tgl_lahir}}</td>
                        <td>{{$anggota->kelas}}</td>
                        <td>@if($anggota->foto !== null)<img src="{{ asset('storage/cover_buku/'.$anggota->cover) }}" width="100dp"/>
                        @else
                            [gambar tidak tersedia]
                        @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" id="btn-edit-buku" class="btn btn-success" data-toggle="modal" data-target="#editBukuModal" data-id="{{ $anggota->id }}">Edit</button>
                                <button type="button" id="btn-delete-buku" class="btn btn-danger" onclick="deleteConfirmation('{{$anggota->id}}', '{{$anggota->judul}}' )">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahAnggotaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.book.submit') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="judul">Nisn</label>
                        <input type="text" class="form-control" name="nisn" id="nisn" required/>
                    </div>
                    <div class="form-group">
                        <label for="penulis">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" required/>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tgl Lahir</label>
                        <input type="year" class="form-control" name="tgl_lahir" id="tgl_lahir" required/>
                    </div>
                    <div class="form-group">
                        <label for="penerbit">Kelas</label>
                        <input type="text" class="form-control" name="kelas" id="kelas" required/>
                    </div>
                    <div class="form-group">
                        <label for="cover">Foto</label>
                        <input type="file" class="form-control" name="foto" id="foto"/>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
