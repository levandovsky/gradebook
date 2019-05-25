<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Student;
//use App\Lecture;

class Grade extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'lectures_id',
        'grade'
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function lecture() {
        return $this->belongsTo(Lecture::class);
    }
}
