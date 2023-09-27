{{-- <div class="container mb-5">
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
</div> --}}
<div class="container my-5">
    <div class="row">
        <div class="col-md-10 mx-auto d-md-flex align-items-center justify-content-between">
            <h4>Polling List</h4>
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
    <hr>
</div>

{{-- Looping Data Polling  --}}
@foreach ($data_polling as $dp)
    @php
        $date_start = date('d-m-Y', $dp->date_start);

        $date_end = date('d-m-Y', $dp->date_end);
    @endphp

    <div class="container">
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

                    {{-- <hr class="d-none d-md-block"> --}}

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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          
        <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="text-center mb-5">
                <div class="d-flex justify-content-center mb-3 ">
                    <img src="{{ asset('img/favicon-RK.png') }}" alt="logo radar karawang" style="width: 100px;">
                  </div>
                  <h4>Polling Radar Karawang</h4>
                  <p>Login Options</p>
            </div>
            <div class="text-center">
                <div class="d-grid gap-2">
                    <a href="{{ route('google.login') }}" class="btn btn-outline-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/></svg>
                        Login with Google
                    </a>
                    <a href="{{ route('facebook.login') }}" class="btn btn-outline-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="-204.79995 -341.33325 1774.9329 2047.9995"><path d="M1365.333 682.667C1365.333 305.64 1059.693 0 682.667 0 305.64 0 0 305.64 0 682.667c0 340.738 249.641 623.16 576 674.373V880H402.667V682.667H576v-150.4c0-171.094 101.917-265.6 257.853-265.6 74.69 0 152.814 13.333 152.814 13.333v168h-86.083c-84.804 0-111.25 52.623-111.25 106.61v128.057h189.333L948.4 880H789.333v477.04c326.359-51.213 576-333.635 576-674.373" fill="#1877f2"/><path d="M948.4 880l30.267-197.333H789.333V554.609C789.333 500.623 815.78 448 900.584 448h86.083V280s-78.124-13.333-152.814-13.333c-155.936 0-257.853 94.506-257.853 265.6v150.4H402.667V880H576v477.04a687.805 687.805 0 00106.667 8.293c36.288 0 71.91-2.84 106.666-8.293V880H948.4" fill="#fff"/></svg>
                        Login with Facebook
                    </a>
                  </div>
            </div>
          </div>
        </div>
      </div>
</div>
