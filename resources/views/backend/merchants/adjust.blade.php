@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        {{ $merchant->f_name }}
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
           	Adjust Product Wallet
        </small>
    </h1>
</div>
<div class="form-group">
	<span class="badge badge-pill badge-primary">Product Wallet Balance: {{ $GetProductWalletBalance }}</span>
</div>
<form method="POST" action="{{ route('adjust', $merchant->id) }}">
	@csrf
	@if($errors->any())
	  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
	@endif
	<div class="row">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-3">
					<select class="form-control" name="adjust_type">
						<option {{ (old('type') == '1') ? 'selected' : '' }} value="1">Increase</option>
						<option {{ (old('type') == '2') ? 'selected' : '' }} value="2">Decrease</option>
					</select>
				</div>
				<div class="col-sm-9">
					<div class="form-group">
						<input type="text" class="form-control" name="adjust_amount" placeholder="Amount" onkeypress="return isNumberKey(event)"
							   value="{{ old('quantity') }}">
					</div>
				</div>
			</div>

			<div class="form-group">
				<textarea class="form-control" name="remark" placeholder="Remark (Optional)">{{ old('remark') }}</textarea>
			</div>
		</div>
	</div>
	<div class="submit-form-btn">
		<div class="form-group wizard-actions" align="right">
			<a href="{{ route('merchant.merchants.index') }}" class="btn btn-default">
				<i class="fa fa-ban"> CANCEL</i>
			</a>

			<button class="btn btn-primary">
				<i class="fa fa-check"> CREATE</i>
			</button>

		</div>
	</div>
</form>
<hr />
<h4>Adjustment History List</h4>
<div class="row">
	<div class="col-sm-12">
		<form method="GET" action="{{ route('adjust', $merchant->id) }}">
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<div class="form-group">
							<select class="form-control" name="type">
								<option value="">Select Type</option>
								<option {{ (!empty(request('type')) && request('type') == '1') ? 'selected' : '' }} value="1">
									Increase
								</option>
								<option {{ (!empty(request('type')) && request('type') == '2') ? 'selected' : '' }} value="2">
									Decrease
								</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<button class="btn btn-primary btn-sm">
							<i class="fa fa-search"></i> Search
						</button>
						<a href="{{ route('adjust', $merchant->id) }}" class="btn btn-warning btn-sm">
							<i class="fa fa-refresh"></i> Clear Search
						</a>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<div class="form-group">
							Item Per Page: <br>
							<select class="input-small" name="per_page">
								<option value="10">10</option>
								<option value="20">20</option>
								<option value="50">50</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-sm-12">
		<div class="form-group">
			<table class="table table-bordered">
				<thead>
					<tr class="info">
						<th>#</th>
						<th>Type</th>
						<th>Amount</th>
						<th>Remark</th>
						<th>Created Date</th>
						<th>Created By</th>
					</tr>
				</thead>
				<tbody>
					@if(!$adjusts->isEmpty())
					@foreach($adjusts as $key => $adjust)
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ ($adjust->type == 1) ? 'Increase' : 'Decrease' }}</td>
						<td>{{ $adjust->amount }}</td>
						<td>{{ $adjust->remark }}</td>
						<td>{{ $adjust->created_at }}</td>
						<td>{{ $adjust->created_by }}</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="5">
							No Result Found.
						</td>
					</tr>
					@endif
				</tbody>
			</table>
			{{ $adjusts->links() }}
		</div>
	</div>
</div>
@endsection