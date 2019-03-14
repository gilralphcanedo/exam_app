@extends('layouts.app')

@section('content')
<div class="main-wrapper">
	<div class="container">
	  <div class="card">
	  	<div class="card-body">
	  		<div class="p-5 exam-question-container text-center mx-auto">
	  			<h2>You're Done!</h2>

	  			<div class="my-5">
	  				<h3>Result:</h3>
	  				<p class="lead my-3">{{$final_score}} of {{$total_num_items}}</p>
	  				<h3>{{$score_percentage}}%</h3>
	  				@if($score_percentage >= 80)
	  				<p>You can be proud of yourself!</p>
	  				@elseif($score_percentage >= 60)
	  				<p>Good job!</p>
	  				@elseif($score_percentage >= 40)
	  				<p>It's not that bad. Just a little bit further!</p>
	  				@elseif($score_percentage < 40)
	  				<p>You may have failed today, but not next time!</p>
	  				@endif
	  			</div>

	  			<a href="{{url('/exams')}}" class="btn btn-primary">Try other Exams</a>

	  		</div>
	  	</div>
	  </div>
	</div>
</div>
@endsection