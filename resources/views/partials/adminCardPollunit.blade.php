@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@foreach ($polling_unit as $pu)
    <div class="row d-flex align-items-center mb-5">
        <div class="col-md-4 mb-3 mb-md-0">
            <img src="{{ asset('storage/' . $pu->thumbnail) }}" class="pstr_thumb" alt="...">
        </div>
        <div class="col-md-8">
            <a href="admin/pollingUnitBar/{{ $pu->slug }}" class="mb-3 text-decoration-none text-dark">
                <h2><strong>{{ $pu->title }}</strong></h2>
            </a>
            <hr class="d-none d-md-block">
            <div class="d-none d-md-block">
                {!! $pu->description !!}
            </div>

            @php
                $date_start = date('d-m-Y', $pu->date_start);

                $date_end = date('d-m-Y', $pu->date_end);
            @endphp

            <div class="row d-flex align-items-center">
                <div class="col-md-9">
                    <p class="d-grid d-md-flex fst-italic mb-3 mb-md-0">
                        @if (\Carbon\Carbon::parse(now())->gt($date_end))
                            <small class="text-danger fst-italic"><i class="fas fa-times-circle mb-0"></i> Closed
                                Polling </small>
                        @elseif(\Carbon\Carbon::parse(now())->lt($date_start))
                            <small class="text-primary fst-italic me-md-3"><i class="fas fa-check-circle mb-0"></i>
                                Coming Soon Polling </small>
                            {{ $date_start }} s/d {{ $date_end }}
                        @else
                            <small class="text-success fst-italic me-md-3"><i class="fas fa-check-circle mb-0"></i> Live
                                Polling </small>
                            {{ $date_start }} s/d {{ $date_end }}
                    </p>
@endif
</div>

<div class="col-md-3 d-grid justify-content-md-end">

    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
        aria-expanded="false">
        Action
    </button>
    <ul class="dropdown-menu dropdown-menu-dark my-2">
        <li>
            <a href="admin/pollingUnitBar/{{ $pu->slug }}" class="dropdown-item"><i class="fa-solid fa-eye"></i>
                View</a>
            <a href="admin/editPolling/{{ $pu->slug }}" class="dropdown-item"><i class="fas fa-pen"></i> Edit</a>
        </li>
        @if (\Carbon\Carbon::parse(now())->gt($date_end))
        @else
            <li>
                <a href="admin/add-polling-item/{{ $pu->slug }}" class="dropdown-item"><i class="fa-solid fa-users"></i>
                    Poll items</a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            {{-- Close Polling Unit --}}
            <form action="{{ route('admin.close') }}" method="post">
                @csrf
                {{-- Convert time today to date --}}
                @php
                    $today = date('d-m-Y');
                @endphp
                <input type="hidden" name="id" value="{{ $pu->id }}">
                <input type="hidden" name="date_end" value="{{ $today }}">
                <button onclick="return confirm('Apakah anda yakin ingin menutup polling ini?' )" class="dropdown-item"
                    type="submit"><i class="fa-solid fa-xmark"></i> Close</button>
            </form>
        @endif
        <li>
            <a href="admin/voters/{{ $pu->slug }}" class="dropdown-item"><i class="fa-solid fa-users"></i>
                Voters</a>
        </li>
        <li>
            <a href="admin/result/{{ $pu->slug }}" class="dropdown-item"><i class="fa-solid fa-chart-bar"></i>
                Result</a>
        </li>
        {{-- Delete Unit --}}
        <form action="{{ route('admin.delete') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $pu->id }}">
            <li>
                <button onclick="return confirm('Apakah anda yakin ingin menghapus Polling ini?' )"
                    class="dropdown-item" type="submit"><i class="fa-solid fa-trash"></i> Delete</button>
                {{-- <button class="dropdown-items" type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus Polling ini?')"><i class="fa-solid fa-trash"></i> Delete</button> --}}
            </li>
        </form>
    </ul>
</div>
</div>

<hr class="d-md-none">
</div>
</div>
@endforeach

<div class="d-flex justify-content-center">
    {{ $polling_unit->links() }}
</div>
