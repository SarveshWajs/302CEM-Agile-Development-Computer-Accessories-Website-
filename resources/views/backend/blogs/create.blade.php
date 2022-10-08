@extends('layouts.admin_app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" crossorigin="anonymous">
<style type="text/css">
    .bootstrap-tagsinput {
        width: 100%;
        padding-top: 0;
        padding-bottom: 0;
    }
    .bootstrap-tagsinput input{
        border: none !important;
    }
</style>
@section('content')
<div class="page-header">
    <h1>
        Create New Blog 
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
@if($errors->any())
  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
@endif
<form method="POST" action="{{ route('blog.blogs.store') }}" id="brands-form"  enctype="multipart/form-data">
@csrf
@include('backend.blogs.form')
</form>

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<a href="{{ route('blog.blogs.index') }}" class="btn btn-default">
			<i class="fa fa-ban"> CANCEL</i>
		</a>

		<button class="btn btn-primary">
			<i class="fa fa-check"> CREATE</i>
		</button>

	</div>
</div>

@endsection

@section('js')
<script type="text/javascript">
	$('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();
    	
    	$('#brands-form').submit();
    });

    var descriptionUrl = '{{ route("CKEditorUploadImage", ["_token" => csrf_token(), "p_id"=> ":p_id", "type" => "1" ]) }}';

    var description = CKEDITOR.instances["description"];
        descriptionUrl = descriptionUrl.replace(':p_id', '1');

    if(!description){
        CKEDITOR.replace( 'description',{
            filebrowserUploadUrl: descriptionUrl,
            filebrowserUploadMethod: 'form'
        });
    }
</script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>
@endsection