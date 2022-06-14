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
                        <i class="fa fa-file-text-o"></i> Approval Konten User
                    </h3>
                </div>
                <div class="float-right">
                    <div class="btn-group" role="group">
                        <a href="{{ url('add-content') }}" class="btn pull-right"><i class="fa fa-plus"
                                aria-hidden="true"></i> Tambah Konten</a>
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
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $val)
                            <tr>
                                <td width="1%">{{ $key + 1 }}</td>
                                <td><img src="https://sorot.news/img/content/{{ $val['gambar'] }}" class="image-news">
                                </td>
                                <td width="20%">{{ $val['judul'] }}</td>
                                <td>{{ $val['created_at'] }}</td>
                                @if ($val['status_content'] == 1)
                                    <td><label class="label label-warning">Pending</label></td>
                                @elseif($val['status_content'] == 2)
                                    <td><label class="label label-success">Publish</label></td>
                                @elseif($val['status_content'] == 3)
                                    <td width="20%"><label class="label label-danger text-center">Ditolak</label>
                                        <p style="font-size: 12px; margin-top: 20px;"><strong>catatan :</strong>
                                            {{ $val['catatan'] }}</p>
                                    </td>
                                @endif
                                <td class="text-center" width="10%">
                                    @if ($val['status_content'] == 1)
                                        <a href="#" class="btn btn-sm btn-inline btn-success" data-toggle="modal"
                                            onclick="showModalContent({{ $val }}); return false;"><i
                                                class="fa fa-check"></i> Persetujuan</a>
                                    @else
                                        <a href="#" class="btn btn-sm btn-inline btn-success disabled" data-toggle="modal"
                                            disabled><i class="fa fa-check"></i> Persetujuan</a>
                                    @endif

                                    <a href="{{ url('content_user/preview/' . encrypt($val['id_content_user'])) }}"
                                        class="btn btn-sm btn-inline btn-primary"><i class="fa fa-info-circle"></i>
                                        Preview</a>
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
