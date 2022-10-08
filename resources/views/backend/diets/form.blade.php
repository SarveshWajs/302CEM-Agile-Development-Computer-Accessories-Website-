@php
if(isset($diet)){
	$action_url = route('diet.diets.update', $diet->id);
}else{
	$action_url = route('diet.diets.store');
}

@endphp

<div class="row">
	<div class="col-xs-12">
		<form method="POST" action="{{ $action_url }}" id="product-form">
			@csrf
			@if(isset($diet))
			@method('PUT')
			@endif
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">

					</div>
					
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Name: <span class="important-text">*</span>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="product_name" value="{{ isset($diet) ? $diet->product_name : old('product_name') }}" placeholder="Name *">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Category: <span class="important-text">*</span>
					</div>
					<div class="col-sm-6">
						<select class="form-control category_id" name="category_id">
							<option value="">Select Category</option>
							@foreach($categories as $category)
							<option {{ (isset($diet) && $diet->category_id == $category->id) ? 'selected': '' }} value="{{ $category->id }}">
								{{ $category->category_name }}
							</option>
							@endforeach
						</select>
					</div>
					<div class="col-sm-4 item_code">
						@if(isset($diet) && empty($diet->sub_category_id))
						{{ isset($diet) ? "Item code: ".$diet->item_code : '' }}
						@endif
					</div>
				</div>
			</div>
			

			<input type="hidden" name="item_code" class="hidden_item_code" value="{{ isset($diet) ? $diet->item_code: '' }}">

			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Brand: 
					</div>
					<div class="col-sm-10">
						<select class="form-control" name="brand_id">
							<option value>Select Brand</option>
							@foreach($brands as $brand)
							<option {{ (isset($diet) && $diet->brand_id == $brand->id) ? 'selected': '' }} value="{{ $brand->id }}">
								{{ $brand->brand_name }}
							</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>

			
			<hr>
			<input type="hidden" name="variation_enable" class="variation_enable" value="{{ isset($diet) ? $diet->variation_enable : '0' }}">
			<div class="non-variation-tab"
				 style="{{ (!isset($diet) || (isset($diet) && $diet->variation_enable == 0)) ? 'display: block;' : 'display: none;'  }}">
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-4">
									Customer Price: <span class="important-text">*</span>
								</div>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="price" value="{{ isset($diet) ? $diet->price : old('price') }}" placeholder="Price *" onkeypress="return isNumberKey(event)">
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-4">
									Customer Special Price:
								</div>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="special_price" value="{{ isset($diet) ? $diet->special_price : old('special_price') }}" placeholder="Special Price" onkeypress="return isNumberKey(event)">
								</div>
							</div>
						</div>
					</div>
				</div>

				

				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							Weight (KG): 
						</div>
						<div class="col-sm-10">
							<input type="text" name="weight" class="form-control" value="{{ isset($diet) ? $diet->weight : old('weight') }}" placeholder="Weight (KG)" onkeypress="return isNumberKey(event)">
						</div>
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
						<textarea class="form-control" name="description" id="description">{!! isset($diet) ? $diet->description : old('description') !!}</textarea>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						Short Description:
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="short_description" value="{{ isset($diet) ? $diet->short_description : old('short_description') }}" placeholder="Short Description">
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
						<div class="row" id="imageListId">
							
						</div>
						<div class="clear-both"></div>
					</div>
					<!-- <div class="form-group">
						<form method="POST" action="" class="asdasd" id="upload_image_form" enctype="multipart/form-data">
							<input type="file" name="upload_image" id="upload_image" class="form-control" />
							<br />
				  			<div id="uploaded_image"></div>
						</form>
					</div> -->
					<div>
						<form method="POST" action="{{ route('uploadImage', isset($product->id) ? $diet->id : 0) }}" class="dropzone well" id="dropzone" enctype="multipart/form-data">
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

<div id="uploadimageModal" class="modal bs-example-modal-lg" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Upload & Crop Image</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-12 text-center">
  						<center>
							<div id="image_demo" style="width: 100%; margin-top:30px"></div>  							
  						</center>
  					</div>
  					<div class="form-group" align="center">
						<button class="btn btn-success crop_image">Crop & Upload Image</button>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
    </div>
</div>

