<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VoteUnit extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'thumbnail',
        'title',
        'slug',
        'description',
        'date_start',
        'date_end',
        'subtitle'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function vote_items(){
       return $this->hasMany(VoteItem::class);
    // return $this->hasMany(VoteItem::class,'vote_unit_id','id');
    }

    public function votings(){
        // return $this->hasOneThrough(Voting::class,User::class,'id','user_vote')->ofMany('id');
        if(Auth::user()){
            return $this->hasOne(Voting::class)->where('user_vote',Auth::user()->id);
        }else{
            return $this->hasOne(Voting::class);
        }
    }

}
