<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Title: <span class="important-text">*</span>
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="title" value="{{ isset($blog) ? $blog->title : old('title') }}" placeholder="Name *">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Image: <span class="important-text">*</span>
				</div>
				<div class="col-sm-10">
					<input type="file" class="form-control" name="image" accept="image/*">
					@if(!empty($blog->image))
					<img src="{{ url($blog->image) }}" width="100px">
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Description: <span class="important-text">*</span>
				</div>
				<div class="col-sm-10">
					<textarea id="description" class="form-control" name="description">{{ (isset($blog)) ? $blog->description : old('description') }}</textarea>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Dates: 
				</div>
				<div class="col-sm-10">
					<div class="input-group">
						<input class="form-control date-picker" name="blog_date" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" value="{{ isset($blog) ? $blog->blog_date : old('blog_date') }}">
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					Tags: 
				</div>
				<div class="col-sm-10">
					<input type="text" class="form-control" value="{{ isset($blog) ? $blog->blog_tags : old('blog_tags') }}" name="blog_tags" data-role="tagsinput" id="tags">
				</div>
			</div>
		</div>
	</div>
</div>
