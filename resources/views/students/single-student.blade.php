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
                <a href="{{route('students')}}" class="btn btn-primary mb-2"><i class="fas fa-arrow-left"></i></a>
                <div class="card">
                    <div class="card-header">
                        {{ $student->name }} {{ $student->lastname }}
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Lecture</th>
                                <th>Grade</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($student->grade as $grade)
                                <tr>
                                    <td>{{ $grade->lecture->name }}</td>
                                    <td>{{ $grade->grade }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <form action="{{route('students')}}/delete/{{$student->id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger mb-2">Delete</button>
                        </form>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-success mb-2" data-toggle="modal" data-target="#editStudent">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editStudent" tabindex="-1" role="dialog" aria-labelledby="editStudentLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentLabel">Edit student info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="post" action="{{route('students')}}/save/{{$student->id}}">
                        @csrf
                        @method('PUT')
                        <input required type="text" name="name" class="form-control mb-2" placeholder="Name" value="{{ $student->name }}">
                        <input required type="text" name="lastname" class="form-control mb-2" placeholder="Lastname" value="{{$student->lastname}}">
                        <input required type="text" name="email" class="form-control mb-2" placeholder="email" value="{{ $student->email }}">
                        <input required type="number" name="phone" class="form-control mb-2" placeholder="phone" value="{{ $student->phone }}">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection