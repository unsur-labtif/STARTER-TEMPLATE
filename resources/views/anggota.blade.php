@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Data Anggota</h1>
@stop

@section('js')
<script>
    $(function(){
            $(document).on('click','#btn-edit-anggota', function(){
                let id = $(this).data('id');

                $('#image-area').empty();

                $.ajax({
                    type: "get",
                    url: "{{url('/admin/ajaxadmin/dataAnggota')}}/"+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-nisn').val(res.nisn);
                        $('#edit-nama').val(res.nama);
                        $('#edit-kelas').val(res.kelas);
                        $('#edit-tgl_lahir').val(res.tgl_lahir);
                        $('#edit-id').val(res.id);
                        $('#edit-old-foto').val(res.Foto);

                        if (res.foto !== null) {
                            $('#image-area').append(
                                "<img src='"+baseurl+"/storage/foto_anggota/"+res.Foto+"' width='200px'/>"
                                );
                            } else {
                                $('#image-area').append('[Gambar tidak tersedia]');
                            }
                        },
                    });
                });
        });
</script>

<script>
    function deleteConfirmation(npm, nisn) {
        swal.fire({
            title: "Hapus?",
            type: 'warning',
            text: "Apakah anda yakin ingin menghapus data Anggota dengan nisn : " + nisn+"?!",

            showCancelButton: !0,
            confirmButtonText: "Hapus",
            cancelButtonText: "Tidak",
            reverseButtons: !0
        }).then(function (e){
            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: "anggota/delete/" + npm,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true){
                            swal.fire("Done!", results.message, "success");
                            //refresh page affter 2 seconds
                            setTimeout(function(){
                                location.reload();
                            },1000);
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
            } else {
                e.dismiss;
            }

        }, function (dismiss) {
            return false;
        })
    }
</script>

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
                        <th>THN LAHIR</th>
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
                        <td>@if($anggota->Foto !== null)<img src="{{ asset('storage/foto_anggota/'.$anggota->Foto) }}" width="100dp"/>
                        @else
                            [gambar tidak tersedia]
                        @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" id="btn-edit-anggota" class="btn btn-success" data-toggle="modal" data-target="#editAnggotaModal" data-id="{{ $anggota->id }}">Edit</button>
                                <button type="button" id="btn-delete-anggota" class="btn btn-danger" onclick="deleteConfirmation('{{$anggota->id}}', '{{$anggota->nisn}}' )">Hapus</button>
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
                <form method="post" action="{{ route('admin.anggota.submit') }}" enctype="multipart/form-data">
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
                        <label for="tahun">Thn Lahir</label>
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

<div class="modal fade" id="editAnggotaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form action="{{ route('admin.anggota.update') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit-judul">Nisn</label>
                                    <input type="text" class="form-control" name="nisn" id="edit-nisn" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-penulis">Nama</label>
                            <input type="text" class="form-control" name="nama" id="edit-nama" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit-tahun">Tgl Lahir</label>
                            <input type="year" class="form-control" name="tgl_lahir" id="edit-tgl_lahir" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit-penerbit">Kelas</label>
                            <input type="text"  class="form-control" name="kelas" id="edit-kelas" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="image-area"></div>
                        <div class="form-group">
                            <label for="edit-cover">Foto</label>
                            <input type="file" class="form-control" name="foto" id="edit-foto"/>
                        </div>
                    </div>
                </div>
            </div>

                <div class="modal-footer">
                    <input type="hidden" name="id" id="edit-id"/>
                    <input type="hidden" name="old_foto" id="edit-old-foto"/>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
        </div>
    </div>
</div>

@endsection
