<?php

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
});

// View All Exams
Route::get('/exams', 'ExamController@index');

// View Specific Exam
Route::get('/exams/{examID}/view', 'QuestionController@index');

// Exams CRUD
Route::post('/exams/new', 'ExamController@addExam');
Route::post('/exams/{examID}/update', 'ExamController@updateExam');
Route::post('/exams/{examID}/delete', 'ExamController@deleteExam');

// Questions CRUD
Route::post('/exams/{examID}/questions/new', 'QuestionController@addQuestion');
Route::post('/exams/{examID}/questions/{questionID}/update', 'QuestionController@updateQuestion');
Route::post('/exams/{examID}/questions/{questionID}/delete', 'QuestionController@deleteQuestion');

// Manage Question
Route::get('/exams/{examID}/questions/{questionID}/manage', 'ChoiceController@index');


// Choices CRUD
Route::post('/exams/{examID}/questions/{questionID}/choices/new', 'ChoiceController@addChoice');
Route::post('/exams/{examID}/questions/{questionID}/choices/{choiceID}/update', 'ChoiceController@updateChoice');
Route::post('/exams/{examID}/questions/{questionID}/choices/{choiceID}/delete', 'ChoiceController@deleteChoice');

// Start Exam Route
Route::get('/exams/{examID}/start', 'ExamController@startExam');

Route::post('/exams/{examID}/result', 'ExamController@processExam');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
