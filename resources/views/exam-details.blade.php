@extends('layouts.app')

@section('content')
<div class="main-wrapper">
  <div class="container">
  	<div class="card">
  		<div class="card-body">

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
        <input type="text" class="d-none" id="examID" value="{{$exam->exam_id}}">
        <div class="d-flex justify-content-between">
          <h3 class="m-0">Exam Title: {{$exam->exam_title}}</h3>
          <a href="{{url('/home')}}" class="btn text-primary text-uppercase p-0"><i class="fa fa-arrow-left fa-fw"></i> Back</a>
        </div>
        <p class="mt-2">Number of Items: {{count($exam->questions)}}</p>
        <a href="{{url('/questions/new')}}" class="btn btn-primary" data-toggle="modal" data-target="#createQuestionModal">Add a question</a>

        @foreach($questions as $index => $question) <!-- Loop question collection to get choices -->
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
            <div class="alert alert-warning my-2">
            <i class="fa fa-exclamation-triangle"></i> There are question/s that has less than two choices. Check Question number/s 
            @foreach($questionLessThan2_keys as $key => $questionNumber)
              @if (($key+1) > 1)
              ,
              @endif
              {{$questionNumber+1}}
            @endforeach
            </div>
            <!-- {{--@else--}} -->
              <!-- <br> All questions have two or more choices -->
          @endif
        @endif

        @if(count($num_answers_holder_array) != 0)
          @if (in_array(0, $num_answers_holder_array, true)) <!-- confirm if all questions have only 1 answer -->
            @php $questionsNoAnswer_keys = array_keys($num_answers_holder_array,'0') @endphp
            <div class="alert alert-warning my-2">
            <i class="fa fa-exclamation-triangle"></i> There are question/s that does not have a correct answer. Check Question number/s 
            @foreach($questionsNoAnswer_keys as $key => $questionNumber)
              @if (($key+1) > 1)
              ,
              @endif
              {{$questionNumber+1}}
            @endforeach
            </div>
            <!-- {{--@else--}} -->
          <!-- <br> All questions have an answer -->
          @endif
        @endif


        @if(count($exam->questions) == 0)
        <div class="alert alert-warning my-3">
          <p class="m-0"><i class="fa fa-exclamation-triangle mr-1"></i>This exam will not be published unless each question contains atleast two corresponding choices and an answer.</p>
        </div>
        @elseif(count($exam->questions) > 0)
        <div class="table-wrap">
        <table class="table mt-4">
          <thead>
            <tr>
              <!-- <th scope="col" data-title="Question ID">Question ID</th> -->
              <th scope="col" data-title="Question Text">Question Text</th>
              <th scope="col" data-title="Action">Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($questions as $question)
            <tr>
              <!-- {{-- <td>{{$question->question_id}}</td> --}} -->
              <td><strong><a href="{{url('/exams/'.$exam->exam_id.'/questions/'.$question->question_id.'/manage')}}" class="text-dark">{{$question->question_text}}</a></strong></td>
              <td>
                <div class="hide-mobile show-desktop">
                  <div class="dropdown">
                    <button class="ellipsis-btn rounded-circle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h fa-fw"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a href="#" class="dropdown-item editQuestionBtn" data-toggle="modal" data-target="#editQuestionModal" data-id="{{$question->question_id}}" data-text="{{$question->question_text}}">Edit</a>
                      <a href="{{url('/exams/'.$exam->exam_id.'/questions/'.$question->question_id.'/manage')}}" class="dropdown-item manageQuestionBtn">Manage</a>
                      <a href="#" class="dropdown-item deleteQuestionBtn" data-toggle="modal" data-target="#deleteQuestionModal" data-id="{{$question->question_id}}">Delete</a>
                    </div>
                  </div>
                </div>
                <div class="show-mobile hide-desktop">
                  <div class="dropdown">
                    <button class="btn mobile-select-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select action
                    </button>
                    <div class="dropdown-menu">
                      <a href="#" class="dropdown-item editQuestionBtn" data-toggle="modal" data-target="#editQuestionModal" data-id="{{$question->question_id}}" data-text="{{$question->question_text}}">Edit</a>
                      <a href="{{url('/exams/'.$exam->exam_id.'/questions/'.$question->question_id.'/manage')}}" class="dropdown-item manageQuestionBtn">Manage</a>
                      <a href="#" class="dropdown-item deleteQuestionBtn" data-toggle="modal" data-target="#deleteQuestionModal" data-id="{{$question->question_id}}">Delete</a>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach

            
            
          </tbody>
        </table>
        </div>
        @endif

      @endforeach
        <div class="mt-3 d-flex justify-content-end text-right">
          {{$questions->links()}}
        </div>
  		</div>
      
  	</div>
	</div>
</div>

<!-- create question modal -->
<div class="modal" id="createQuestionModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Add a question</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form method="post" action="{{url ('/exams/'.$exam->exam_id.'/questions/new')}}">
      {{csrf_field()}}

      <div class="modal-body">
            @include('includes.question-form')
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

      </form>

    </div>
  </div>
</div>

<!-- edit question modal -->
<div class="modal" id="editQuestionModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Edit Question</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="editQuestionForm" method="post">
      {{csrf_field()}}

      <div class="modal-body">
            @include('includes.question-form')
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

      </form>

    </div>
  </div>
</div>

<!-- delete question modal -->
<div class="modal" id="deleteQuestionModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Confirm Deletion</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="deleteQuestionForm" method="post">
      {{csrf_field()}}

      <div class="modal-body">
            <p>Do you really want to delete this question item?</p>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Delete</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

      </form>

    </div>
  </div>
</div>

@endsection

@section('load-custom-js')
<script type="text/javascript">
  var examID = $("#examID").val();
    $( document ).ready(function() {
        var rootURL = $("#rootURL").text();
        $('#editQuestionModal').on('show.bs.modal', function (event) {
          var buttonClicked = $(event.relatedTarget);
          var questionID = buttonClicked.data('id');
          var questionText = buttonClicked.data('text');
          var modal = $(this);
          modal.find('input[name="question-text"]').val(questionText);
          $("#editQuestionForm").attr("action",rootURL+"/exams/"+examID+"/questions/"+questionID+"/update");
        });
        $('#deleteQuestionModal').on('show.bs.modal', function (event) {
          var buttonClicked = $(event.relatedTarget);
          var questionID = buttonClicked.data('id');
          $("#deleteQuestionForm").attr("action",rootURL+"/exams/"+examID+"/questions/"+questionID+"/delete");
        });
    });
</script>
@endsection