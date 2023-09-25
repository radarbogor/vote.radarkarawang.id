<?php

namespace App\Http\Controllers;

use App\Models\VoteItem;
use App\Models\VoteProfile;
use App\Models\VoteUnit;
use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Cviebrock\EloquentSluggable\Services\SlugService;

class pollingController extends Controller
{
    public function index()
    {

        $data_pollings = VoteUnit::with('votings')
            ->orderBy('id', 'desc');

        if (request('search')) {
            $data_pollings->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%');
        }


        return view('home', [
            "title" => "Home",
            "data_polling" => $data_pollings->paginate(5)->withQueryString(),
        ]);
    }

    public function create()
    {

        // Ambil semua data vote unit dan validasi jumlah data vote unit
        $query_vote_unit = VoteUnit::all();

        if (count($query_vote_unit)) {

            $vote_unit_id_latest = DB::table('vote_units')
                ->select('id')
                ->latest()->first();

            $data = $vote_unit_id_latest->id;
        } else {

            $vote_unit_id_latest = [
                'id' => 0,
            ];

            $data = $vote_unit_id_latest['id'];
        }


        return view('polling.addPolling', [
            "title" => "Add Polling Unit",
            'vote_unit_id_latest' => $data
        ]);
    }

    public function create_unit(Request $request)
    {
        // Buat rule validasi form input unit
        $validated = $request->validate([
            'thumbnail' => 'required|image|file',
            'title' => 'required',
            'slug' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'subtitle' => 'required',
        ]);

        // Cek jika ada gambar yang di inputkan dan simpan kedalam folder storage
        if ($request->hasfile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('unit-items');
        }

        // Cek jika ada gambar yang di inputkan dan simpan kedalam folder storage
        if ($request->hasfile('vote_image')) {
            $validated['vote_image'] = $request->file('vote_image')->store('vote-items');
        }


        // Ubah date normal time ke date epoch
        $epoch_start = $request->date_start;
        $dt = new DateTime("$epoch_start");  // convert UNIX timestamp to PHP DateTime
        $date_start = $dt->format('U');

        $epoch_end = $request->date_end;
        $dt = new DateTime("$epoch_end");  // convert UNIX timestamp to PHP DateTime
        $date_end = $dt->format('U');


        // Validate form vote unit
        $validated['description'] = $request->description;
        $validated['date_start'] = $date_start;
        $validated['date_end'] = $date_end;



        // Validate form vote unit
        $validated['vote_unit_id'] = $request->vote_unit_id + 1;

        // VoteItem::create($validated);

        $save = VoteUnit::create($validated);

        if ($save) {

            return redirect('admin')->with('success', 'Your data has been created!');
        } else {

            return back()->with('error', 'Your data failed created!')->withInput();
        }
    }

    public function show_profile($id)
    {

        $data_item = VoteItem::with('voteProfiles')->where('vote_unit_id', $id)->first();

        return view('viewProfileItems', [
            "title" => "View Profile Items",
            // 'data_unit' => $data_unit,
            'data_item' => $data_item
        ]);
    }

    public function show_profile_item($voteItem)
    {

        $data_item = VoteItem::with(['voteProfiles', 'voteUnit'])->where('slug', $voteItem)->first();

        return view('profile', [
            "title" => "View Profile Items",
            'data_item' => $data_item
        ]);
    }

    public function show_bar($id)
    {

        $polling_unit = DB::table('vote_units')
            ->where('slug', $id)
            ->first();

        $polling_item = DB::table('vote_items')
            ->where('vote_unit_id', $polling_unit->id)
            ->get();

        $total_user_vote = DB::table('votings')
            ->where('vote_unit_id', $polling_unit->id)
            ->count('*');

        return view('polling.pollingUnitBar', [
            "title" => "Polling Unit Bar",
            "polling_unit_with_items" => $polling_unit,
            "polling_item" => $polling_item,
            "total_user_vote" => $total_user_vote,
        ]);
    }

    // Controller Fitur Polling Unit
    public function show_unit($slug)
    {

        $data_polling_unit_with_items = VoteUnit::with(['vote_items', 'votings'])->where('slug', $slug)->first();

        $total_user_vote = DB::table('votings')
            ->where('vote_unit_id', $data_polling_unit_with_items->id)
            ->count('*');

        $data_user_vote = Voting::where('user_vote', Auth::user()->id);

        return view('polling.pollingUnit', [
            "title" => "Polling Unit Bar",
            "polling_unit_with_items" => $data_polling_unit_with_items,
            "total_user_vote" => $total_user_vote,
            "data_user_vote" => $data_user_vote,

        ]);
    }

    public function polling_survey(VoteUnit $id)
    {

        $polling_unit = DB::table('vote_units')
            ->where('id', $id->id)
            ->first();

        $polling_item = DB::table('vote_items')
            ->where('vote_unit_id', $id->id)
            ->get();

        $total_vote =  DB::table('votings')
            ->select(DB::raw('count(*) as total_vote'))
            ->where('vote_item_id', '=', 2)
            ->first();

        $total_user_vote = DB::table('votings')->count('*');

        $user_vote = DB::table('votings')
            ->select('user_vote')
            ->get();

        // dd($total_user_vote);

        return view('pollSurvey', [
            "title" => "Poll Survey",
            "polling_unit" => $polling_unit,
            "polling_item" => $polling_item,
            "total_user_vote" => $total_user_vote,
            "total_vote" => $total_vote,
            "user_vote" => $user_vote,
        ]);
    }


