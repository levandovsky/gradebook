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
                <div class="header-control d-flex justify-content-between">
                    <div class="left">
                        <a href="{{route('welcome')}}" class="btn btn-primary mb-2"><i
                                    class="fas fa-arrow-left"></i></a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-primary mb-2" data-toggle="modal"
                                data-target="#studentModal">
                            Add Student
                        </button>
                    </div>
                    <div class="right">
                    <form action="{{route('students')}}" method="get" class="search d-flex justify-content-between">
                        @csrf
                        <input type="text" name="find-student" class="form-control mr-2" value="{{$filter}}">
                        <button type="submit" class="btn btn-outline-success">Search</button>
                    </form>
                    </div>
                </div>
                <table class="table table-bordered table-striped bg-white">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Nr. of grades</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                <a href="{{ route('students') }}/show/{{ $student->id }}"> {{ $student->name }} {{ $student->lastname }}</a>
                            </td>
                            <td>{{count($student->grade)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$students->links()}}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Add student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('student.add') }}">
                        @csrf
                        <input required type="text" name="name" class="form-control mb-2" placeholder="Name">
                        <input required type="text" name="lastname" class="form-control mb-2" placeholder="Lastname">
                        <input required type="text" name="email" class="form-control mb-2" placeholder="email">
                        <input required type="number" name="phone" class="form-control mb-2" placeholder="phone">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection