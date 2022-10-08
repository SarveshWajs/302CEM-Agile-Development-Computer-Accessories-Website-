<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Display on website
				</div>
				<div class="col-sm-10">
					<input type="checkbox" name="dow" value="1" {{ (isset($promotion) && $promotion->dow == '1') ? 'checked' : ''  }}>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Title: <span class="important-text">*</span>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="promotion_title" value="{{ isset($promotion) ? $promotion->promotion_title : old('promotion_title') }}" placeholder="Title *">
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Upload Image: <span class="important-text">*</span>
				</div>
				<div class="col-sm-10">
					<input type="file" name="image" class="form-control">
					<br>
					@if(isset($promotion))
					<img src="{{ url($promotion->image) }}" style="width: 100px;">
					@endif
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Discount Code: <span class="important-text">*</span>
				</div>
				<div class="col-sm-10">
					<input type="text" name="discount_code" class="form-control" placeholder="Discount Code *" value="{{ isset($promotion) ? $promotion->discount_code : old('discount_code') }}">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Discount Amount: <span class="important-text">*</span>
				</div>
				<div class="col-sm-2">
					<select class="form-control" name="amount_type">
						@php
							$selectedValue = (isset($promotion)) ? $promotion->amount_type : old('amount_type');
						@endphp
						<option {{ $selectedValue == 'Percentage' ? 'selected' : '' }} value="Percentage">Percentage</option>
						<option {{ $selectedValue == 'Amount' ? 'selected' : '' }} value="Amount">(RM) Amount</option>
					</select>
				</div>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="amount" value="{{ isset($promotion) ? $promotion->amount : old('amount') }}" onkeypress="return isNumberKey(event)">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Quantity: <span class="important-text">*</span>
				</div>
				<div class="col-sm-10">
					<input type="text" name="quantity" class="form-control" placeholder="Quantity *" value="{{ isset($promotion) ? $promotion->quantity : old('quantity') }}">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-4">
							Start Date: <span class="important-text">*</span>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<input id="date-timepicker1" type="text" class="form-control date-timepicker1" name="start_date" 
									   value="{{ isset($promotion) && !empty($promotion->start_date) ? date('m/d/Y h:i:s a', strtotime($promotion->start_date)) : '' }}" />
								<span class="input-group-addon">
									<i class="fa fa-clock-o bigger-110"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-4">
							End Date: <span class="important-text">*</span>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<input id="date-timepicker1" type="text" class="form-control date-timepicker1" name="end_date" 
									   value="{{ isset($promotion) && !empty($promotion->end_date) ? date('m/d/Y h:i:s a', strtotime($promotion->end_date)) : '' }}" />
								<span class="input-group-addon">
									<i class="fa fa-clock-o bigger-110"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Usage Limit (Optional):
				</div>
				@php
					$checkedValue = (isset($promotion)) ? $promotion->limit_type : old('limit_type');
				@endphp
				<div class="col-sm-10">
					<label>
						<input name="limit_type" type="radio" value="1" class="ace limit_type" {{ $checkedValue == '1' ? 'checked' : '' }}  checked />
						<span class="lbl"> None (Until Promotion End)</span>
					</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
						<input name="limit_type" type="radio" value="2" class="ace limit_type" {{ $checkedValue == '2' ? 'checked' : '' }} />
						<span class="lbl"> Daily</span>
					</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
						<input name="limit_type" type="radio" value="3" class="ace limit_type" {{ $checkedValue == '3' ? 'checked' : '' }} />
						<span class="lbl"> Per User </span>
					</label>
					<br>
					<div class="times-limit">
					</div>
					
				</div>
			</div>
		</div>


		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Product(s) (Optional):
				</div>
				<div class="col-sm-10">
					<select class="selectpicker form-control" data-live-search="true" multiple name="products[]">
						@php
							$promotion_products = isset($promotion) ? explode(',', $promotion->products) : [];
						@endphp
						@foreach($products as $product)
					  		<option {{in_array($product->id, $promotion_products ?: []) ? "selected": ""}} value="{{ $product->id }}" data-tokens="{{ $product->id }}">
					  			{{ $product->product_name }}
					  		</option>
					  	@endforeach
					</select>
				</div>
			</div>
		</div>		
	</div>
</div>
<script type="text/javascript">
	var a = '{{ $checkedValue }}';
    
    if(a){
        $('.limit_type').filter(function(){return this.value==a}).click();
    }
</script>