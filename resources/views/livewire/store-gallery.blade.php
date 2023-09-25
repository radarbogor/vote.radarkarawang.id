<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="card my-5">
        <form wire:submit.prevent="storeProfile" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card-header"><small class="text-success fst-italic"><i class="fas fa-check-circle"></i> Premium Profile Feature</small></div>
            <div class="card-body">
            {{-- Gallery upload --}}
            <h5>Gallery</h5>
            <div class="upload__box">
                <div class="upload__btn-box">
                    <label class="upload__btn">
                        <p class="mb-0">Upload images</p>
                        <input type="file" data-max_length="20" class="upload__inputfile" wire:model="gallery">
                        @error('gallery.*')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @enderror
                    </label>
                </div>
                <div class="upload__img-wrap">
                    @if($gallery)
                        @foreach ($gallery as $g)
                        {{-- <img src="{{ $g->temporaryUrl(); }}" alt="" class="img-thumbnail img_thumb_2"> --}}
                        <div class='upload__img-box' wire:key="{{$loop->index}}">
                                <div style='background-image: url("{{ $g->temporaryUrl(); }}")' class='img-bg' data-file='{{ $g->temporaryUrl(); }}'><div class='upload__img-close' wire:click="removeUpload({{$loop->index}})"></div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
            <div class="card-footer">
                <div class="gap-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success btn-sm" wire:click="$emitUp('profileAdded')"><i class="fas fa-save"></i> Save Gallery</button>
                    <a href="/admin/add-polling-item/{{ $data_item->voteUnit[0]->slug }}" class="btn btn-secondary btn-sm" type="button"><i class="fas fa-reply"></i> Back</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Looping Data Profile --}}
    <div class="my-5">
        <div class="my-5">
            <h6 class="mb-3">Gallery: <span class="badge bg-success">{{$data_item->vote_name}}</span></h6>
            @foreach ($data_profile as $p)
                @foreach (json_decode($p->gallery) as $g)
                    <img src="{{ asset('storage/' .$g)  }}" class="img-fluid img_gallery" alt="...">
                @endforeach
            @endforeach
        </div>
    </div>


</div>


<script>
    $(document).ready(function() {
        // $('#summernote').summernote();
        $('.summernote').summernote({
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
          callbacks: {
              onChange: function(contents, $editable) {
              @this.set('desc_profile', contents);
          }
      }
      });
    });

</script>

