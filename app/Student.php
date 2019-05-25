<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Lecture;

class Student extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'email'
    ];

    public function grade() {
        return $this->hasMany(Grade::class);
    }
}
