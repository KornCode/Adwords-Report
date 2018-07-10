@extends('admin.layout.backend')

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
                        <select name="name_icon" class="selectpicker" data-live-search="true" data-width="100%">
                            <option value={{ $component->name }}> {{ $component->name }} </option>
                            <option data-icon="fa fa-facebook" value="facebook">Facebook</option>
                            <option data-icon="fa fa-google-plus" value="google">Google</option>
                            <option data-icon="fa fa-comment" value="line">Line</option>
                            <option data-icon="fa fa-phone" value="call">Call</option>
                            <option data-icon="fa fa-envelope" value="email">Email</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Background Color</label>
                                <div class="input-group my-colorpicker2 colorpicker-element">
                                    <input name="backgroundColor" type="text" class="form-control" value={{ $component->options['backgroundColor'] }}>
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Background Hover Color</label>
                                <div class="input-group my-colorpicker2 colorpicker-element">
                                    <input name="backgroundHoverColor" type="text" class="form-control" value={{ $component->options['backgroundHoverColor'] }}>
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Text Color</label>
                                <div class="input-group my-colorpicker2 colorpicker-element">
                                    <input name="textColor" type="text" class="form-control" value={{ $component->options['textColor'] }}>
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Text Hover Color</label>
                                <div class="input-group my-colorpicker2 colorpicker-element">
                                    <input name="textHoverColor" type="text" class="form-control" value={{ $component->options['textHoverColor'] }}>
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Text Background Color</label>
                                <div class="input-group my-colorpicker2 colorpicker-element">
                                    <input name="textBackgroundColor" type="text" class="form-control" value={{ $component->options['textBackgroundColor'] }}>
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Text Background Hover Color</label>
                                <div class="input-group my-colorpicker2 colorpicker-element">
                                    <input name="textBackgroundHoverColor" type="text" class="form-control" value={{ $component->options['textBackgroundHoverColor'] }}>
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