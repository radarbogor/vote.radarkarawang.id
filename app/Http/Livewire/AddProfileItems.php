<?php

namespace App\Http\Livewire;

use App\Models\VoteItem;
use Livewire\Component;

class AddProfileItems extends Component
{
    public $title = 'Add More Profile';
    public $data_item;

    public $more_item_title;

    public function mount($slug){
        $this->data_item = VoteItem::with('voteUnit')->where('slug', $slug)->first();
    }

    public function render()
    {
        return view('livewire.add-gallery')
        ->extends('layouts.main')
        ->layoutData(['title' => 'More Profile']);
    }
}
