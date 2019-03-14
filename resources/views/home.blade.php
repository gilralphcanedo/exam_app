@extends('layouts.app')

@section('content')
<div class="main-wrapper">
    <div class="container">
        <div class="card">
            <div class="card-header">Hi, {{ Auth::user()->name }}! You have made {{$exams->total()}} exam/s so far!</div>
            <div class="card-body">
                <a href="{{url('/exams/new')}}" class="btn btn-primary" data-toggle="modal" data-target="#createExamModal">Create Exam</a>

                @if(count($exams) > 0)
                <div class="table-wrap">
                <table class="table mt-4">
                  <thead>
                    <tr>
                      <!-- <th scope="col" data-title="Exam ID">Exam ID</th> -->
                      <th scope="col" data-title="Exam Title">Exam Title</th>
                      <th scope="col" data-title="Description">Description</th>
                      <th scope="col" data-title="Action">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($exams as $exam)
                    <tr>
                      <!-- {{-- <td>{{$exam->exam_id}}</td> --}} -->
                      <td><a href="{{url('/exams/'.$exam->exam_id.'/view')}}" class="text-dark"><strong>{{$exam->exam_title}}</strong></a></td>
                      <td>{{$exam->exam_desc}}</td>
                      <td>
                        <div class="hide-mobile show-desktop">
                            <div class="dropdown">
                              <button class="ellipsis-btn rounded-circle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h fa-fw"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a href="{{url('/exams/'.$exam->exam_id.'/view')}}" class="dropdown-item">View</a>
                                <a href="#" class="dropdown-item editExamBtn" data-toggle="modal" data-target="#editExamModal" data-id="{{$exam->exam_id}}" data-title="{{$exam->exam_title}}" data-desc="{{$exam->exam_desc}}">Edit</a>
                                <a href="#" class="dropdown-item deleteExamBtn" data-toggle="modal" data-target="#deleteExamModal" data-id="{{$exam->exam_id}}">Delete</a>
                              </div>
                            </div>
                        </div>
                        <div class="show-mobile hide-desktop">
                          <div class="dropdown">
                            <button class="btn mobile-select-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select action
                            </button>
                            <div class="dropdown-menu">
                              <a href="{{url('/exams/'.$exam->exam_id.'/view')}}" class="dropdown-item">View</a>
                              <a href="#" class="dropdown-item editExamBtn" data-toggle="modal" data-target="#editExamModal" data-id="{{$exam->exam_id}}" data-title="{{$exam->exam_title}}" data-desc="{{$exam->exam_desc}}">Edit</a>
                              <a href="#" class="dropdown-item deleteExamBtn" data-toggle="modal" data-target="#deleteExamModal" data-id="{{$exam->exam_id}}">Delete</a>
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
                <div class="mt-3 d-flex justify-content-end text-right">
                  {{$exams->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- create exam modal -->
<div class="modal" id="createExamModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Create Exam</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form method="post" action="{{url ('exams/new')}}">
      {{csrf_field()}}

      <div class="modal-body">
            @include('includes.exam-form')
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

      </form>

    </div>
  </div>
</div>

<!-- edit exam modal -->
<div class="modal" id="editExamModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Edit Exam</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="editExamForm" method="post">
      {{csrf_field()}}

      <div class="modal-body">
            @include('includes.exam-form')
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

      </form>

    </div>
  </div>
</div>

<!-- delete exam modal -->
<div class="modal" id="deleteExamModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Confirm Deletion</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="deleteExamForm" method="post">
      {{csrf_field()}}

      <div class="modal-body">
            <p>Do you really want to delete this exam?</p>
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
    $( document ).ready(function() {
        var rootURL = $("#rootURL").text();
        $('#editExamModal').on('show.bs.modal', function (event) {
          var buttonClicked = $(event.relatedTarget);
          var examID = buttonClicked.data('id');
          var examTitle = buttonClicked.data('title');
          var examDesc = buttonClicked.data('desc');
          var modal = $(this);
          modal.find('input[name="exam-title"]').val(examTitle);
          modal.find('textarea[name="exam-desc"]').val(examDesc);
          $("#editExamForm").attr("action",rootURL+"/exams/"+examID+"/update");
        });
        $('#deleteExamModal').on('show.bs.modal', function (event) {
          var buttonClicked = $(event.relatedTarget);
          var examID = buttonClicked.data('id');
          $("#deleteExamForm").attr("action",rootURL+"/exams/"+examID+"/delete");
        });
    });
</script>
@endsection