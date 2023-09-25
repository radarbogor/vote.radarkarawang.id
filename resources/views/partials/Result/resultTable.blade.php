{{-- Poll unit table result --}}
<div class="table-responsive">
    <table class="table table-sm" style="width: 900px;">
        <thead>
            <tr>
                <th scope="col" style="width: 20px;">No</th>
                <th scope="col" style="width: 200px;">Name</th>
                <th scope="col" style="width: 520px;">Progressbar</th>
                <th scope="col">Response</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($total_votings as $tv)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $tv->vote_name }}</td>
                    <td>
                        {{-- Cari jumlah persentase dari pemilih --}}
                        @php
                            // Cek apakah ada data total user vote
                            if ($total_user_vote > 0) {
                                $total_vote = ($tv->response / $total_user_vote) * 100;
                            } else {
                                $total_user_vote = 0;
                                # jika tidak ada data total user vote
                                $total_vote = $tv->response;
                            }
                        @endphp
                        <div class="progress mt-1">
                            @if ($total_vote == 0)
                                <div class="progress-bar text-dark" role="progressbar"
                                    style="width:100%; background-color:#d5d5d5;" aria-valuenow="{{ $total_vote }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            @else
                                <div class="progress-bar" role="progressbar" style="width: {{ $total_vote }}%"
                                    aria-valuenow="{{ $total_vote }}" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <p class="mb-0">{{ round($total_vote) }}% | {{ $tv->response }} Suara</p>
                    </td>
                </tr>
            @endforeach
            <tr>
                @php
                    if ($total_user_vote) {
                        $total_response_vote = ($total_vote_item / $total_user_vote) * 100;
                    } else {
                        $total_response_vote = 0;
                    }
                @endphp
                <td colspan="3"><strong>Total Response</strong></td>
                <td><strong> {{ $total_user_vote }} Suara</strong></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="container">
    <div class="row">
        <hr class="d-block ">
        <div class="col-lg-3"></div>
        <div class="col-lg-5 d-flex justify-content-center">
            <canvas id="graph"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php
    if (count($total_votings) != 0) {
        foreach ($total_votings as $pollingItem) {
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
