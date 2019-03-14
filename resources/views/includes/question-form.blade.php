<div class="form-group">
  <label>Question Text <small><span class="text-danger">*</span></small></label>
  @if ($errors->has('question-text'))
  <input type="text" name="question-text" class="form-control form-control-required border-danger" placeholder="What's it going to be?" required>
  <div class="error text-danger opacity-0 opacity-1"><small>{{ $errors->first('question-text','This field is required.') }}</small></div>
  @else
  <input type="text" name="question-text" class="form-control form-control-required" placeholder="What's it going to be?" required>
  @endif

</div>