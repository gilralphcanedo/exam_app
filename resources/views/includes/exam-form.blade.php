<div class="form-group">
  <label>Exam Title <small><span class="text-danger">*</span></small></label>
  @if ($errors->has('exam-title'))
  <input type="text" name="exam-title" class="form-control form-control-required border-danger" placeholder="What is this exam?" required>
  <div class="error text-danger opacity-0 opacity-1"><small>{{ $errors->first('exam-title','This field is required.') }}</small></div>
  @else
  <input type="text" name="exam-title" class="form-control form-control-required" placeholder="What is this exam?" required>
  @endif
</div>
<div class="form-group">
  <label>Exam Description <small><span class="text-danger">*</span></small></label>
  @if ($errors->has('exam-desc'))
  	<textarea name="exam-desc" class="form-control form-control-required border-danger" placeholder="Let us know something about the exam" rows="6" required></textarea>
    <div class="error text-danger opacity-0 opacity-1"><small>{{ $errors->first('exam-desc','This field is required.') }}</small></div>
  @else
  	<textarea name="exam-desc" class="form-control form-control-required" placeholder="Let us know something about the exam" rows="6" required></textarea>
  @endif
</div>