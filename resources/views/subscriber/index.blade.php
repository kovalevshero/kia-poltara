@extends('layouts.master')
@section('title', 'Subscriber')

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
                        <i class="fa fa-users"></i> Subscriber
                    </h3>
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
                            <th>Email</th>
                            <th>Status</th>
                            <th>Tanggal Subscribe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $val)
                            <tr>
                                <td width="1%">{{ $key + 1 }}</td>
                                <td>{{ $val->email }}</td>
                                <td>
                                    @if ($val->is_valid == 1)
                                        <div class="badge badge-success">Aktif</div>
                                    @elseif ($val->is_valid == 2)
                                        <div class="badge badge-success">Aktif Email</div>
                                    @else
                                        <div class="badge badge-danger">Tidak Aktif</div>
                                    @endif
                                </td>
                                <td>{{ date_format($val->created_at, 'd M Y H:i:s') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ url('subscriber/delete') }}/{{ $val->id_news_subscription }}"
                                            class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i>
                                            Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#example').DataTable({
                bStateSave: true,
            });
        });
    </script>
@endsection
