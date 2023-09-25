<?php

namespace App\Http\Livewire;

use App\Models\VoteProfile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class StoreProfileItems extends Component
{
    // Rules Input
    public $icon_profile;
    public $title_profile;
    public $desc_profile;
    public $gallery=[];

    public $data_id;
    public $data_vote_unit_id;
    public $data_image;
    public $data_item;

    use WithFileUploads;

    protected $listeners = ['profileAdded' => 'render'];

    protected $rules = [
                'gallery.*' => 'required|image|max:1024',
           ];

    private function resetInput(){
        $this->gallery = null;
    }


    public function mount($data_item){
        $this->data_id = $data_item->id;
        $this->data_vote_unit_id = $data_item->vote_unit_id;

    }

    public function removeUpload($index)
    {
            array_splice($this->gallery, $index, 1);
    }

    public function storeProfile(){

        $this->validate();

        foreach ($this->gallery as $key => $photo) {

            $this->gallery[$key] = $photo->store('gallery-items');

        }

        $this->gallery = json_encode($this->gallery);

        VoteProfile::create([
            'vote_item_id' => $this->data_id,
            'gallery' => $this->gallery,
        ]);



        $this->resetInput();

        $this->emit('profileAdded');

        return redirect(request()->header('Referer'))->with('success', 'Images has been successfully Uploaded.');
    }


    public function render()
    {
        $data_profile = VoteProfile::where('vote_item_id',$this->data_id)->get();
        return view('livewire.store-gallery',[
            'data_profile' => $data_profile
        ]);
    }

}
