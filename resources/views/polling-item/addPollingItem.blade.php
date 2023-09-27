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
                <form action="{{ route('admin.add-item') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Polling Item - {{ $voteUnit->title }}</h6>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#candidateModal">
                            <i class="fa-regular fa-folder-open"></i> Gunakan Kandidat Tersimpan
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row my-2 d-flex align-items-center">
                            {{-- Thumbnail Poll Unit --}}
                            <div class="preview col-md-4 my-3">
                                <img src="{{ asset('img/default1.jpg') }}" id="file-ip-1-preview"
                                    class="img-thumbnail img_thumb_upl mb-2">
                            </div>
                            <div class="col-md-8 mb-2">
                                <input class="form-control mb-2" type="file" id="file-ip-1" accept="image/*"
                                onchange="showPreview(event);" name="vote_image">
                                {{-- Response notif form input vote_image --}}
                                @error('vote_image')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror
                                <input type="hidden" name="vote_unit_id" id="vote_unit_id" value="{{ $voteUnit->id }}">
                                {{-- vote_name & slug --}}
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{-- Input vote_name --}}
                                        <input type="text" class="form-control mb-2" placeholder="Name of Candidate"
                                            aria-label="vote_name" name="vote_name" id="vote_name">
                                        {{-- Response notif form input vote_name --}}
                                        @error('vote_name')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>{{ $message }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        {{-- Input slug --}}
                                        <input type="text" class="form-control mb-2"
                                            placeholder="click tab for generate slug" aria-label="slug" name="slug"
                                            id="slug" readonly>
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

                                {{-- Input Position --}}
                                <input type="text" class="form-control mb-3" placeholder="Position" aria-label="Position"
                                    name="vote_position" id="vote_position">
                                {{-- Response notif form input vote_position --}}
                                @error('vote_position')
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
                                <textarea class="form-control poll_summer" placeholder="Description" id="description" name="description"></textarea>

                                {{-- Response notif form input description --}}
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
                                    name="premium_profile" value="1">
                                <label for="premium_profile" class="mt-1"> Premium Profile</label><br>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save
                                Polling Item</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <div class="my-5 col-md-10 mx-auto">

            {{-- Looping data items --}}
            {{-- <h6>Poll Items in "{{$data_unit->title}}"</h6> --}}

            <div class="table-responsive p-2 border rounded-2">
                <table class="table table-sm" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Profile Items</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($voteItems as $item)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td>{{ $item->vote_name }}</td>
                                <td>{{ $item->vote_position }}</td>

                                @if ($item->premium_profile == 1)
                                    <td><small class="text-success fst-italic"><i class="fas fa-check-circle"></i> Premium
                                            Profile Items</small></td>
                                    <td class="d-flex gap-1">
                                        <a href="/admin/edit-polling-item/{{ $item->slug }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="/admin/moreProfile/{{ $item->slug }} "
                                            class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-image"></i>
                                        </a>
                                        {{-- Delete Item --}}
                                        <form action="{{ route('admin.delete-poll-item') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button
                                                onclick="return confirm('Apakah anda yakin ingin menghapus polling item ini?' )"
                                                class="btn btn-danger btn-sm" type="submit">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @else
                                    <td><small class="text-secondary fst-italic"><i class="fas fa-times-circle"></i> Basic
                                            Profile Items </small></td>
                                    <td class="d-flex gap-1">
                                        <a href="/admin/edit-polling-item/{{ $item->slug }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="/admin/moreProfile/{{ $item->slug }} "
                                            class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-image"></i>
                                        </a>
                                        {{-- Delete Item --}}
                                            <form action="{{ route('admin.delete-poll-item') }}" method="post" class="d-block">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus polling item ini?' )"
                                                    class="btn btn-danger btn-sm" type="submit"><i
                                                        class="fa-solid fa-trash"></i></button>
    
                                            </form>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- modal courier --}}
    <div class="modal fade" id="candidateModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Kandidat</h5> <br>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>klik dibaris data untuk menggunakan data sebelumnya</p>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Vote Name</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Tgl. Data Disimpan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allVoteItem as $voteItem)
                                    <tr class="CandidateData" data-thumbnail="{{ $voteItem->vote_image }}"
                                        class="CandidateData" data-vote-name="{{ $voteItem->vote_name }}"
                                        class="CandidateData" data-vote-position="{{ $voteItem->vote_position }}"
                                        class="CandidateData" data-description="{{ $voteItem->description }}"
                                        class="CandidateData" data-premium-profile="{{ $voteItem->premium_profile }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $voteItem->vote_name }}</td>
                                        <td>{{ $voteItem->vote_position }}</td>
                                        <td>{{ $voteItem->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End courier centered Modal-->

    <script src="{{ asset('js/previewImg.js') }}"></script>
    {{-- cdn add form --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        const vote_name = document.querySelector('#vote_name');
        const slug = document.querySelector('#slug');

        vote_name.addEventListener('change', function() {
            generateSlug(vote_name.value);
        });

        function generateSlug(voteName) {
            fetch('/admin/polling-item/createSlug?vote_name=' + voteName)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        }
        // Modal courir
        $(document).on('click', '.CandidateData', function(e) {
            let url = '<?= env('APP_URL') ?>/storage/' + $(this).attr('data-thumbnail');

            document.getElementById("file-ip-1-preview").src = url;
            getImgURL(url, (imgBlob) => {
                // Load img blob to input
                let fileName = 'fileFromHistory.jpg'
                let file = new File([imgBlob], fileName, {
                    type: "image/jpeg",
                    lastModified: new Date().getTime()
                }, 'utf-8');
                let container = new DataTransfer();
                container.items.add(file);
                document.querySelector('#file-ip-1').files = container.files;

            })

            document.getElementById("vote_name").value = $(this).attr('data-vote-name');
            document.getElementById("vote_position").value = $(this).attr('data-vote-position');
            $(".poll_summer").summernote("code", $(this).attr('data-description'));

            if ($(this).attr('data-premium-profile') == 1) {
                document.getElementById("premium_profile").checked = true;
            } else {
                document.getElementById("premium_profile").checked = false;
            }

            generateSlug($(this).attr('data-vote-name'));

            $('#candidateModal').modal('hide');
        });

        // xmlHTTP return blob respond
        function getImgURL(url, callback) {
            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
                callback(xhr.response);
            };
            xhr.open('GET', url);
            xhr.responseType = 'blob';
            xhr.send();
        }

        $(document).ready(function() {
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
