@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <a href="{{route('lectures')}}" class="btn btn-primary mb-2"><i class="fas fa-arrow-left"></i></a>
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center">
                        <span>{{$lecture->name}}</span>
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-info mb-2" data-toggle="modal"
                                    data-target="#editDescModal">
                                Description
                            </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" style="text-align: center;">
                            <thead>
                            <tr style="vertical-align: center">
                                <th>Name</th>
                                <th>Grade</th>
                                <th colspan="2">Functions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lecture->grade as $grade)
                                <tr>
                                    <td>{{ $grade->student->name }} {{ $grade->student->lastname }}</td>
                                    <td>{{ $grade->grade }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success mb-2" data-toggle="modal" data-target="#editGradeModal" onclick="getId({{$grade->student_id}}, {{$lecture->id}},{{$grade->id}},'{{$grade->student->name}}', '{{$grade->student->lastname}}', {{$grade->grade}})">
                                            Edit
                                        </button></td>
                                    <td>
                                        <a href="{{route('lectures')}}/delete/grade/{{$grade->id}}" class="btn btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-outline-success mb-2" data-toggle="modal"
                                data-target="#addStudentsModal">Add students
                        </button>
                    </div>
                    <div class="card-footer">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal"
                                data-target="#editNameModal">
                            Edit
                        </button>
                        <form action="{{ route('lectures') }}/delete/{{ $lecture->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mb-2">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="editNameModal" tabindex="-1" role="dialog" aria-labelledby="editNameModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNameModalLabel">Edit Lecture Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('lectures') }}/save/{{$lecture->id}}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" class="form-control mb-2" placeholder="Lecture title"
                               value="{{$lecture->name}}">
                        <textarea name="description" cols="30" rows="10">{!! $lecture->description !!}</textarea>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addStudentsModal" tabindex="-1" role="dialog" aria-labelledby="addStudentsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentsModalLabel">Add student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-inline" action="{{route('lectures')}}/{{$lecture->id}}/add/grade" method="post"
                          style="justify-content: space-between">
                        @csrf
                        <div class="form-controllers">
                            <select name="student_id" class="form-control mr-2">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{$student->name}} {{ $student->lastname }}</option>
                                @endforeach
                            </select>
                            <input type="number" min="1" max="10" class="form-control mr-2" placeholder="Grade"
                                   name="grade">
                        </div>
                        <button type="submit" class="btn btn-outline-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editDescModal" tabindex="-1" role="dialog" aria-labelledby="editDescModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDescModalLabel"><b>{{$lecture->name}}</b> description</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! $lecture->description !!}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-inline" style="justify-content: space-between" id="editGradeForm" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="hidden" id="passed_student_id" name="passed_student_id">
                            <input type="hidden" id="passed_lecture_id" name="passed_lecture_id">
                            <input type="hidden" id="passed_grade_id" name="passed_grade_id">
                            <input type="text"   id="passed_name"  class="form-control mr-2" readonly>
                            <input type="number" id="passed_grade" name="passed_grade" min="1" max="10" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-outline-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{asset('../resources/js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 300,
            menubar: false,
            resize: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help ',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });

        function getId(student_id,lecture_id,grade_id, name, lastname, grade) {
            document.getElementById('passed_student_id').value = student_id;
            document.getElementById('passed_lecture_id').value = lecture_id;
            document.getElementById('passed_name').value = name + ' ' + lastname;
            document.getElementById('passed_grade').value = grade;
            document.getElementById('editGradeForm').setAttribute('action', `{{route('lectures')}}`+ `/save/grade/${grade_id}`);
        }

    </script>﻿
@endsection

