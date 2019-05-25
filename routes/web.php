<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    //Student routes
    Route::get('students', 'StudentController@listing')->name('students');
    Route::get('students/show/{id}', 'StudentController@show');
    Route::delete('students/delete/{id}', 'StudentController@delete');
    Route::post('students/add', 'StudentController@add')->name('student.add');
    Route::put('students/save/{id}', 'StudentController@save');

    //Lecture routes
    Route::delete('lectures/delete/{id}', 'LectureController@delete');
    Route::get('lectures', 'LectureController@listing')->name('lectures');
    Route::get('lectures/show/{id}', 'LectureController@show');
    Route::post('lectures/{id}/add/grade', 'LectureController@addGrade');
    Route::post('lectures/add', 'LectureController@add')->name('lecture.add');
    Route::put('lectures/save/{id}', 'LectureController@save');

    //Grade routes
    Route::get('lectures/delete/grade/{id}', 'GradeController@delete');
    Route::put('lectures/save/grade/{id}', 'GradeController@save');
});

//Auth routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');




