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
                {{-- tambah data btn --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahBukuModal"> <i
                        class="fa fa-plus"></i>
                    Tambah Data</button>

                {{-- fitur Print PDF/Download --}}

                <a href="{{ route('admin.print.books') }}" target="_blank" class="btn btn-secondary"> <i
                        class="fa fa-print"></i>
                    Print PDF</a>

                {{-- Excel --}}
                <div class="btn-group" role="group" aria-label="Basic example">

                    {{-- Export excel --}}
                    <a href="{{ route('admin.book.export') }}" class="btn btn-info" target="_blank">Export</a>

                    {{-- Fitur Import Excel --}}

                    <button type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#importDataModal">Import</button>

                </div>




                {{-- Modal --}}
                {{-- For Add Book --}}
                <div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                                        aria-hidden="true">&times;</span> </button>
                            </div>


                            <div class="modal-body">

                                <form method="post" action="{{ route('admin.book.submit') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="judul">Judul Buku</label>
                                        <input type="text" class="form-control" name="judul" id="judul" required />

                                    </div>
                                    <div class="form-group">
                                        <label for="penulis">Penulis </label>
                                        <input type="text" class="form-control" name="penulis" id="penulis" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="tahun">Tahun </label>
                                        <input type="year" class="form-control" name="tahun" id="tahun" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="penerbit">Penerbit </label>
                                        <input type="text" class="form-control" name="penerbit" id="penerbit"
                                            required />
                                    </div>

                                    <div class="form-group">
                                        <label for="cover">Cover </label>
                                        <input type="file" class="form-control" name="cover" id="cover" />
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- For Excel --}}

                <div class="modal fade" id="importDataModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                                        aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('admin.book.import') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cover">Upload File</label>
                                        <input type="file" name="file" class="form-control">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Import Book</button>
                                    </div>

                                </form>
                            </div>


                        </div>
                    </div>
                </div>

                <hr>


                {{-- End Modal --}}

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
                            <tr class="text-center">
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
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" id="btn-edit-buku" class="btn btn-success"
                                            data-toggle="modal" data-target="#editBukuModal"
                                            data-id="{{ $book->id }}">Edit</button>
                                    </div>

                                    <button type="button" id="btn-delete-buku" class="btn btn-danger"
                                        onclick="deleteConfirmation('{{ $book->id }}', '{{ $book->judul }}')">Delete</button>
                                    @method('DELETE')
                                    {{-- Modal for Action --}}
                                    {{-- For Edit --}}
                                    <div class="modal fade" id="editBukuModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Book</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('admin.book.update') }}" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <div class="form-group">
                                                                    <label for="edit-judul">Judul </label>
                                                                    <input type="text" class="form-control"
                                                                        name="judul" id="edit-judul" required />
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="edit-penulis">Penulis </label>
                                                                    <input type="text" class="form-control"
                                                                        name="penulis" id="edit-penulis" required />
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="edit-tahun">Tahun </label>
                                                                    <input type="year" class="form-control"
                                                                        name="tahun" id="edit-tahun" required />
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="edit-penerbit">Penerbit </label>
                                                                    <input type="text" class="form-control"
                                                                        name="penerbit" id="edit-penerbit" required />
                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group" id="image-area"></div>
                                                                <div class="form-group">
                                                                    <label for="edit-cover">Cover</label>
                                                                    <input type="file" class="form-control"
                                                                        name="cover" id="edit-cover">
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <input type="hidden" name="id" id="edit-id">
                                                    <input type="hidden" name="old_cover" id="edit-old-cover">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
            </div>

            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection

@section('js')

    <script>
        // for update edit
        $(function() {
            $(document).on('click', '#btn-edit-buku', function() {
                let id = $(this).data('id');
                $('#image-area').empty();

                $.ajax({
                    type: "get",
                    url: "{{ url('/admin/ajaxadmin/dataBuku') }}" + id,
                    dataType: "json",
                    success: function(res) {
                        $('#edit-judul').val(res.judul);
                        $('#edit-penerbit').val(res.penerbit);
                        $('#edit-penulis').val(res.penulis);
                        $('#edit-tahun').val(res.tahun);
                        $('#edit-id').val(res.id);
                        $('#edit-old-cover').val(res.cover);

                        if (res.cover !== null) {
                            $('#image-area').append(
                                "<img src='" + baseurl + "/storage/cover_buku/" + res
                                .cover + "' width='200px'  />"
                            );
                        } else {
                            $('#image-area').append('[Image Not Found]');

                        }
                    },
                });
            });
        });


        //for delete

        function deleteConfirmation(npm, judul) {
            swal.fire({
                title: "Delete",
                type: 'warning',
                text: 'R U Sure For Delete This  ' + judul + '?!',

                showCancelButton: !0,
                confirmButtonText: 'Just Do It',
                cancelButtonText: 'No Dont !',
                reverseButton: !0,


            }).then(function(e) {
                    if (e.value === true) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            type: "POST",
                            url: "books/delete/" + npm,
                            data: {
                                _token: CSRF_TOKEN
                            },
                            dataType: "JSON",
                            success: function(results) {
                                if (results.success === true) {
                                    swal.fire("Done!", results.message, "Success Bro");

                                    //refresh page after 2sc
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    swal.fire(' Something Wrong is it !', result.message, "error");
                                }
                            }
                        });
                    } else {
                        e.dismiss;
                    }

                },
                function(dismiss) {
                    return false;
                })
        }
    </script>

@endsection
