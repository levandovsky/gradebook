<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Student;

class Lecture extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description'
    ];


    public function grade() {
        return $this->hasMany(Grade::class);
    }
}
