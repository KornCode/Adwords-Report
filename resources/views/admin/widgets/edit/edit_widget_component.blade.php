@extends('admin.layout.backend')

@section('title')
Edit Widget Component #{{ $wc_data->id }}
@endsection

@section('content')

@include('admin.components.errors_box')

<div class="row">
	<form action="{{ route('admin.widget.component.edit.post') }}" method="POST" role="form">
		{{ csrf_field() }}
		<div class="col-sm-4">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Editing Widget Component #{{ $wc_data->id }}</h3>
				</div>
				<div class="box-body">
                    <input type="hidden" name="wid_comp_id" value="{{ $wc_data->id }}" />
                    <div class="form-group">
                        <label>Widget</label>
                        <br>
                        <select name="wc_widget_id" class="selectpicker" data-live-search="true" data-width="100%">
                            <option value={{ $wc_data->widget_id }}> {{ $wc_data->widget_id }} </option>
                            @foreach ($wc_widget_data as $widget) 
                                <option value={{ $widget->id }}>{{ $widget->id }} - {{ $widget->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Component</label>
                        <br>
                        <select name="wc_comp_id" class="selectpicker" data-live-search="true" data-width="100%">
                            <option value={{ $wc_data->component_id }}> {{ $wc_data->component_id }} </option>
                            @foreach ($wc_comp_data as $comp) 
                                <option value={{ $comp->id }}>{{ $comp->id }} - {{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
						<label for="wc_options" class="control-label">URL or Tel</label>
						<input type="text" name="contact" class="form-control" value="{{ $wc_data->options['contact'] }}" />
					</div>

                    <div class="form-group">
                        <label for="wc_options" class="control-label">Icon</label>
                        <input type="text" name="icon" class="form-control" value="{{ $wc_data->options['icon'] }}" />
                    </div>

                    <div class="form-group">
                        <label>Background Color</label>
                        <div class="input-group bs-colorpicker colorpicker-element">
                            <input name="backgroundColor" type="text" class="form-control" value="{{ $wc_data->options['backgroundColor'] }}" />
        
                            <div class="input-group-addon">
                            <i></i>
                            </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
				<div class="box-footer">
					<button type="submit" class="btn btn-info btn-block">Submit</button>
                </div>
			</div>
		</div>
	</form>
</div>

<div class="row">
    <div class="col-sm-4">
        <form action="{{ route('admin.widget.component.delete.post') }}" method="POST" role="form">
            {{ csrf_field() }}
            <input type="hidden" name="wid_comp_id" value="{{ $wc_data->id }}" />
            <div class="box collapsed-box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Delete Widget Component</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="delete_input" class="control-label">Type in widget component id</label>
                        <input type="text" name="delete_id" value="" class="form-control" placeholder="widget_component_access" />
                    </div>
                    @include('admin.components.errors_box')
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-danger btn-block">ONCE DELETED, CAN'T BE RESTORE</button>
                </div>
            </div>
        </form>
    </div>	
</div>
@endsection