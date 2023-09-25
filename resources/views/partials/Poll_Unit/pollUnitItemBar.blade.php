{{-- Loop Iteration --}}
@php
    $i = 1;
@endphp

{{-- Looping data vote item --}}
@foreach ($polling_item as $item)
    {{-- Vote Item --}}
    <div class="row g-0 my-3">
        <div class="col-md-3 d-flex justify-content-center">
            {{-- Vote Thumbnail --}}
            <img src="{{ asset('storage/' . $item->vote_image) }}" class="img-thumbnail img_card" alt="...">
        </div>
        <div class="col-md-9 d-flex align-items-center">
            <div class="card-body px-0 ps-md-3">
                {{-- Vote Name --}}
                <div class="d-flex mb-3">
                    {{-- <h5>{{$i++}}.</h5> --}}
                    <div class="">
                        <h2>{{ $item->vote_name }}</h2>
                    </div>
                </div>
                {{-- Cari jumlah persentase dari pemilih --}}
                @php
                    // Cek apakah ada data total user vote
                    if ($total_user_vote > 0) {
                        $total_vote = ($item->response / $total_user_vote) * 100;
                    } else {
                        $total_user_vote = 0;
                        # jika tidak ada data total user vote
                        $total_vote = $item->response;
                    }
                @endphp
                <p class="text-primary mb-2">{{ round($total_vote) }}% Suara</p>
                <div class="progress">
                    {{-- Validasi Login Role Admin --}}
                    @if ($total_vote == 0)
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            style="width:100%; background-color:#d5d5d5;" aria-valuenow="{{ $total_vote }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    @else
                        <div class="progress-bar progress-bar progress-bar-striped progress-bar-animated"
                            role="progressbar" style="width: {{ $total_vote }}%" aria-valuenow="{{ $total_vote }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    @endif
                </div>
                <hr class="d-block d-md-none">
            </div>
        </div>
    </div>
@endforeach

<div class="container">
    <div class="row">
        <hr class="d-block ">
        <div class="col-lg-12 d-flex justify-content-center">
            <canvas id="graph"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php
    if (count($polling_item) != 0) {
        foreach ($polling_item as $pollingItem) {
            $voteName[] = $pollingItem->vote_name;
            $color[] = 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.5)';
            $voteCandidate[] = $pollingItem->response;
        }
        $vote_name_convert = json_encode($voteName);
        $vote_convert = json_encode($voteCandidate);
        $color_convert = json_encode($color);

        echo 'var kandidat = ' . $vote_name_convert . ";\n";
        echo 'var voteKandidat = ' . $vote_convert . ";\n";
        echo 'var color = ' . $color_convert . ";\n";
    }
    ?>

    var ctx = document.getElementById("graph").getContext("2d");
    // tampilan chart
    var piechart = new Chart(ctx, {
        type: 'pie',
        data: {

            // label nama setiap Value
            labels: kandidat,
            datasets: [{
                // Jumlah Value yang ditampilkan
                data: voteKandidat,

                backgroundColor: color
            }],
        }
    });
</script>
