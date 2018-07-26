@extends('admin.layout.backend')
{{-- check point --}}
@section('title')
Edit Component #{{ $component->id }}
@endsection

@section('content')

@include('admin.components.errors_box') 

<div class="row">
	<form action="{{ route('admin.components.edit.post') }}" method="POST" role="form">
		{{ csrf_field() }}
		<div class="col-sm-4">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Editing Component #{{ $component->id }} - {{ $component->name }}</h3>
				</div>
				<div class="box-body">
                    <input type="hidden" name="component_id" value="{{ $component->id }}" />
                    <div class="form-group">
                        <label>Name and Icon</label>
                        <br>
                        <select name="icon" class="selectpicker" data-live-search="true" data-width="100%">
                        @foreach($icon_options as $key => $value)
                            @if ($component->name == $value)
                                <option selected data-icon="{{ $key }}" value="{{ $value }}">{{ $value }}</option>
                            @else
                                <option data-icon="{{ $key }}" value="{{ $value }}">{{ $value }}</option>
                            @endif
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
                                        @if ($component->options['size'] == $size)
                                            <option selected value={{ $size }}>{{ $size }} px</option>
                                        @else
                                            <option value={{ $size }}>{{ $size }} px</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Icon Color</label>
                                <div class="input-group bs-colorpicker colorpicker-element">
                                    @php
                                        $iconColor = (array_key_exists('iconColor', $component->options)) ? $component->options['iconColor'] : null;
                                    @endphp
                                    <input name="iconColor" type="text" class="form-control" value="{{ $iconColor }}">
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Tooltip Text Color</label>
                                <div class="input-group bs-colorpicker colorpicker-element">
                                    @php
                                        $tooltipColor = (array_key_exists('tooltipColor', $component->options)) ? $component->options['tooltipColor'] : null;
                                    @endphp
                                    <input name="tooltipColor" type="text" class="form-control" value="{{ $tooltipColor }}">
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Background Color</label>
                                <div class="input-group bs-colorpicker colorpicker-element">
                                    @php
                                        $backgroundColor = (array_key_exists('backgroundColor', $component->options)) ? $component->options['backgroundColor'] : null;
                                    @endphp
                                    <input name="backgroundColor" type="text" class="form-control" value="{{ $backgroundColor }}">
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
					<button type="submit" class="btn btn-info btn-block">Submit</button>
                </div>
			</div>
		</div>
	</form>
</div>

<div class="row">
    <div class="col-sm-4">
        <form action="{{ route('admin.components.delete.post') }}" method="POST" role="form">
            {{ csrf_field() }}
            <input type="hidden" name="component_id" value="{{ $component->id }}" />
            <div class="box collapsed-box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Delete Component</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="delete_input" class="control-label">Type in component id</label>
                        <input type="text" name="delete_id" value="" class="form-control" placeholder="component_access" />
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