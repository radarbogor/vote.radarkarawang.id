
@extends('layouts.main')

@section('child')

<div class="container">
{{-- Content --}}
<div class="col-md-10 mx-auto my-3 my-md-5">
    <h6 class="text-muted mb-3 mb-md-5">{{ $title }}: <a class="fst-italic" href="{{ '/admin/pollingUnitBar/' . $vote_unit->slug}}"> {{$vote_unit->title}}</a></h6>

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
        <form action="{{ '/admin/editPolling/' . $vote_unit->id }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h6 class="mb-0 text-muted"><i class="fas fa-pen"></i> Edit Polling Unit</h6>
            </div>
            <div class="card-body">
                <div class="row my-2 d-flex align-items-center">
                    @if($vote_unit->thumbnail)
                        {{-- Thumbnail Poll Unit --}}
                        <div class="preview col-md-4 my-3">
                            <img src="{{ asset('storage/' . $vote_unit->thumbnail) }}" id="file-ip-1-preview" class="img-thumbnail img_thumb_upl">

                            {{-- File name thumbnail --}}
                            <input class="form-control mt-2" type="hidden" value="{{ $vote_unit->thumbnail }}" name="thumbnail_old">
                            <input class="form-control mt-2" type="file" id="file-ip-1" accept="image/*" onchange="showPreview(event);" name="thumbnail">
                            {{-- Response notif form input thumbnail --}}
                            @error('thumbnail')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ $message }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror
                        </div>
                    @else
                        {{-- Thumbnail Poll Unit --}}
                        <div class="preview col-md-4 my-3">
                            <img src="{{ asset('img/default1.jpg') }}" id="file-ip-1-preview" class="img-thumbnail img_thumb_upl">

                            {{-- File name thumbnail --}}
                            <input class="form-control mt-2" type="hidden" value="{{ $vote_unit->thumbnail }}" name="thumbnail_old">
                            <input class="form-control mt-2" type="file" id="file-ip-1" accept="image/*" onchange="showPreview(event);" name="thumbnail">
                            {{-- Response notif form input thumbnail --}}
                            @error('thumbnail')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ $message }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror
                        </div>
                    @endif

                    <div class="col-md-8 mb-2">
                        <div class="row">
                            <div class="col-lg-6">
                                {{-- Input title --}}
                                <input type="text" class="form-control mb-2" value="{{$vote_unit->title}}"
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
                                {{-- <span class="text-xs text-danger">click tab for generate  new slug</span> --}}
                                <input type="text" class="form-control mb-2" value="{{$vote_unit->slug}}"
                                    aria-label="slug" name="slug" id="slug"  readonly>
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
                    <input type="text" class="form-control mb-3" placeholder="Subtitle" aria-label="Subtiitle" value="{{ $vote_unit->subtitle }}" name="subtitle">
                     {{-- Response notif form input thumbnail --}}
                     @error('subtitle')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                    {{-- Input description --}}
                    {{-- <textarea class="form-control mb-3" placeholder="Description" id="floatingTextarea2" style="height: 100px" value="{{ $vote_unit->description }}" name="description">{{ $vote_unit->description }}</textarea> --}}
                    <textarea class="form-control" id="edit_summer" value="{{ $vote_unit->description }}" name="description">{{ $vote_unit->description }}</textarea>
                     {{-- Response notif form input thumbnail --}}
                     @error('description')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                    {{-- Input date --}}
                    <div class="row mt-3">

                        {{-- Convert Date Time --}}

                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="form-floating">
                                <input class="form-control-edit" type="date" name="date_start" id="date_start" value="{{date('Y-m-d', $vote_unit->date_start)}}">
                                <label for="floatingInput title-text" class="label-form-control-input">Start Date</label>
                                 {{-- Response notif form input thumbnail --}}
                                 @error('date_start')
                                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                     <strong>{{ $message }}</strong>
                                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                 </div>
                             @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control-edit" id="date_end" value="{{date('Y-m-d', $vote_unit->date_end)}}" name="date_end">
                                <label for="floatingInput title-text" class="label-form-control-input">Expired</label>
                                {{-- Response notif form input thumbnail --}}
                                @error('date_end')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="gap-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save Polling Unit</button>
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

    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    title.addEventListener('change', function() {
        fetch('/admin/polling/createSlug?title=' + title.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    });

    $("#date_end").change(function() {
        var startDate = document.getElementById("date_start").value;
        var endDate = document.getElementById("date_end").value;

        const date = new Date(<?= $vote_unit->date_end; ?> * 1000);
        const year = date.getFullYear();
        let month = date.getMonth() + 1;
            month = month.toLocaleString('en-US', { minimumIntegerDigits: 2, useGrouping: false });
        let day = date.getDate();
            day = day.toLocaleString('en-US', { minimumIntegerDigits: 2, useGrouping: false });
        const dateString = `${year}-${month}-${day}`;

        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            alert("Tanggal berakhir harus lebih dari tanggal polling dimulai !!");
            document.getElementById("date_end").value = dateString;
        }
    });

    $(document).ready(function() {
        // $('#summernote').summernote();
        $('#edit_summer').summernote({
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



