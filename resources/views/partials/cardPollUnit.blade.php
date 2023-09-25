<div class="container mb-5">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-end">
            <div class="mr-5">
                <form action="/home">
                    <div class="input-group">
                        <div class="form-outline">
                            <input type="search" id="search" name="search" class="form-control"
                                placeholder="search polling....." value="{{ request('search') }}" />
                        </div>
                        <button id="search-button" type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Looping Data Polling  --}}
@foreach ($data_polling as $dp)
    @php
        $date_start = date('d-m-Y', $dp->date_start);

        $date_end = date('d-m-Y', $dp->date_end);
    @endphp

    <div class="container mt-5">
        <div class="col-md-10 mx-auto">

            <div class="row d-flex align-items-center mb-5 " data-aos="zoom-in">
                <div class="col-md-4 mb-3 mb-md-0">
                    <img src="{{ asset('storage/' . $dp->thumbnail) }}" class="pstr_thumb" alt="">
                </div>

                <div class="col-md-8">
                    @if (\Carbon\Carbon::parse(now())->gt($date_end))
                        <a @if (Auth::check() && !\Carbon\Carbon::parse(now())->lt($date_start)) href="/pollingUnitBar/{{ $dp->slug }}"
                            @elseif (\Carbon\Carbon::parse(now())->lt($date_start))
                                href="javascript:void(0)"
                                    onclick="alert('Pemungutan suara akan dimulai pada {{ $date_start }} !!')"
                            @else
                                data-bs-toggle="modal" data-bs-target="#modalOptionLogin" @endif
                            class="mb-3 text-decoration-none text-dark">
                            <h2><strong>{{ $dp->title }}</strong></h2>
                        </a>
                    @else
                        <a @if (Auth::check() && !\Carbon\Carbon::parse(now())->lt($date_start)) href="/polling/{{ $dp->slug }}"
                    @elseif (\Carbon\Carbon::parse(now())->lt($date_start)) href="javascript:void(0)"
                        onclick="alert('Pemungutan suara akan dimulai pada {{ $date_start }} !!')"
                            @else
                                data-bs-toggle="modal" data-bs-target="#modalOptionLogin" @endif
                            class="mb-3 text-decoration-none text-dark">
                            <h2><strong>{{ $dp->title }}</strong></h2>
                        </a>
                    @endif

                    <hr class="d-none d-md-block">

                    <div class="d-none d-md-block">
                        {!! $dp->description !!}
                    </div>

                    <div class="d-flex flex-column">
                        @if (\Carbon\Carbon::parse(now())->gt($date_end))
                            <small class="text-danger fst-italic mb-1"><i class="fas fa-times-circle"></i> Closed
                                Polling</small>
                        @elseif(\Carbon\Carbon::parse(now())->lt($date_start))
                            <small class="text-primary fst-italic me-md-3"><i class="fas fa-check-circle mb-0"></i>
                                Coming Soon Polling </small>
                            <small>{{ $date_start }} s/d {{ $date_end }}</small>
                        @else
                            <small class="text-success fst-italic mb-1"><i class="fas fa-check-circle"></i> Live
                                Polling</small>
                            <small>{{ $date_start }} s/d {{ $date_end }}</small>
                        @endif
                    </div>

                    <div class="btn-group d-grid d-md-block mt-3">
                        @if (\Carbon\Carbon::parse(now())->gt($date_end))
                            <a @if (\Carbon\Carbon::parse(now())->lt($date_start)) href="javascript:void(0)"
                                        onclick="alert('Pemungutan suara akan dimulai pada {{ $date_start }} !!')"
                                @elseif (Auth::check() && !\Carbon\Carbon::parse(now())->lt($date_start))
                                    href="/pollingUnitBar/{{ $dp->slug }}"
                                @else
                                    data-bs-toggle="modal" data-bs-target="#modalOptionLogin" @endif
                                class="btn btn-primary mt-md-3" type="button">Lihat Polling</a>
                        @else
                            <a @if (\Carbon\Carbon::parse(now())->lt($date_start)) href="javascript:void(0)"
                                    onclick="alert('Pemungutan suara akan dimulai pada {{ $date_start }} !!')"
                            @elseif (Auth::check() && !\Carbon\Carbon::parse(now())->lt($date_start))
                                href="/polling/{{ $dp->slug }}"
                            @else
                                data-bs-toggle="modal" data-bs-target="#modalOptionLogin" @endif
                                class="btn btn-primary mt-md-3" type="button">Ikuti Polling</a>
                        @endif
                    </div>
                    <hr class="d-block d-md-none">

                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="d-flex justify-content-center">
    {{ $data_polling->links() }}
</div>

<!-- Modal login -->
<div class="modal fade" id="modalOptionLogin" tabindex="-1" role="dialog" aria-labelledby="modalOptionLoginTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 25px !important;">
            <div class="modal-body">
                <div class="text-center">
                    <h5 class="mb-5">Login Option</h5>
                    <a href="{{ route('facebook.login') }}" class="btn btn-primary mb-3">Login With Facebook</a>
                    <a href="{{ route('google.login') }}" class="btn btn-dark mb-3">Login With Google</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
