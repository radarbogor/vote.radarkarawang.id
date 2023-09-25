@extends('layouts.main')

@section('child')
    <div class="container">
        {{-- Content --}}
        <div class="col-md-10 mx-auto my-3 my-md-5">

            <h6 class="text-muted mb-3 mb-md-5">{{ $title }}</h6>

            {{-- Response --}}
            @if ($message = Session::get('success'))
                {{-- Allert after Vote --}}
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ $message }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- End Response --}}

            <div class="card">
                <form action="{{ route('admin.add-unit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h6 class="mb-0">Polling Unit</h6>
                    </div>
                    <div class="card-body">
                        <div class="row my-2 d-flex align-items-center">
                            {{-- Thumbnail Poll Unit --}}
                            <div class="preview col-md-4 my-3">
                                <img src="{{ asset('img/default1.jpg') }}" id="file-ip-1-preview"
                                    class="img-thumbnail img_thumb_upl mb-2">
                                <input class="form-control mb-3" type="file" id="file-ip-1" accept="image/*"
                                    onchange="showPreview(event);" name="thumbnail">
                                {{-- Response notif form input thumbnail --}}
                                @error('thumbnail')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-8 mb-2">
                                {{-- File name thumbnail --}}

                                {{-- title & slug --}}
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{-- Input title --}}
                                        <input type="text" class="form-control mb-2" placeholder="Title Polling"
                                            aria-label="Title" name="title" id="title">
                                        {{-- Response notif form input title --}}
                                        @error('title')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>{{ $message }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        {{-- Input title --}}
                                        <input type="text" class="form-control mb-2" placeholder="click tab for generate slug"
                                            aria-label="slug" name="slug" id="slug" readonly>
                                        {{-- Response notif form input title --}}
                                        @error('slug')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>{{ $message }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Input subtitle --}}
                                <input type="text" class="form-control mb-3" placeholder="Subtitle" aria-label="Subtitle"
                                    name="subtitle">
                                {{-- Response notif form input subtitle --}}
                                @error('subtitle')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror
                                {{-- Response notif form input subtitle --}}
                                @error('name')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror
                                {{-- Input description --}}
                                <textarea class="form-control poll_summer" placeholder="Description" id="poll_summer" name="description"></textarea>

                                {{-- Response notif form input description --}}
                                @error('description')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror
                                {{-- Input date --}}
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="date_start" placeholder="Text"
                                                name="date_start">
                                            <label for="floatingInput title-text">Star from</label>
                                        </div>
                                        {{-- Response notif form input date start --}}
                                        @error('date_start')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>{{ $message }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="date_end"
                                                placeholder="Text" name="date_end">
                                            <label for="floatingInput title-text">Expired</label>
                                        </div>
                                        {{-- Response notif form input date end --}}
                                        @error('date_end')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>{{ $message }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="gap-2 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save
                                Polling Unit</button>
                            <a href="/admin" class="btn btn-secondary btn-sm" type="button"><i
                                    class="fas fa-reply"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <script src="{{ asset('js/previewImg.js') }}"></script>
    {{-- cdn add form --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    $("#date_end").change(function() {
        var startDate = document.getElementById("date_start").value;
        var endDate = document.getElementById("date_end").value;

        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            alert("Tanggal berakhir harus lebih dari tanggal polling dimulai !!");
            document.getElementById("date_end").value = "";
        }
    });
    title.addEventListener('change', function() {
        fetch('/admin/polling/createSlug?title=' + title.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    });

        $(document).ready(function() {
            // $('#summernote').summernote();
            $('.poll_summer').summernote({
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']]
                ],

            });
        });
    </script>
@endsection
