@php $countAnswer = 0; @endphp
@foreach($choices as $choice)
	@if($choice->correct == "true")
		@php $countAnswer++; @endphp
	@endif
@endforeach
<span id="n-ans" class="d-none">{{$countAnswer}}</span>
<div class="form-group">
  <label>Choice Text <small><span class="text-danger">*</span></small></label>
  @if ($errors->has('choice-text'))
  <input type="text" name="choice-text" class="form-control form-control-required border-danger" required>
    <div class="error text-danger opacity-0 opacity-1"><small>{{ $errors->first('choice-text','This field is required.') }}</small></div>
  @else
  <input type="text" name="choice-text" class="form-control form-control-required" required>
  @endif

</div>
<div class="form-group">
  <label>Is this an answer?</label>
  <div class="d-block">
  	<div class="form-check">
  	  <label class="form-check-label" 
  	  @if ($countAnswer == '1')
  	  data-toggle="tooltip" title="You already have an answer"
  	  @endif>
  	    <input id="answer-checkbox" type="checkbox" class="form-check-input" value="false" name="choice-answer[]" {{$countAnswer == '1' ? 'disabled' : ''}}>Yes
  	  </label>
  	</div>
  </div>
</div>
@php $countAnswer = 0; @endphp <!-- reset -->