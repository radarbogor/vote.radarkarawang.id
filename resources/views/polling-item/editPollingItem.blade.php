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
                <form action="{{ '/admin/edit-polling-item/' . $voteItem->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h6 class="mb-0 text-muted"><i class="fas fa-pen"></i> Edit Polling Item</h6>
                    </div>
                    <div class="card-body">
                        <div class="row my-2 d-flex align-items-center">
                            <input type="hidden" name="idPolling" value="{{$voteItem->vote_unit_id}}">
                            @if ($voteItem->vote_image)
                                {{-- Thumbnail Poll Unit --}}
                                <div class="preview col-md-4 my-3">
                                    <img src="{{ asset('storage/' . $voteItem->vote_image) }}" id="file-ip-1-preview"
                                        class="img-thumbnail img_thumb_upl">

                                    {{-- File name thumbnail --}}
                                    <input class="form-control mt-2" type="hidden" value="{{ $voteItem->vote_image }}"
                                        name="vote_image_old">
                                    <input class="form-control mt-2" type="file" id="file-ip-1" accept="image/*"
                                        onchange="showPreview(event);" name="vote_image">
                                    {{-- Response notif form input vote_image --}}
                                    @error('vote_image')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ $message }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @enderror
                                </div>
                            @else
                                {{-- Thumbnail Poll Unit --}}
                                <div class="preview col-md-4 my-3">
                                    <img src="{{ asset('img/default1.jpg') }}" id="file-ip-1-preview"
                                        class="img-thumbnail img_thumb_upl">

                                    {{-- File name thumbnail --}}
                                    <input class="form-control mt-2" type="hidden" value="{{ $voteItem->vote_image }}"
                                        name="thumbnail_old">
                                    <input class="form-control mt-2" type="file" id="file-ip-1" accept="image/*"
                                        onchange="showPreview(event);" name="vote_image">
                                    {{-- Response notif form input vote_image --}}
                                    @error('vote_image')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ $message }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-md-8 mb-2">
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{-- Input vote_name --}}
                                        <input type="text" class="form-control mb-2"
                                            value="{{ $voteItem->vote_name }}" aria-label="Title" name="vote_name"
                                            id="vote_name">
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
                                        {{-- Input slug --}}
                                        {{-- <span class="text-xs text-danger">click tab for generate new slug</span> --}}
                                        <input type="text" class="form-control mb-2" value="{{ $voteItem->slug }}"
                                            aria-label="slug" name="slug" id="slug" readonly>
                                        {{-- Response notif form input slug --}}
                                        @error('slug')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>{{ $message }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Input vote_position --}}
                                <input type="text" class="form-control mb-3" placeholder="vote_position"
                                    aria-label="Subtiitle" value="{{ $voteItem->vote_position }}" name="vote_position">
                                {{-- Response notif form input thumbnail --}}
                                @error('vote_position')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror
                                {{-- Input description --}}
                                <textarea class="form-control poll_summer"  name="description">{{ $voteItem->description }}</textarea>

                                {{-- Response notif form input thumbnail --}}
                                @error('description')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="gap-2 d-flex justify-content-end">
                            <div class="input-check">
                                <input type="checkbox" class="form-check-input m-2" id="premium_profile"
                                    name="premium_profile" value="1" @if ($voteItem->premium_profile == 1) {{'checked'}} @endif>
                                <label for="premium_profile" class="mt-1"> Premium Profile</label><br>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Edit
                                Polling Item</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <script src="{{ asset('js/previewImg.js') }}"></script>
    {{-- cdn add form --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    </div>

    <script>
         const vote_name = document.querySelector('#vote_name');
        const slug = document.querySelector('#slug');

        vote_name.addEventListener('change', function() {
            fetch('/admin/polling-item/createSlug?vote_name=' + vote_name.value)
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
