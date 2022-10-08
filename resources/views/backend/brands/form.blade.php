<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Name: <span class="important-text">*</span>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="brand_name" value="{{ isset($brand) ? $brand->brand_name : old('brand_name') }}" placeholder="Name *">
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			<div class="row">
			    <div class="col-sm-2">
			        Image <span class="important-text">*</span>
			    </div>
			    <div class="col-sm-10">
			        <input type="file" name="fileToUpload" class="form-control">
			        @if(isset($brand) && !empty($brand->image))
			        	<br>
			        	<img src="{{ url($brand->image) }}" width="100px">
			        @endif
			    </div>
			</div>
		</div>
	</div>
</div>