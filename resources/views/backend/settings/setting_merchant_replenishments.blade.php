@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        设置代理补货佣金
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<form method="POST" action="{{ route('save_setting_merchant_replenishments') }}" id="setting-merchant-form">
@csrf
<div class="row">
	<div class="col-sm-6 col-xs-12">
		<div class="form-group">
			<h3>代理直属佣金 (经销商)</h3>
			<div class="container-box">
				<label>首单佣金</label>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-2">
							@php
								$dl_f_comm_selected = isset($replenishment) ? $replenishment->dl_f_comm_type : '';
							@endphp
							<select class="form-control" name="dl_f_comm_type">
								<option {{ ($dl_f_comm_selected == 'Percentage') ? 'selected' : '' }} value="Percentage">百分比</option>
								<option {{ ($dl_f_comm_selected == 'Amount') ? 'selected' : '' }} value="Amount">价格</option>
							</select>
						</div>
						<div class="col-xs-10">
							<input type="text" name="dl_first_transaction_commission" class="form-control" placeholder="首单佣金" value="{{ isset($replenishment) ? $replenishment->dl_first_transaction_commission : '' }}">
						</div>
					</div>
				</div>
				<label>补货佣金</label>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-2">
							@php
								$dl_e_comm_selected = isset($replenishment) ? $replenishment->dl_e_comm_type : '';
							@endphp
							<select class="form-control" name="dl_e_comm_type">
								<option {{ ($dl_e_comm_selected == 'Percentage') ? 'selected' : '' }} value="Percentage">百分比</option>
								<option {{ ($dl_e_comm_selected == 'Amount') ? 'selected' : '' }} value="Amount">价格</option>
							</select>
						</div>
						<div class="col-xs-10">
							<input type="text" name="dl_every_transaction_commision" class="form-control" placeholder="补货佣金" value="{{ isset($replenishment) ? $replenishment->dl_every_transaction_commision : '' }}">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6 col-xs-12">
		<div class="form-group">
			<h3>代理直属佣金 (服务商)</h3>
			<div class="container-box">
				<label>首单佣金</label>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-2">
							@php
								$sp_f_comm_selected = isset($replenishment) ? $replenishment->sp_f_comm_type : '';
							@endphp
							<select class="form-control" name="sp_f_comm_type">
								<option {{ (!empty($select) && $select->type == 'Percentage') ? 'selected' : '' }} value="Percentage">百分比</option>
								<option {{ (!empty($select) && $select->type == 'Amount') ? 'selected' : '' }} value="Amount">价格</option>
							</select>
						</div>
						<div class="col-xs-10">
							<input type="text" name="sp_first_transaction_commission" class="form-control" placeholder="首单佣金" value="{{ isset($replenishment) ? $replenishment->sp_first_transaction_commission : '' }}">
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>补货佣金</label>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-2">
								@php
									$sp_e_comm_selected = isset($replenishment) ? $replenishment->sp_e_comm_type : '';
								@endphp
								<select class="form-control" name="sp_e_comm_type">
									<option {{ ($sp_e_comm_selected == 'Percentage') ? 'selected' : '' }} value="Percentage">百分比</option>
									<option {{ ($sp_e_comm_selected == 'Amount') ? 'selected' : '' }} value="Amount">价格</option>
								</select>
							</div>
							<div class="col-xs-10">
								<input type="text" name="sp_every_transaction_commision" class="form-control" placeholder="补货佣金" value="{{ isset($replenishment) ? $replenishment->sp_every_transaction_commision : '' }}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<a href="{{ route('product.products.index') }}" class="btn btn-default">
			<i class="fa fa-ban"> 取消</i>
		</a>

		<button class="btn btn-primary">
			<i class="fa fa-check"> 保存</i>
		</button>

	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();
    	
    	$('#setting-merchant-form').submit();
    });
</script>
@endsection