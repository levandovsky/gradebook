<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Lecture;
use App\Grade;
use Illuminate\View\View;

class LectureController extends Controller
{
    public function listing(Request $request) {
        $filter = $request->input('find-lecture', session()->get('lecture-set',''));
        session()->put('lecture-set', $filter);

        $lectures = Lecture::with('grade')->when($filter, function ($q) use ($filter) {
            $q->where('name','LIKE',"%$filter%");
        })->orderBy('name')->paginate(config('pagination.paginator.books'));
        return view('lectures.listing', compact('lectures', 'filter'));
    }

    public function show($id) {
        $lecture = Lecture::with('grade')->findOrFail($id);
        $excluded = new Collection();
        foreach ($lecture->grade as $grade) {
            $excluded->push($grade->student_id);
        }
//        $students = Student::all()->diff(Student::all()->whereIn('id',$excluded));
        $students = Student::all();
        return view('lectures.single-lecture', compact('lecture'), compact('students'));
    }

    public function delete($id) {
        $lecture = Lecture::all()->find($id);
        if ($lecture) {
            Lecture::destroy($id);
            return redirect('lectures');
        } else {
            return 'error';
        }
    }

    public function addGrade($id, Request $request) {
        $added = new Grade;
        $student_id = $request->input('student_id');
        $grade = $request->input('grade');

        $validator = Validator::make(
            [
                'student_id' => $student_id,
                'lecture_id' => $id
            ],
            [
                'student_id' => 'required|string',
                'lecture_id' => 'string',
            ]
        );

        if ($validator->validated()) {
            $added->student_id = $student_id;
            $added->lecture_id = $id;
            $added->grade = $grade;
            $added->save();

            return redirect()->back();
        } else {
            return 'error';
        }
    }

    public function save($id, Request $request) {
        $lecture = Lecture::all()->find($id);
        $name = $request->input('name');
        $description = $request->input('description');
        if ($lecture) {
            $validator = Validator::make([
                'name' => $name,
                'description' => $description
            ],[
                'name' => 'required | string',
                'description' => 'string'
            ]);
            if ($validator->validated()) {
                $lecture->name = $name;
                $lecture->description = $description;
                $lecture->save();
                return redirect()->back();
            }

        }
    }

    public function add(Request $request) {
        $lecture = new Lecture();

        $name = $request->input('name');
        $description = $request->input('description');

        $validator = Validator::make(
            [
                'name' => $name,
                'description' => $description
            ],
            [
                'name' => 'required',
                'description' => 'required',
            ]
        );

        if ($validator->validated()) {
            $lecture->name = $name;
            $lecture->description = $description;
            $lecture->save();

            return redirect()->route('lectures');
        }
    }
}
