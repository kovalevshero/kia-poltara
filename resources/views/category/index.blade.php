@extends('layouts.master')
@section('style')
    <style>
        .image-news {
            width: 150px;
            height: 150px;
            padding: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <section class="card">
            <div class="card-header">
                <div class="float-left">
                    <h3 class="header-title">
                        <i class="fa fa-file-text-o"></i> Kategori Berita
                    </h3>
                </div>
                <div class="float-right">
                    <div class="btn-group" role="group">
                        <a href="{{ url('category/add') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"
                                aria-hidden="true"></i> Tambah Kategori</a>
                    </div>
                </div>

            </div>
        </section>

        <!-- Content Row -->
        <section class="card">
            <div class="card-body">
                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Situs</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $val)
                            <tr>
                                <td width="1%">{{ $key + 1 }}</td>
                                <td>{{ $val->nama_kategori }}</td>
                                <td>{{ $val->nama_situs }}</td>
                                <td>
                                    @if ($val->status_kategori == 1)
                                        <div class="badge badge-success">Aktif</div>
                                    @else
                                        <div class="badge badge-danger">Tidak Aktif</div>
                                    @endif
                                </td>
                                <td class="text-center" width="10%">
                                    <a href="#" class="btn btn-sm btn-inline btn-success disabled" data-toggle="modal"
                                        disabled>Edit</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endsection
