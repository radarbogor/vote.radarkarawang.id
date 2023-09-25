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

class pollingItemController extends Controller
{
    public function create(VoteUnit $VoteUnit)
    {

        // Ambil semua data vote item dri query unit
        $voteItems = VoteItem::where('vote_unit_id', $VoteUnit->id)->get();
        $allVoteItem = VoteItem::all();


        return view('polling-item.addPollingItem', [
            "title" => "Add Polling Item",
            "voteUnit" => $VoteUnit,
            "voteItems" => $voteItems,
            "allVoteItem" => $allVoteItem
        ]);
    }


    public function createItem(Request $request)
    {
        // Buat rule validasi form input unit
        $validated = $request->validate([
            'vote_unit_id' => 'required',
            'vote_image' => 'required|image|file',
            'vote_name' => 'required',
            'vote_position' => 'required',
            'slug' => 'required',
        ]);

        // Cek jika ada gambar yang di inputkan dan simpan kedalam folder storage
        if ($request->hasfile('vote_image')) {
            $validated['vote_image'] = $request->file('vote_image')->store('vote-items');
        }

        // Validate form vote unit
        $validated['description'] = $request->description;

        if ($request->premium_profile) {
            $validated['premium_profile'] = 1;
        } else {
            $validated['premium_profile'] = 0;
        }

        // Validate form vote unit
        $validated['vote_unit_id'] = $request->vote_unit_id;

        // dd($validated);

        $save = VoteItem::create($validated);

        if ($save) {

            return back()->with('success', 'Vote item has been created!');
        } else {

            return back()->with('error', 'Your data failed created!')->withInput();
        }
    }

    public function edit(VoteItem $voteItem)
    {

        return view('polling-item.editPollingItem', [
            "title" => "Edit Polling Item",
            "voteItem" => $voteItem
        ]);
    }

    public function update(Request $request)
    {

        $voteItem = VoteUnit::where('id', $request->idPolling)->select('slug')->first();

        $validatedData = $request->validate([
            'vote_name' => 'required',
            'slug'  => 'required',
            'vote_position' => 'required',
        ]);


        // cek validasi jika ada thumbnail yang di kirim
        if ($request->file('vote_image')) {
            // insert data vote_image baru
            $validatedData['vote_image'] = $request->file('vote_image')->store('unit-items');
            // hapus data vote_image sebelumnya
            Storage::delete($request->vote_image_old);
        } else {
            $validatedData['vote_image'] = $request->vote_image_old;
        }

        if ($request->premium_profile == 1) {
            $validatedData['premium_profile'] = 1;
        } else {
            $validatedData['premium_profile'] = 0;
        }

        $validatedData['description'] = $request->description;

        // simpan validasi kedalam database vote unit
        $save = VoteItem::where('id', $request->id)->update($validatedData);

        if ($save) {

            return redirect('admin/add-polling-item/' . $voteItem->slug)->with('success', 'Your data has been updated!');
        } else {

            return redirect('admin/add-polling-item/' . $voteItem->slug)->with('error', 'Your data failed updated!')->withInput();
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        // Delete file image Vote Item By Vote Unit Id
        $voteItem = VoteItem::where('id', $request->id)->first();
        Storage::delete($voteItem->vote_image);

        // Delete Vote Item By Vote Unit Id
        $delete = VoteItem::where('id', $request->id)->delete();

        if ($delete) {
            return back()->with('success', 'Your data has been deleted!');
        } else {

            return back()->with('success', 'Your data failed deleted!')->withInput();
        }
    }

    public function updateMoreProfileItem(Request $request)
    {
        $profileId = $request->profileId;
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        VoteProfile::where('id', $profileId)->update($validatedData);

        return redirect(request()->header('Referer'))->with('success', 'Your data has been updated!');
    }

    public function deleteMoreProfileItem(Request $request)
    {
        $profileId = $request->profile_id;
        $VoteProfile = VoteProfile::where('id', $profileId)->first();

        Storage::delete($VoteProfile->icon);
        VoteProfile::where('id', $profileId)->delete();

        return redirect(request()->header('Referer'))->with('success', 'Your data has been deleted!');
    }

    public function createSlug(Request $request)
    {
        $slug =  SlugService::createSlug(VoteItem::class, 'slug', $request->vote_name);
        return response()->json(['slug' => $slug]);
    }
}