    public function set_polling_survey(Request $request)
    {

        // dd($request->all());

        $validatedData = $request->validate([
            'response' => 'required',
            'user_vote' => 'required',
            'vote_unit_id' => 'required',
            'vote_item_id' => 'required',
        ]);

        VoteItem::where('id', $validatedData['vote_item_id'])
            ->update(['response' => $validatedData['response']]);

        $save = Voting::create($validatedData);

        if ($save) {

            return back()->with('success', 'Your vote has been saved!');
        } else {

            return back()->with('error', 'Your vote failed saved!')->withInput();
        }
    }

    public function result(VoteUnit $vote_unit)
    {

        // Ambil semua data total vote item yang vote unit id nya sesuai dengan vote unit id dan berelasi dengan tabel voting
        $total_votings = VoteItem::with(['votings'])
            ->where('vote_unit_id', $vote_unit->id)
            ->get();

        // dd($total_votings);

        // Ambil data vote unit yang id nya sesuai dengan vote unit id
        $vote_unit = DB::table('vote_units')
            ->where('id', $vote_unit->id)
            ->first();

        // Hitung jumlah total user yang melakukan voting
        $total_user_vote = DB::table('votings')
            ->where('vote_unit_id', $vote_unit->id)
            ->count('*');

        // dd($total_user_vote);

        // Hitung semua jumlah data yang ada di vote item yang vote unit id nya sama dengan id vote unit
        $total_vote_item = DB::table('vote_items')
            ->where('vote_unit_id', $vote_unit->id)
            ->count('*');

        // dd($total_vote_item);

        return view('result', [
            "title" => "Polling Result",
            "total_votings" => $total_votings,
            "vote_unit" => $vote_unit,
            "total_user_vote" => $total_user_vote,
            "total_vote_item" => $total_vote_item
        ]);
    }

    public function get_polling_json()
    {

        $data_vote_unit_json = DB::table('vote_items')->get();

        return json_decode($data_vote_unit_json);
    }

    public function edit(VoteUnit $id)
    {

        return view('polling.editPolling', [
            "title" => "Edit Polling Unit",
            "vote_unit" => $id
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'slug'  => 'required',
            'subtitle' => 'required',
        ]);


        // cek validasi jika ada thumbnail yang di kirim
        if ($request->file('thumbnail')) {
            // insert data thumbnail baru
            $validatedData['thumbnail'] = $request->file('thumbnail')->store('unit-items');
            // hapus data thumbnail sebelumnya
            Storage::delete($request->thumbnail_old);
        } else {
            $validatedData['thumbnail'] = $request->thumbnail_old;
        }

        // cek validasi date start
        if ($request->date_start) {
            // insert data date start baru
            $validatedData['date_start'] = date('U', strtotime($request->date_start));
        }

        // cek validasi date end
        if ($request->date_end) {
            // insert data date end baru
            $validatedData['date_end'] = date('U', strtotime($request->date_end));
        }

        $validatedData['description'] = $request->description;

        // simpan validasi kedalam database vote unit
        $save = VoteUnit::where('id', $request->id)->update($validatedData);

        if ($save) {

            return redirect('admin/editPolling/' . $validatedData['slug'])->with('success', 'Your data has been updated!');
        } else {

            return redirect('admin/editPolling/' . $validatedData['slug'])->with('error', 'Your data failed updated!')->withInput();
        }
    }

    public function close_polling(Request $request)
    {
        // Request Validate Id Item
        $validatedData = $request->validate([
            'id' => 'required',
            'date_end' => 'required',
        ]);

        $validatedData['date_end'] = date('U', strtotime($request->date_end));

        $closed = VoteUnit::where('id', $request->id)->update($validatedData);

        if ($closed) {

            return back()->with('message', 'Your data has been closed!');
        } else {

            return back()->with('message', 'Your data failed closed!');
        }
    }

    public function delete(Request $request)
    {
        // Request Validate Id Item
        $request->validate([
            'id' => 'required'
        ]);
        //Delete thumbnail Vote Unit
        $voteUnit = VoteUnit::where('id', $request->id)->first();
        Storage::delete($voteUnit->thumbnail);

        // Delete Vote Item By Vote Unit Id
        VoteItem::where('vote_unit_id', $request->id)->delete();
        // Delete Vote Profile By Vote Item Id
        VoteProfile::where('vote_item_id', $request->id)->delete();
        // Delete Vote Unit By Vote Unit Id
        $delete = VoteUnit::where('id', $request->id)->delete();

        if ($delete) {
            return back()->with('message', 'Your data has been deleted!');
        } else {

            return back()->with('message', 'Your data failed deleted!')->withInput();
        }
    }

    public function createSlug(Request $request)
    {
        $slug =  SlugService::createSlug(VoteUnit::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }

    public function voters(VoteUnit $voteUnit)
    {
        $voters = Voting::with(['user', 'voteitem'])->where('vote_unit_id', $voteUnit->id)->get();
        return view('viewVoters', [
            'title'     => 'Voters ' . $voteUnit->title,
            'voteUnit'  => $voteUnit,
            'voters'    => $voters
        ]);
    }
}
