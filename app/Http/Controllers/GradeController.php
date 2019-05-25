<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grade;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    public function delete($id) {
        $grade = Grade::all()->find($id);
        if ($grade) {
            Grade::destroy($id);
            return redirect()->back();
        }
    }

    public function save($id, Request $request) {
        $grade = Grade::all()->find($id);
        $student_id = $request->input('passed_student_id');
        $lecture_id = $request->input('passed_lecture_id');
        $passed_grade = $request->input('passed_grade');
        if ($grade) {
            $validator = Validator::make([
                'student_id' => $student_id,
                'lecture_id' => $lecture_id,
                'grade' => $passed_grade
            ],
                [
                    'student_id' => 'required',
                    'lecture_id' => 'required',
                    'grade' => 'required | numeric | min:1 | max:10'
                ]);

            if ($validator->validated()) {
                $grade->student_id = $student_id;
                $grade->lecture_id = $lecture_id;
                $grade->grade = $passed_grade;
                $grade->save();

                return redirect()->back();
            }
        }
    }
}
