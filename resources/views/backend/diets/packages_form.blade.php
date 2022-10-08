@php
if(isset($product)){
	$action_url = route('packages_edit_save', $product->id);
}else{
	$action_url = route('packages_add');
}

@endphp
<div class="row">
	<div class="col-xs-12">
		<form method="POST" action="{{ $action_url }}" id="product-form">
			@csrf

			<div class="form-group container-box">
				<h4>Fill In Product Information</h4>
				<hr>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							Name: <span class="important-text">*</span>
						</div>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="product_name" value="{{ isset($product) ? $product->product_name : old('product_name') }}" placeholder='Name'>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group container-box">
				<h4>Fill In The Price (RM) </h4>
				<hr>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-2">
									Total Price: <span class="important-text">*</span>
								</div>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="price" value="{{ isset($product) ? $product->price : old('price') }}" placeholder='Total Price' onkeypress="return isNumberKey(event)">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-2">
									Agent Total Price: <span class="important-text">*</span>
								</div>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="agent_price" value="{{ isset($product) ? $product->agent_price : old('agent_price') }}" placeholder='Agent Total Price' onkeypress="return isNumberKey(event)">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group container-box">
				<h4>Fill In The Quantity and Weight of Goods</h4>
				<hr>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							Weight (kg): <span class="important-text">*</span>
						</div>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="weight" value="{{ isset($product) ? $product->weight : old('weight') }}" placeholder='Weight (kg)' onkeypress="return isNumberKey(event)">
						</div>
					</div>
				</div>
			</div>

			<div class="form-group container-box">
				<h4>The Package Contains Items</h4>
				<hr>
				<div class="parent-box">
					<div class="form-group">
						@if(isset($packages) && !$packages->isEmpty())
							@foreach($packages as $package)
								<input type="hidden" name="pid[]" value="{{ $package->id }}">
								<div class="row">
									<div class="col-md-2">
										<select class="form-control products" name="products[]">
											<option value="">Select Products</option>
											@foreach($products as $product_s)
											@if($product_s->packages != 1)
											<option {{ ($package->products == $product_s->id) ? 'selected' : '' }}  value="{{ $product_s->id }}">{{ $product_s->product_name }}</option>
											@endif
											@endforeach
										</select>
									</div>
									<div class="col-md-2">
										<input type="input" name="qty[]" class="form-control" placeholder='Quantity' value="{{ $package->qty }}" onkeypress="return isNumberKey(event)">	
									</div>
									<div class="col-md-2">
										<input type="input" name="unit_price[]" class="form-control" placeholder='Total Cost (RM)' onkeypress="return isNumberKey(event)" value="{{ $package->unit_price }}">
									</div>
									<div class="col-md-2">
										<a href="#" class="important-text delete_btn" data-id="{{ $package->id }}">
											<i class="fa fa-trash fa-2x"></i>
										</a>
									</div>
								</div>
								<br>
							@endforeach
						@else
							<input type="hidden" name="pid[]" value="">
							<div class="row">
								<div class="col-md-2">
									<select class="form-control products" name="products[]">
										<option value="">Select Products</option>
										@foreach($products as $product_s)
										@if($product_s->packages != 1)
										<option value="{{ $product_s->id }}">{{ $product_s->product_name }} </option>
										@endif
										@endforeach
									</select>
								</div>
								<div class="col-md-2">
									<input type="input" name="qty[]" class="form-control" placeholder='Quantity' onkeypress="return isNumberKey(event)">	
								</div>
								<div class="col-md-2">
									<input type="input" name="unit_price[]" class="form-control" placeholder='Total Cost (RM)' onkeypress="return isNumberKey(event)">
								</div>
								<div class="col-md-2">
									<a href="#" class="important-text delete_btn">
										<i class="fa fa-trash fa-2x"></i>
									</a>
								</div>
							</div>
						@endif
					</div>
				</div>

				<hr>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6" align="center">
							<a href='#' class="add-shipping-btn">
								<i class="fa fa-plus"></i>
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- <div class="form-group container-box">
				<h4>Commission Setting</h4>
				<hr>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							Product Commission (Agent Ownself): 
						</div>
						<div class="col-sm-4">
							<select class="form-control" name="own_product_comm_type">
								<option {{ (isset($product) && $product->own_product_comm_type == 'Percentage') ? 'selected': '' }} value="Percentage">Percentage</option>
								<option {{ (isset($product) && $product->own_product_comm_type == 'Amount') ? 'selected': '' }} value="Amount">Amount</option>
							</select>
						</div>
						<div class="col-sm-6">
							<input type="text" name="own_product_comm_amount" class="form-control" value="{{ isset($product) ? $product->own_product_comm_amount : old('own_product_comm_amount') }}" placeholder="Commission Amount" onkeypress="return isNumberKey(event)">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							Product Commission (Customer / Agent Upline): 
						</div>
						<div class="col-sm-4">
							<select class="form-control" name="product_comm_type">
								<option {{ (isset($product) && $product->product_comm_type == 'Percentage') ? 'selected': '' }} value="Percentage">Percentage</option>
								<option {{ (isset($product) && $product->product_comm_type == 'Amount') ? 'selected': '' }} value="Amount">Amount</option>
							</select>
						</div>
						<div class="col-sm-6">
							<input type="text" name="product_comm_amount" class="form-control" value="{{ isset($product) ? $product->product_comm_amount : old('product_comm_amount') }}" placeholder="Commission Amount" onkeypress="return isNumberKey(event)">
						</div>
					</div>
				</div>


				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							Product Commission (In-house sale): 
						</div>
						<div class="col-sm-4">
							<select class="form-control" name="in_product_comm_type">
								<option {{ (isset($product) && $product->in_product_comm_type == 'Percentage') ? 'selected': '' }} value="Percentage">Percentage</option>
								<option {{ (isset($product) && $product->in_product_comm_type == 'Amount') ? 'selected': '' }} value="Amount">Amount</option>
							</select>
						</div>
						<div class="col-sm-6">
							<input type="text" name="in_product_comm_amount" class="form-control" value="{{ isset($product) ? $product->in_product_comm_amount : old('in_product_comm_amount') }}" placeholder="Commission Amount" onkeypress="return isNumberKey(event)">
						</div>
					</div>
				</div>
			</div> -->

			<!-- <div class="form-group container-box">
				<h4>
					活动时间 
					<label>
						@php
							$checkedBox = (isset($product)) ? $product->event_time_available : old('event_time_available');
						@endphp	
						<input name="event_time_available" type="checkbox" class="ace" value="1" {{ ($checkedBox == 1) ? 'checked' : '' }} />
						<span class="lbl"></span>
					</label>
				</h4>
				<hr>
				<div class="input-group event_area">
					<span class="input-group-addon">
						<i class="fa fa-calendar bigger-110"></i>
					</span>

					<input class="form-control event_date" type="text" name="event_date" id="id-date-range-picker-1" 
						   value="{{ isset($product) ? $product->event_date : old('event_date') }}" />
				</div>
			</div> -->
			<hr>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Description: <span class="important-text">*</span>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="description" id="description">{!! isset($product) ? $product->description : old('description') !!}</textarea>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Giveaway: 
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="free_gift_description" id="free_gift_description">{!! isset($product) ? $product->free_gift : old('free_gift_description') !!}</textarea>
					</div>
				</div>
			</div>
		</form>
		<hr>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Image
				</div>
				<div class="col-sm-10">
					<div class="form-group product-image-list">
						<div class="row">
							
						</div>
						<div class="clear-both"></div>
					</div>
					<div>
						<form method="POST" action="{{ route('uploadImage', isset($product->id) ? $product->id : 0) }}" class="dropzone well" id="dropzone" enctype="multipart/form-data">
							@csrf
							<div class="fallback">
								<input name="file" type="file" multiple="" />
							</div>
						</form>
					</div>

					<div id="preview-template" class="hide">
						<div class="dz-preview dz-file-preview">
							<div class="dz-image">
								<img data-dz-thumbnail="" />
							</div>

							<div class="dz-details">
								<div class="dz-size">
									<span data-dz-size=""></span>
								</div>

								<div class="dz-filename">
									<span data-dz-name=""></span>
								</div>
							</div>

							<div class="dz-progress">
								<span class="dz-upload" data-dz-uploadprogress=""></span>
							</div>

							<div class="dz-error-message">
								<span data-dz-errormessage=""></span>
							</div>

							<div class="dz-success-mark">
								<span class="fa-stack fa-lg bigger-150">
									<i class="fa fa-circle fa-stack-2x white"></i>

									<i class="fa fa-check fa-stack-1x fa-inverse green"></i>
								</span>
							</div>

							<div class="dz-error-mark">
								<span class="fa-stack fa-lg bigger-150">
									<i class="fa fa-circle fa-stack-2x white"></i>

									<i class="fa fa-remove fa-stack-1x fa-inverse red"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
