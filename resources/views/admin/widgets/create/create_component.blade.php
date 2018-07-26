@extends('admin.layout.backend')
 
@section('title')
Create a new Component
@endsection

@section('content')

@include('admin.components.errors_box')

<div class="row">
	<form action="{{ route('admin.components.create.post') }}" method="POST" role="form">
		{{ csrf_field() }}
		<div class="col-sm-4">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Component Profile</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Name and Icon</label>
						<br>
						<select name="icon" class="selectpicker" data-live-search="true" data-width="100%">
						@foreach($icon_options as $key => $value)
							<option data-icon="{{ $key }}" value="{{ $value }}">{{ $value }}</option>
						@endforeach
						</select>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Icon Size</label>
								<br>
								<select name="size" class="selectpicker">
									@foreach($size_options as $size)
										<option value={{ $size }}>{{ $size }} px</option>
									@endforeach
								</select>	  
							</div>

							<div class="form-group">
								<label>Icon Color</label>
								<div class="input-group bs-colorpicker colorpicker-element">
									<input name="iconColor" type="text" class="form-control">
									<div class="input-group-addon">
										<i></i>
									</div>
								</div>
								<!-- /.input group -->
							</div>
							<div class="form-group">
								<label>Tooltip Text Color</label>
								<div class="input-group bs-colorpicker colorpicker-element">
									<input name="tooltipColor" type="text" class="form-control">
									<div class="input-group-addon">
										<i></i>
									</div>
								</div>
								<!-- /.input group -->
							</div>
							<div class="form-group">
								<label>Background Color</label>
								<div class="input-group bs-colorpicker colorpicker-element">
									<input name="backgroundColor" type="text" class="form-control">
									<div class="input-group-addon">
										<i></i>
									</div>
								</div>
								<!-- /.input group -->
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-block btn-warning">Create New Component</button>
				</div>
			</div>
		</div>
	</form>
</div>
	
@endsection