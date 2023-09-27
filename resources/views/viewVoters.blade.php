@extends('layouts.main')
@section('child')
    @php
        $date_start = date('d-m-Y', $voteUnit->date_start);

        $date_end = date('d-m-Y', $voteUnit->date_end);
    @endphp
    <div class="container mt-5">
        {{-- <div class="col-md-10 mx-auto mb-5 card">
            <div class="card-body  p-3">
                <div class="row d-flex align-items-center" data-aos="zoom-in">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $voteUnit->thumbnail) }}" class="pstr_thumb" alt="...">
                    </div>

                    <div class="col-md-8">
                        @if (\Carbon\Carbon::parse(now())->gt($date_end))
                            <a href="javascript:void(0)" class="mb-3 text-decoration-none text-dark">
                                <h2><strong>{{ $voteUnit->title }}</strong></h2>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="mb-3 text-decoration-none text-dark">
                                <h2><strong>{{ $voteUnit->title }}</strong></h2>
                            </a>
                        @endif

                        <hr class="d-none d-md-block">

                        <div class="d-none d-md-block">
                            {!! $voteUnit->description !!}
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
                        <hr class="d-block d-md-none">

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="gap-2 d-flex justify-content-end">
                    <a href="/admin/export-voters/{{ $voteUnit->slug }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fas fa-print"></i> Export Voters
                    </a>
                </div>
            </div>
        </div> --}}

        <div class="my-5 col-md-10 mx-auto border rounded-2 p-2">
            @if (\Carbon\Carbon::parse(now())->gt($date_end))
                <a href="javascript:void(0)" class="mb-2 text-decoration-none text-dark text-center">
                    <h4>Voters: <strong>{{ $voteUnit->title }}</strong></h4>
                </a>
            @else
                <a href="javascript:void(0)" class="mb-2 text-decoration-none text-dark text-center">
                    <h4>Voters: <strong>{{ $voteUnit->title }}</strong></h4>
                </a>
            @endif
            <hr>
            <div class="table-responsive mb-2">
                <table class="table table-sm" id="dataTable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Kandidat Dipilih</th>
                            <th>Tgl & Jam. Voting</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voters as $vote)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $vote->user->name }}</td>
                                <td>{{ $vote->user->email }}</td>
                                <td>{{ $vote->voteItem->vote_name }}</td>
                                <td>{{ $vote->created_at }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="gap-2 d-flex justify-content-end">
                <a href="/admin/export-voters/{{ $voteUnit->slug }}" class="btn btn-primary btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Export Voters
                </a>
            </div>
        </div>
    </div>
@endsection
