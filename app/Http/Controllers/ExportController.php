<?php

namespace App\Http\Controllers;

use App\Exports\VotersExport;
use App\Models\VoteUnit;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportVoters(VoteUnit $voteUnit){
        $date = date('d-m-Y');
        return Excel::download(new VotersExport($voteUnit->id), "Voters ($voteUnit->title) $date.xlsx");
    }
}
