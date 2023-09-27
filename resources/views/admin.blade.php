
@extends('layouts.main')

@section('child')
{{-- @include('layouts.navbar') --}}

<div class="container">
  {{-- Content --}}
  <div class="col-md-10 mx-auto my-3 my-md-5">

    <div class="d-flex align-items-center justify-content-between mb-3 mb-md-5">
      <h4 class="mb-0">{{ $title }}</h4>
      <a class="btn btn-primary btn-sm" href="admin/addPolling" role="button">
        <i class="fas fa-plus"></i> Add Polling
      </a>
    </div>

        {{-- Response --}}
        @if ($message = Session::get('message'))
        {{-- Allert after Vote --}}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- End Response --}}

      @include('partials.adminCardPollunit')

  </div>

</div>

@endsection
