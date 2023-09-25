<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Kandidat Dipilih</th>
            <th>Tgl dan Jam. Voting</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($voters as $vote)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $vote->user->name }}</td>
                <td>{{ $vote->user->email }}</td>
                <td>{{ $vote->voteItem->vote_name }}</td>
                <td>{{ $vote->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
