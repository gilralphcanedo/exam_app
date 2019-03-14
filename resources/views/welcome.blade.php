@extends('layouts.app')

@section('content')
<header class="hero-banner bg-holder vh--100-55" style="background-image: url('{{asset('img/home-banner.png')}}');">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 text-center text-white centered-text-wrapper">
            <h1 class="hero-text">Examinations just a click away</h1>
            <p class="hero-desc lead">ExamApp is a platform that allows instructors to create online exams where anyone can take and test their knowledge.</p>
            <div class="mt-4">
                <a href="{{url('/register')}}" class="btn btn-primary mx-1">Make an Exam</a>
                <a href="{{url('/exams')}}" class="btn btn-secondary mx-1">Take an Exam</a>
            </div>
          </div>
        </div>
    </div>
</header>
@endsection