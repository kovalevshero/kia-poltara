@extends('layouts.master')
@section('title', 'Situs')

@section('styles')
    <style>
        .header-title {
            padding: 5px 0px 0px 20px;
            margin-bottom: 0;
            color: #818181;
            margin-bottom: 0px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <section class="card">
            <div class="card-header">
                <div class="float-left">
                    <h3 class="header-title">
                        <i class="fa fa-users"></i> Platform Situs
                    </h3>
                </div>
                <div class="float-right">
                    <div class="btn-group" role="group">
                        <a href="javascript:void(0)" class="btn btn-primary btn-create pull-right">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Situs</a>
                    </div>
                </div>
            </div>
        </section>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong style="color: #46c35f;">{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong style="color: red;">{{ $message }}</strong>
            </div>
        @endif

        <section class="card">
            <div class="card-body">
                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Situs</th>
                            <th>Url Situs</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $val)
                            <tr>
                                <td width="1%">{{ $key + 1 }}</td>
                                <td>{{ $val->site_name }}</td>
                                <td>{{ $val->site_url }}</td>
                                <td class="text-center" width="10%">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning btn-inline btn-edit"
                                        data-toggle="modal" data-id="{{ $val->id }}" data-nama="{{ $val->site_name }}"
                                        data-url="{{ $val->site_url }}">
                                        <i class="fa fa-pencil-square-o"></i> Edit Situs
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Modal tambah situs -->
    <div class="modal fade" id="modalSite" tabindex="-1" role="dialog" aria-labelledby="modalSentimenTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title float-left" id="exampleModalLongTitle">Tambah Situs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('site/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label text-left modal-style-label">Nama Situs</label>
                                    <br>
                                    <input type="text" class="form-control mt-10" id="site_name" name="site_name"
                                        placeholder="Nama Situs">
                                    <br>
                                    <label class="form-control-label text-left modal-style-label">Url Situs</label>
                                    <br>
                                    <input type="text" class="form-control mt-10" id="site_url" name="site_url"
                                        placeholder="Url Situs">
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="text-left">
                            <button type="button" class="btn btn-secondary float-left" data-dismiss="modal"><i
                                    class="fa fa-times" aria-hidden="true"></i> Close</button>
                            <button type="submit" class="btn btn-primary float-right"><i class="fa fa-check"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal tambah situs -->
@endsection

@section('script')
    <script>
        $(function() {
            $('#example').DataTable({
                bStateSave: true,
            });

            $('.btn-create').click(function() {
                $('#modalSite').modal('toggle');
            });
        });
    </script>
@endsection
