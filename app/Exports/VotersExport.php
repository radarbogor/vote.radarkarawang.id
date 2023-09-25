<?php

namespace App\Exports;

use App\Models\Voting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VotersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $setVoteUnitId;

    public function __construct(int $voteUnitId)
    {
        $this->setVoteUnitId = $voteUnitId;
    }

    public function view(): View
    {
        return view('exports.voters', [
            'voters' => Voting::with(['user', 'voteitem'])->where('vote_unit_id', $this->setVoteUnitId)->get(),
        ]);
    }
}
