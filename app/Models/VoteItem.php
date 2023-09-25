<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteItem extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'vote_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vote_unit_id',
        'response',
        'vote_image',
        'vote_name',
        'slug',
        'vote_position',
        'description',
        'premium_profile'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'vote_name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function votings(){
        return $this->hasMany(Voting::class);
    }


    public function voteUnit(){
        return $this->hasMany(VoteUnit::class,'id','vote_unit_id');
    }

    public function voteProfile(){
        return $this->hasOne(VoteProfile::class,'vote_item_id','id');

    }

    public function voteProfiles(){
        return $this->hasMany(VoteProfile::class,'vote_item_id','id');
    }

}
