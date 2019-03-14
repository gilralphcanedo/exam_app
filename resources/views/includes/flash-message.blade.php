@if ($errors->any())
  <div id="flash-alert" class="container fixed-top">
      <div class="alert alert-dismissible fade flash-notice alert-danger show" role="alert">
        <p id="flash-alert-text" class="m-0"><strong>Oops!</strong> Something's not right. Try again.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
  </div>
@else
	@if($flash = session('message'))
	<div id="flash-alert" class="container fixed-top">
	    <div class="alert alert-dismissible fade flash-notice alert-success show" role="alert">
	      <p id="flash-alert-text" class="m-0">{{$flash}}</p>
	      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	</div>
	@endif
@endif
