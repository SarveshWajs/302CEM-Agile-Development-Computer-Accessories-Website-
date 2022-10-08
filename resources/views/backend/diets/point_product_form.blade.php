@php
if(isset($product)){
	$action_url = route('point_mall.point_malls.update', $product->id);
}else{
	$action_url = route('point_mall.point_malls.store');
}

@endphp
<div class="row">
	<div class="col-xs-12">
		<form method="POST" action="{{ $action_url }}" id="product-form">
			@csrf
			@if(isset($product))
			@method('PUT')
			@endif
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Name: <span class="important-text">*</span>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="product_name" value="{{ isset($product) ? $product->product_name : old('product_name') }}" placeholder="Name *">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Category: <span class="important-text">*</span>
					</div>
					<div class="col-sm-10">
						<select class="form-control" name="category_id">
							<option value="">Select Category</option>
							@foreach($categories as $category)
							<option {{ (isset($product) && $product->category_id == $category->id) ? 'selected': '' }} value="{{ $category->id }}">
								{{ $category->category_name }}
							</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<!-- <div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Sub Category:
					</div>
					<div class="col-sm-10">
						<select class="selectpicker form-control" data-live-search="true" multiple name="sub_category_id[]">
							@php
								$sub = isset($product) ? explode(',', $product->sub_category_id) : [];
							@endphp
							@foreach($sub_categories as $sub_category)
						  		<option {{in_array($sub_category->id, $sub ?: []) ? "selected": ""}} value="{{ $sub_category->id }}" data-tokens="{{ $sub_category->id }}">
						  			{{ $sub_category->sub_category_name }}
						  		</option>
						  	@endforeach
						</select>
					</div>
				</div>
			</div> -->
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Brand: 
					</div>
					<div class="col-sm-10">
						<select class="form-control" name="brand_id">
							<option value>Select Brand</option>
							@foreach($brands as $brand)
							<option {{ (isset($product) && $product->brand_id == $brand->id) ? 'selected': '' }} value="{{ $brand->id }}">
								{{ $brand->brand_name }}
							</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-4">
								Point: <span class="important-text">*</span>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="price" value="{{ isset($product) ? $product->price : old('price') }}" placeholder="Point *" onkeypress="return isNumberKey(event)">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-4">
								Special Point:
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="special_price" value="{{ isset($product) ? $product->special_price : old('special_price') }}" placeholder="Special Point" onkeypress="return isNumberKey(event)">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-4">
								Agent Point: <span class="important-text">*</span>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="agent_price" value="{{ isset($product) ? $product->agent_price : old('agent_price') }}" placeholder="Agent Point *" onkeypress="return isNumberKey(event)">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-4">
								Agent Special Point:
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="agent_special_price" value="{{ isset($product) ? $product->agent_special_price : old('agent_special_price') }}" placeholder="Agent Special Point" onkeypress="return isNumberKey(event)">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Quantity: <span class="important-text">*</span>
					</div>
					<div class="col-sm-10">
						@if(isset($product))
							{{ $stockBalance }} 
							&nbsp;&nbsp; 
							<a href="{{ route('stock', [$product->id]) }}" class="green">
								<i class="ace-icon fa fa-upload bigger-130"></i>
							</a>
						@else
							<input type="text" class="form-control" name="quantity" value="{{ isset($product) ? $product->quantity : old('quantity') }}" placeholder="Quantity *" onkeypress="return isNumberKey(event)">
						@endif
					</div>
				</div>
			</div>
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
		</form>
		<hr>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Image: 
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
