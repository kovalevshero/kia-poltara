@extends('layouts-content.default')
@section('title', 'Membuat Berita')

@section('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }

        .bootstrap-tagsinput {
            width: 94% !important;
        }

        .label {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            -webkit-border-radius: .25rem;
            border-radius: .25rem
        }

        .label-info {
            background-color: #ac6bec
        }

        .ck-word-count {
            font-size: 13px;
            opacity: 0.6;
        }

        .ck-word-count__words {
            text-align: right;
        }

        .ck-word-count__characters {
            display: none;
        }

        .col-md-2-5 {
            width: 20.83333%;
        }

        .search-content,
        .search-draft {
            font-family: FontAwesome, "Open Sans", Verdana, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: inherit;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <form action="{{ url('content/update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row no-gutters">
                <!-- Left Column. -->
                <div class="col-md-2">
                    <div class="card-body">
                        <ul class="nav nav-fill nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" id="draf-tab" data-toggle="tab" href="#draf" role="tab"
                                    aria-controls="draf" aria-selected="true">Draf</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="terbit-tab" data-toggle="tab" href="#terbit" role="tab"
                                    aria-controls="terbit" aria-selected="true">Terbit</a>
                            </li>
                        </ul>

                    </div>
                    <div class="form-outline my-2 d-flex justify-content-center">
                        <a href="{{ url('content/create') }}"><u>Buat berita baru +</u></a>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="draf" role="tabpanel" aria-labelledby="draf-tab">
                            <div class="card-body border-bottom">
                                <div class="form-outline">
                                    <input type="search" class="form-control form-control-md w-100 search-draft"
                                        placeholder="&#xf002; &nbsp; Cari draf berita..." aria-label="Search">
                                </div>
                                <p class="mb-0 mt-2" style="font-size: 13px; opacity: 0.6;">{{ $count_draft }} Draf
                                </p>
                            </div>
                            <div class="draft-content">
                                @foreach ($draft as $val)
                                    <div class="card card-body">
                                        <a href="{{ url('content/edit') }}/{{ $val->id }}"
                                            class="stretched-link draft-content"
                                            style="color: inherit;">{{ $val->title }}</a>
                                        <p class=" mb-0 mt-2" style="font-size: 11px; opacity: 0.6;">
                                            {{ date_format($val->created_at, 'd M Y H:i') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group mt-4 d-flex justify-content-center">
                                {{ $draft->links() }}
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="terbit" role="tabpanel" aria-labelledby="terbit-tab">
                            <div class="card-body">
                                <div class="form-outline">
                                    <input type="search" class="form-control form-control-md w-100 search-content"
                                        placeholder="&#xf002; &nbsp; Cari judul berita..." aria-label="Search">
                                </div>
                                <p class="mb-0 mt-2" style="font-size: 13px; opacity: 0.6;">{{ $count_terbit }}
                                    Berita terbit
                                </p>
                            </div>
                            <div class="terbit-content">
                                @foreach ($terbit as $val)
                                    <div class="card card-body border-bottom">
                                        <a href="{{ url('content/edit') }}/{{ $val->id }}"
                                            class="stretched-link judul-terbit-content"
                                            style="color: inherit;">{{ $val->title }}</a>
                                        <p class="mb-0 mt-2 tanggal-terbit-content" style="font-size: 11px; opacity: 0.6;">
                                            {{ date_format($val->created_at, 'd M Y H:i') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group mt-4 d-flex justify-content-center">
                                {{ $terbit->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Center Column. -->
                <div class="col-md-8 border-left border-right">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{ $data->content_id }}">
                            <input type="text" class="form-control" name="title"
                                placeholder="Tulis judul berita disini..." value="{{ $data->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="input-foto">Foto Sampul</label>
                            <input type="file" id="input-foto" class="form-control dropify" name="image"
                                accept="jpg jpeg png" data-max-file-size="2M"
                                data-default-file="{{ asset('img') }}/content/{{ $data->image }}">
                        </div>
                        <div class="form-group">
                            <label for="input-deskripsi-foto">Keterangan Foto</label>
                            <input type="text" id="input-deskripsi-foto" class="form-control" name="image_description"
                                placeholder="Deskripsi foto..." value="{{ $data->image_description }}" required>
                        </div>

                        <textarea cols="80" id="isi_content" class="isi_content" name="body" rows="10">{{ $data->body }}</textarea>

                        <div id="word-count"></div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" class="form-control" name="tags" data-role="tagsinput"
                                    value="@foreach ($tags as $val) {{ $val->tag_name }}, @endforeach"
                                    placeholder="Tambahkan tags...">
                                <p style="font-style: italic; font-size: 12px; margin: 0;">Tekan koma untuk menginputkan
                                    tags</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Column. -->
                <div class="col-md-2">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <button type="submit" class="btn btn-primary mx-3 btn-terbit"
                                    style="width: 100%;">Terbitkan</button>
                            </div>
                            <div class="row">
                                <input type="hidden" class="input-draft" name="is_draft">
                                <button class="btn btn-secondary mt-2 mx-3 btn-draft" style="width: 100%;">
                                    Simpan ke draf
                                </button>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <label for="input-platform">Platform Terbit</label>
                            <select class="selectpicker form-control select-situs" name="site_id[]" id="input-platform"
                                data-live-search="true" data-live-search-placeholder="Pilih platform"
                                title="Pilih platform" multiple required>
                                @foreach ($site as $val)
                                    <option value="{{ $val->id }}"
                                        {{ $val->id == $data->site_id ? 'selected' : '' }}>
                                        {{ $val->site_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="input-kategori">Kategori</label>

                            <select class="selectpicker form-control select-kategori" name="category_id"
                                id="input-kategori" data-live-search="true">
                                @foreach ($category as $val)
                                    <option value="{{ $val->id }}"
                                        {{ $val->id == $data->category_id ? 'selected' : '' }}>
                                        {{ $val->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="input-tanggal-publish">Tanggal Terbit</label>
                            <input type="datetime-local" step="0" id="input-tanggal-publish" class="form-control"
                                value="{{ $data->published_date }}" name="published_date">
                        </div>
                        <div class="form-group mt-2">
                            <label for="input-penulis">Penulis</label>
                            <input type="text" id="input-penulis" class="form-control" name="writer"
                                value="{{ $data->writer }}" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="input-editor">Editor</label>
                            <input type="text" id="input-editor" class="form-control" name="editor"
                                value="{{ $data->editor }}"
                                {{ Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ? '' : 'readonly' }}>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            if (!"{{ $data->category_id }}") {
                $('.select-kategori').append(
                    `<option value="" selected disabled>Pilih kategori</option>`
                )
            }

            ClassicEditor.create(document.querySelector('#isi_content'), {
                    placeholder: 'Tulis artikelmu...',
                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    ckfinder: {
                        uploadUrl: '{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}'
                    },
                    wordCount: {
                        onUpdate: stats => {
                            // Prints the current content statistics.
                            // console.log(`Characters: ${ stats.characters }\nWords: ${ stats.words }`);
                        }
                    }
                })
                .then(editor => {
                    const wordCountPlugin = editor.plugins.get('WordCount');
                    const wordCountWrapper = document.getElementById('word-count');

                    wordCountWrapper.appendChild(wordCountPlugin.wordCountContainer);
                })
                .catch(error => {
                    console.error(error);
                });

            $('.dropify').dropify();

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $('.select-situs').on('change', function() {
                let siteId = $(this).val()

                if (site_id) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        method: 'GET',
                        url: "{{ url('content/get-category') }}",
                        data: {
                            'site_id': siteId[siteId.length - 1],
                        },
                        success: function(data, status, xhr) {
                            let result = JSON.parse(xhr.responseText);

                            if (result.status == true) {
                                if (result.data.length > 0) {
                                    $('.select2-selection__choice__remove').click(function(
                                        e) {
                                        $('.select-kategori').empty()
                                        $('.select-kategori').append(
                                            `<option value="" selected disabled>Pilih kategori</option>`
                                        )
                                    })

                                    $.each(result.data, function(index, value) {
                                        $('.select-kategori').append(
                                            `<option value="${value.id}">${value.category_name}</option>`
                                        )
                                    })
                                } else {
                                    $('.select-kategori').html(
                                        `<option value="" selected disabled>Pilih kategori</option>`
                                    )
                                }
                            } else {}
                        },
                        error: function(data, status, xhr) {
                            alert('Gagal mendapatkan data kategori')
                        }
                    });
                } else {
                    $('.select-kategori').html(
                        `<option value="" selected disabled>Pilih kategori</option>`
                    )
                }
            })

            $('.search-content').on('keyup', function() {
                let query = $(this).val();

                fetchContent(query);
            })

            $('.search-draft').on('keyup', function() {
                let query = $(this).val();

                fetchDraft(query);
            })

            $('.btn-terbit').on('click', function() {
                $('.input-draft').val(null)
            })

            $('.btn-draft').on('click', function() {
                $('.input-draft').val(1)
            })
        })

        function fetchContent(query = '') {
            $.ajax({
                url: "{{ url('content/search') }}",
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function(data) {
                    $('.terbit-content').html(data.data)
                }
            })
        }

        function fetchDraft(query = '') {
            $.ajax({
                url: "{{ url('content/search') }}",
                method: 'GET',
                data: {
                    query: query,
                    is_draft: 1
                },
                dataType: 'json',
                success: function(data) {
                    $('.draft-content').html(data.data)
                }
            })
        }
    </script>
@endsection
