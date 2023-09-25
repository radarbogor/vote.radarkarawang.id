{{-- Be like water. --}}

@section('child')

<link rel="stylesheet" href="{{ asset('css/uploadGalleryBox.css') }}">

<div class="container">

{{-- Content --}}
<div class="col-md-10 mx-auto my-3 my-md-5">
    <h6 class="text-muted mb-3 mb-md-5">{{ $title }}</h6>

    <div class="card">
        <div class="card-header">
            @if ($data_item->premium_profile == 1)
                <small class="text-success fst-italic"><i class="fas fa-check-circle"></i> Premium Profile</small>
            @else
                <small class="text-secondary fst-italic"><i class="fas fa-times-circle"></i> Basic Profile</small>
            @endif
        </div>
        <div class="card-body">
          <div class="row d-flex align-items-center">
            <div class="col-md-4 d-flex justify-content-center mb-3 mb-md-0">
              <img src="{{ asset('storage/'. $data_item->vote_image )}}" class="img-thumbnail img_thumb_2">
            </div>
            <div class="col-md-8">
              {{-- Input Name & title --}}
              <div class="row">
                <h4>{{ $data_item->vote_name }}</h4>
                <p>~ {{ $data_item->vote_position }}</p>
              </div>
              <hr>

              <p class="text-justify">{!! $data_item->description !!}</p>
            </div>
          </div>
        </div>
      </div>


 @livewire('store-profile-items',['data_item' => $data_item])
</div>

    <script type="text/javascript" >
         jQuery(document).ready(function() {
            ImgUpload();
        });
    </script>


</div>
@endsection
