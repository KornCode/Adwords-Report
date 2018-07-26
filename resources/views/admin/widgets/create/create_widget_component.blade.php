@extends('admin.layout.backend')
{{-- ss --}}
@section('title')
Create a new Widget
@endsection

@section('content')

@include('admin.components.errors_box')

<div class="row">
	<form action="{{ route('admin.widget.component.create.post') }}" method="POST" role="form">
		{{ csrf_field() }}
		<div class="col-sm-4">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Add Widget Component</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Widget</label>
						<br>
						<select name="wc_widget_id" class="selectpicker" data-live-search="true" data-width="100%">
							<option disabled selected value> -- select an option -- </option>
							@foreach ($wc_widget_data as $widget) 
								<option value={{ $widget->id }}>{{ $widget->id }} - {{ $widget->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Component</label>
						<br>
						<select name="wc_comp_id" class="selectpicker" data-live-search="true" data-width="100%">
							<option disabled selected value> -- select an option -- </option>
							@foreach ($wc_comp_data as $comp) 
								<option value={{ $comp->id }}>{{ $comp->id }} - {{ $comp->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="wc_options" class="control-label">URL or Tel</label>
						<input type="text" name="contact" class="form-control" placeholder="www.example.com or 0123456789" />
					</div>

					<div class="form-group">
						<label for="wc_options" class="control-label">Icon</label>
						<input type="text" name="icon" class="form-control" placeholder="fa" />
					</div>

					<div class="form-group">
						<label class="control-label">Icon Size</label>
						<input type="number" name="size" class="form-control" placeholder="integer" />
					</div>

					<div class="form-group">
						<label for="wc_options" class="control-label">Icon Color</label>
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
						<label for="wc_options" class="control-label">Background Color</label>
						<div class="input-group bs-colorpicker colorpicker-element">
								<input name="backgroundColor" type="text" class="form-control">
								<div class="input-group-addon">
								<i></i>
							</div>
						</div>
						<!-- /.input group -->
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-block btn-info">Create New Widget Component</button>
				</div>
			</div>
		</div>
	</form>
</div>
	
@endsection