@extends('layouts.main')

@section('child')

    {{-- @include('layouts.navbar') --}}

    <link rel="stylesheet" href="{{ asset('css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <div class="container">
        {{-- Content --}}
        <div class="col-md-10 mx-auto my-3 my-md-5">

            {{-- Basic Profile Tes --}}
            <div class="row align-items-center d-flex flex-md-row mb-5">
                <div class="col-md-5 d-flex align-items-center justify-content-center profile_bgx mb-3">
                    <img class="img_thumbx bg-white p-1 shadow" data-aos="zoom-out" data-aos-duration="1500"
                        src="{{ asset('storage/' . $data_item->vote_image) }}" alt="...">
                </div>
                <div class="col-md-7">
                    <div data-aos="fade-down" data-aos-duration="1000">
                        <h1 class="card-title mb-0 fw-bold mb-3 mb-md-0 text-uppercase">{{ $data_item->vote_name }}</h1>
                        <hr class="mt-1 mb-3 d-none d-md-block">
                        <p class="mb-1 fw-bold">{{ $data_item->vote_position }}</p>
                        <p class="fw-bold">{!! $data_item->description !!}</p>
                    </div>
                </div>
            </div>

            @if ($data_item->voteProfile)

                {{-- Gallery --}}
                @if ($data_item->voteProfiles)
                    <div class="my-5">
                        <h6 class="mb-3">Gallery: <span class="badge bg-success">{{$data_item->vote_name}}</span></h6>
                        <hr>
                        {{-- Lopping Image --}}
                        @foreach ($data_item->voteProfiles as $item)
                            <div class="slider">
                                @foreach (json_decode($item->gallery) as $g)
                                    <a href="{{ asset('storage/' . $g) }}" class="fancybox item" data-fancybox="gallery1">
                                    <img src="{{ asset('storage/' . $g) }}" class="img-fluid img_slick" alt="...">
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="d-grid gap-2 d-md-flex justify-content-end">
                    @if (Auth::guard('admin')->user())
                        <a href="/admin/add-polling-item/{{ $data_item->voteUnit[0]->slug }}" class="text-end text-decoration-none mb-3"
                            type="button"><i class="fas fa-reply"></i> Back</a>
                    @endif
                </div>

            @endif
            <div class="d-grid gap-2 d-md-flex justify-content-end">
                <a href="/polling/{{ $data_item->voteUnit[0]->slug}}" class="text-end text-decoration-none mb-3 link-opacity-50"
                    type="button"><i class="fas fa-reply"></i> Back</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/slider.js') }}" type="text/javascript"></script>

@endsection
