@extends('layouts.app')

@section('content')
<input type="text" class="d-none" id="examID" value="{{$exam->exam_id}}">
<input type="text" class="d-none" id="questionID" value="{{$question->question_id}}">
<div class="main-wrapper">
  <div class="container">
  	<div class="card">
  		<div class="card-body">
  			<div class="d-flex justify-content-between">
  				<h3 class="m-0">{{$question->question_text}}</h3>
  				<a href="{{url('/exams/'.$exam->exam_id.'/view')}}" class="btn text-primary text-uppercase p-0"><i class="fa fa-arrow-left fa-fw"></i> Back</a>
  			</div>
  			<p class="mt-2">Number of Choices: {{count($choices)}}</p>
        @if(count($choices) >= $max_num_choices)
        <p>You have reached the maximum number of choices.</p>
        @else
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createChoiceModal">Add a choice</a>
        @endif

        @if(count($choices) > 0)
        <div class="table-wrap">
        <table class="table choice-table mt-4">
          <thead>
            <tr>
              <th scope="col" data-title="Choice Item">Choice Item</th>
              <th scope="col" data-title="Action">Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($choices as $choice)
            <tr class="{{$choice->correct === 'true' ? 'border border-success' : ''}}">
              <td><strong>{{$choice->choice_text}}</strong></td>
              <td>
                <div class="hide-mobile show-desktop">
                  <div class="dropdown">
                    <button class="ellipsis-btn rounded-circle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h fa-fw"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a href="#" class="dropdown-item editChoiceBtn" data-toggle="modal" data-target="#editChoiceModal" data-id="{{$choice->choice_id}}" data-text="{{$choice->choice_text}}" data-answer="{{$choice->correct}}">Edit</a>
                      <a href="#" class="dropdown-item deleteChoiceBtn" data-toggle="modal" data-target="#deleteChoiceModal" data-id="{{$choice->choice_id}}">Delete</a>
                    </div>
                  </div>
                </div>
                <div class="show-mobile hide-desktop">
                  <div class="dropdown">
                    <button class="btn mobile-select-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select action
                    </button>
                    <div class="dropdown-menu">
                      <a href="#" class="dropdown-item editChoiceBtn" data-toggle="modal" data-target="#editChoiceModal" data-id="{{$choice->choice_id}}" data-text="{{$choice->choice_text}}" data-answer="{{$choice->correct}}">Edit</a>
                      <a href="#" class="dropdown-item deleteChoiceBtn" data-toggle="modal" data-target="#deleteChoiceModal" data-id="{{$choice->choice_id}}">Delete</a>
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

  		</div>
  	</div>
	</div>
</div>

<!-- create choice modal -->
<div class="modal" id="createChoiceModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Add a choice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form method="post" action="{{url ('/exams/'.$exam->exam_id.'/questions/'.$question->question_id.'/choices/new')}}">
      {{csrf_field()}}

      <div class="modal-body">
            @include('includes.choice-form')
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

      </form>

    </div>
  </div>
</div>

<!-- edit choice modal -->
<div class="modal" id="editChoiceModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Edit Question</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="editChoiceForm" method="post">
      {{csrf_field()}}

      <div class="modal-body">
            @include('includes.choice-form')
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

      </form>

    </div>
  </div>
</div>

<!-- delete choice modal -->
<div class="modal" id="deleteChoiceModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Confirm Deletion</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="deleteChoiceForm" method="post">
      {{csrf_field()}}

      <div class="modal-body">
            <p>Do you really want to delete this choice item?</p>
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
  $( "body" ).delegate( "#answer-checkbox", "change", function() {
    if(this.checked) {
       $(this).val('true');
    }
    else{
       $(this).val('false');
    }
  });

  var examID = $("#examID").val();
  var questionID = $("#questionID").val();
    $( document ).ready(function() {
        var rootURL = $("#rootURL").text();

        $('#editChoiceModal').on('show.bs.modal', function (event) {
          var buttonClicked = $(event.relatedTarget);
          var choiceID = buttonClicked.data('id');
          var choiceText = buttonClicked.data('text');
          var correct = buttonClicked.data('answer');
          var modal = $(this);
          modal.find('input[name="choice-text"]').val(choiceText);
          var checkbox = modal.find('input[id="answer-checkbox"]');
          checkbox.val(correct);
          if (checkbox.val() == "true") {
            checkbox.removeAttr('disabled');
            checkbox.parent().tooltip('disable');
            checkbox.prop('checked', true);
          }
          else if(checkbox.val() == "false"){
            if ($('#n-ans').text() == "1") {
              checkbox.attr('disabled',true);
              checkbox.parent().tooltip('enable');
            }
            checkbox.prop('checked', false);
          }
          $("#editChoiceForm").attr("action",rootURL+"/exams/"+examID+"/questions/"+questionID+"/choices/"+choiceID+"/update");
        });
        $('#deleteChoiceModal').on('show.bs.modal', function (event) {
          var buttonClicked = $(event.relatedTarget);
          var choiceID = buttonClicked.data('id');
          $("#deleteChoiceForm").attr("action",rootURL+"/exams/"+examID+"/questions/"+questionID+"/choices/"+choiceID+"/delete");
        });
    });
</script>
@endsection