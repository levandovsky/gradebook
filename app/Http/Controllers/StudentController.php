<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Student;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class StudentController extends Controller
{
    public function listing(Request $request)
    {
        $filter = $request->input('find-student', session()->get('student-set',''));
        session()->put('student-set', $filter);

        $students = Student::with('grade')->when($filter, function ($q) use ($filter) {
            $q->where('name','LIKE',"%$filter%");
        })->orderBy('name')->paginate(config('pagination.paginator.books'));
        return view('students.listing', compact('students', 'filter'));
    }

    public function show($id)
    {
        $student = Student::with('grade')->where('id', $id)->get();
        $student = $student[0];
        return view('students.single-student', compact('student'));
    }

    public function delete($id)
    {
        if (Student::findOrFail($id)) {
            Student::destroy($id);
            return redirect('students');
        } else {
            return 'error';
        }
    }

    public function add(Request $request)
    {
        $student = new Student;

        $name = $request->input('name');
        $lastname = $request->input('lastname');
        $phone = $request->input('phone');
        $email = $request->input('email');

        $validator = Validator::make(
            [
                'name' => $name,
                'lastname' => $lastname,
                'phone' => $phone,
                'email' => $email
            ],
            [
                'name' => 'required',
                'lastname' => 'required',
                'phone' => 'required | unique:students',
                'email' => 'required|email| unique:students'
            ]
        );

        if ($validator->validated()) {
            $student->name = Purify::clean($name);
            $student->lastname = Purify::clean($lastname);
            $student->phone = Purify::clean($phone);
            $student->email = Purify::clean($email);

            $student->save();
            return redirect()->route('students');
        }
    }

    public function save($id, Request $request)
    {
        $student = Student::findOrFail($id);

        $name = $request->input('name');
        $lastname = $request->input('lastname');
        $phone = $request->input('phone');
        $email = $request->input('email');


        $validator = Validator::make(
            [
                'name' => $name,
                'lastname' => $lastname,
                'phone' => $phone,
                'email' => $email
            ],
            [
                'name' => 'required',
                'lastname' => 'required',
                'phone' => "required|unique:students,phone,$id",
                'email' => "required|email|unique:students,email,$id"
            ]
        );

        if ($validator->validated()) {
            $student->name = Purify::clean($name);
            $student->lastname = Purify::clean($lastname);
            $student->phone = Purify::clean($phone);
            $student->email = Purify::clean($email);

            $student->save();
            return redirect()->back();
        }
    }

}
