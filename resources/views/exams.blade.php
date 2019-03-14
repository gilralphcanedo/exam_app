@extends('layouts.app')

@section('content')

<div class="main-wrapper all-exams">
	<div class="container">
		<div class="heading-search-wrapper">
			<h2 class="m-0">List of Exams</h2>
			<div class="input-group search-exam-input invisible">
			  <input type="text" class="form-control" placeholder="Search for an exam">
			  <div class="input-group-append">
			    <button class="btn btn-primary pt-1" type="button"><i class="fa fa-search"></i></button>
			  </div>
			</div>
		</div>
		<div class="mt-4">
			<ul class="list-group p-0">

        <!-- count_correct_answer = counter of choices that is an answer -->
        <!-- atleast_two_choices_holder_array = array holder for valid number of answers in question ( 1 if has > 2 choice, 0 if < 2 )-->
        <!-- question_holder_array = array holder for questions containing num of choices and num of answers -->
        <!-- isValid_exam = checker if questions of exam has atleast 2 choices -->
        @php
          $count_correct_answer = 0;
          $atleast_two_choices_holder_array = array();
          $num_answers_holder_array = array();
          $question_holder_array = array();
          $isValid_exam = 0;
        @endphp

        @foreach($exams as $exam)
          @foreach($exam->questions as $index => $question) <!-- Loop question collection to get choices -->
            @foreach($question->choices as $choices) <!-- Loop choices collection to check if questions has an answer -->
              @if($choices->correct == "true")
                @php $count_correct_answer++; @endphp <!-- increment $count_correct_answer if question has an answer -->
              @endif
            @endforeach
            @php
              $question_holder_array[] = array('num_of_choices'=>count($question->choices),'num_of_answers'=>$count_correct_answer);
              $count_correct_answer = 0;
            @endphp
            @if($question_holder_array[$index]['num_of_choices'] < 2) <!-- if question contains less than 2 choices return 0 (false) -->
              @php $atleast_two_choices_holder_array[] = 0; @endphp
            @else
              @php $atleast_two_choices_holder_array[] = 1; @endphp
            @endif

            @php
              $num_answers_holder_array[] = $question_holder_array[$index]['num_of_answers'];
            @endphp

          @endforeach

          @if(count($atleast_two_choices_holder_array) != 0)
            @if (in_array(0, $atleast_two_choices_holder_array, true))  <!-- confirm if all questions have atleast 2 choices -->
              @php $questionLessThan2_keys = array_keys($atleast_two_choices_holder_array,'0') @endphp
              @php $isValid_exam = 0; @endphp <!-- not valid  -->
            @else
              @php $isValid_exam = 1; @endphp <!-- valid -->
            @endif
          @endif

          @if(count($num_answers_holder_array) != 0)
            @if (in_array(0, $num_answers_holder_array, true)) <!-- confirm if all questions have only 1 answer -->
              @php $questionsNoAnswer_keys = array_keys($num_answers_holder_array,'0') @endphp
              @php $isValid_exam = 0; @endphp
            @else
              @php $isValid_exam = 1; @endphp
            @endif
          @endif

          @php
            unset($question_holder_array);
            $question_holder_array = array();
            unset($atleast_two_choices_holder_array);
            $atleast_two_choices_holder_array = array();
            unset($num_answers_holder_array);
            $num_answers_holder_array = array();
          @endphp

          @if(count($exam->questions) !=0 && $isValid_exam == 1)
            <li class="list-group-item">
              <div class="d-md-flex align-items-center justify-content-between">
                <p class="exams-title"><strong>{{$exam->exam_title}}<br><small>by {{$exam->users->name}}</small></strong></p>
                <span>
                  
                  <button class="btn btn-success" data-toggle="modal" data-target="#openExamModal" data-id="{{$exam->exam_id}}" data-title="{{$exam->exam_title}}" data-desc="{{$exam->exam_desc}}" data-numques="{{count($exam->questions)}}">Take Exam</button>
                </span>
              </div>
            </li>
          @endif

        @endforeach

			</ul>
		</div>
		<div class="mt-3 d-flex justify-content-end text-right">
			{{$exams->links()}}
		</div>
	</div>
</div>

<!-- open exam modal -->
<div class="modal" id="openExamModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="exam-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="start-exam-form">
      {{csrf_field()}}

      <div class="modal-body">
      	<p id="exam-desc">Are you ready for this exam?</p>
      	<p>Number of Questions: 
      		<span id="numOfQuestions">0</span>
      	</p>
      	<p>Click start whenever your ready. Goodluck!</p>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary px-4">Start</button>
      </div>

      </form>

    </div>
  </div>
</div>

@endsection

@section('load-custom-js')
<script type="text/javascript">
    $( document ).ready(function() {
      var rootURL = $("#rootURL").text();
      $('#openExamModal').on('show.bs.modal', function (event) {
        var buttonClicked = $(event.relatedTarget);
        var examID = buttonClicked.data('id');
        var examTitle = buttonClicked.data('title');
        var examDesc = buttonClicked.data('desc');
        var numques = buttonClicked.data('numques');
        $("#exam-title").html(examTitle);
        $("#exam-desc").html(examDesc);
        $("#numOfQuestions").html(numques);
        $("#start-exam-form").attr("action",rootURL+"/exams/"+examID+"/start");
      });
    });
</script>
@endsection