@extends('layouts.app')

@section('content')
<div class="main-wrapper">
  <div class="container">

  	<div class="card">
  		<div class="card-body">
  			

			@foreach($all as $exam)
			<div class="questions-tab-wrapper">
				<ul class="nav nav-tabs question-tabs d-none" id="myTab" role="tablist">
					@foreach($exam->questions as $index => $questions)
				  <li class="nav-item">
				    <a class="nav-link 
				    @if($index==0)
				    active
				    @elseif($index>0)
				    disabled
				    @endif" id="{{$questions->question_id}}-tab" data-toggle="tab" href="#qid-{{$questions->question_id}}" role="tab">{{$index+1}}</a>
				  </li>
				  @endforeach
				</ul>
			</div>

			<form method="post" action="{{url('/exams/'.$exam->exam_id.'/result')}}">
			{{csrf_field()}}
			<div class="tab-content" id="myTabContent">
				
				@foreach($exam->questions as $index => $questions)
			  <div class="tab-pane fade py-5 {{$index == 0 ? 'show active' : ''}}" id="qid-{{$questions->question_id}}" role="tabpanel">
			  	<div class="exam-question-container d-flex h-100 align-items-center ml-auto mr-auto">
						<div class="col-12 text-center">
							<h4><small class="mr-2">Q - {{($index+1)}}</small> {{$questions->question_text}}</h4>

							<div class="choice-wrapper my-5">  

								@foreach($questions->choices as $choices)
								<div class="form-check p-0 my-2">
								  <input class="form-check-input invisible radio_input_{{$choices->correct === 'true' ? '1101' : '1100'}}" id="radio{{$choices->choice_id}}" type="radio" name="radio-group{{$questions->question_id}}" value="{{$choices->choice_text}}">
								  <label class="form-check-label exam-choice-label" for="radio{{$choices->choice_id}}">{{$choices->choice_text}}</label>
								</div>
								@endforeach

							</div>
							
						</div>
					</div>

					<div class="text-right pr-4">
					@if($index >= 0 && $index < count($exam->questions))
						@if($index == (count($exam->questions)-1))
						<button class="btn btn-success text-white submit-exam">Submit</button>
						@else
						<a class="btn btn-primary text-white next-step">Next</a>
						@endif
					@endif
					</div>
			  	
				</div>
				@endforeach
			</div>
			</form>
			@endforeach

				

  		</div>
  	</div>

  </div>
</div>
@endsection