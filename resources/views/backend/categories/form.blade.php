<div class="panel panel-default">
    <div class="panel-body">
        <h4>
            <b>Notice</b>
        </h4>
        <hr>
        <li>
            Note: If "<b>Show on menu bar</b>" is checked, the category will appear at the <b>Frontend Top Menu Bar</b> .
        </li>
    </div>
</div>
<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-4">
					Show on menu bar: 
				</div>
				<div class="col-sm-8">
					<div class="checkbox">
						<label>
							@php
								$checkedBox = (isset($category)) ? $category->menu_bar : old('menu_bar');
							@endphp
							<input name="menu_bar" type="checkbox" class="ace" value="1" {{ $checkedBox == 1 ? 'checked' : '' }} />
							<span class="lbl"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-4">
					Code: <span class="important-text">*</span>
				</div>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="code" value="{{ isset($category) ? $category->code : old('code') }}" placeholder="Code *">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-4">
					Name: <span class="important-text">*</span>
				</div>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="category_name" value="{{ isset($category) ? $category->category_name : old('category_name') }}" placeholder="Name *">
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-sm-2">
        Image <span class="important-text">*</span>
    </div>
    <div class="col-sm-10">
        <div class="form-group category-image-list">
            <div class="row">
                
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="form-group">
          <form method="POST" action="" class="asdasd" id="upload_image_form" enctype="multipart/form-data">
            <input type="file" name="upload_image" id="upload_image" class="form-control" accept="image/*" />
            <br />
              <div id="uploaded_image"></div>
          </form>
        </div>
    </div>
</div>