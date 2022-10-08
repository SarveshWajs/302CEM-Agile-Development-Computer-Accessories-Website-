@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        设置代理级别
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<h3>添加代理级别</h3>
<div class="row parent-box">
	<div class="col-md-6">
		<div class="form-group">
			<input type="text" class="form-control" name="agent_level" placeholder="级别名称 (例: 经销商)">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="row">
			<div class="col-md-6" align="center">
				<a href="#" class="add-shipping-btn" id="add-west">
					<i class="fa fa-plus"></i>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<button class="btn btn-primary">
			<i class="fa fa-check"> 保存</i>
		</button>

	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var m = '<div class="form-group">\
				<input type="text" class="form-control" name="agent_level" placeholder="级别名称 (例: 经销商)">\
			</div>';
	$('.add-shipping-btn').click( function(e){
		e.preventDefault();
		$('.parent-box.row .col-md-6').append(m);
	})
</script>
@endsection