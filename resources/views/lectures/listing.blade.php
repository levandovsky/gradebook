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
                                data-target="#lectureModal">
                            Add Lecture
                        </button>
                    </div>
                    <div class="right">
                    <form method="get" action="{{route('lectures')}}" class="search d-flex justify-content-between">
                        @csrf
                        <input type="text" name="find-lecture" class="form-control mr-2" value="{{$filter}}">
                        <button type="submit" class="btn btn-outline-success">Search</button>
                    </form>
                    </div>
                </div>
                <table class="table table-bordered table-striped bg-white">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Nr. of students</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lectures as $lecture)
                        <tr>
                            <td>
                                <a href="{{ route('lectures') }}/show/{{ $lecture->id }}"> {{ $lecture->name }}</a>
                            </td>
                            <td>{{count($lecture->grade)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$lectures->links()}}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="lectureModal" tabindex="-1" role="dialog" aria-labelledby="lectureModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lectureModalLabel">Add New Lecture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('lecture.add')}}">
                        @csrf
                        <div class="form-group">
                            <input required type="text" name="name" class="form-control mb-2" placeholder="Title">
                            <textarea name="description" cols="30" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
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
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    </script>﻿
@endsection