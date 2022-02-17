<?php

namespace App\Models;

use App\Models\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public static function getLocationName($locationName){
        return Location::where('name', $locationName)->first();
    }
}
