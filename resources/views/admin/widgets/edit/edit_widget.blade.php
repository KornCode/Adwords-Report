@extends('admin.layout.backend')

@section('title')
Edit Widget #{{ $widget->id }}
@endsection

@section('content')

@include('admin.components.errors_box')

<div class="row">
	<form action="{{ route('admin.widgets.edit.post') }}" method="POST" role="form">
		{{ csrf_field() }}
		<div class="col-sm-4">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Editing Widget #{{ $widget->id }} - {{ $widget->name }} - {{ $widget->domain }}</h3>
				</div>
				<div class="box-body">
                    <input type="hidden" name="widget_id" value="{{ $widget->id }}" />
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="widget_name" class="form-control" placeholder="laravel.com's widget" value="{{ $widget->name }}" />
                    </div>

                    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                        <label>User ID</label>
                        <br>
                        <select name="user_id" class="selectpicker" data-live-search="true" data-width="100%">
                            <option value={{ $widget->user_id }}> {{ $widget->user_id }} </option>
                            @foreach ($user_data as $user) 
                                <option value={{ $user->id }}>{{ $user->id }} - {{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- checkbox -->
					<div class="form-group">
                        <label>Alignment</label>
                        <br>
                        @if ($widget->align == "mobile")
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-block btn-default btn-flat">
                                    <input type="radio" name="alignment" value="desktop" autocomplete="off"> Desktop
                                </label>
                                <label class="btn btn-block btn-default btn-flat active">
                                    <input type="radio" name="alignment" value="mobile" autocomplete="off" checked> Mobile
                                </label>
                            </div>
                        @elseif ($widget->align == "desktop")
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-block btn-default btn-flat active">
                                    <input type="radio" name="alignment" value="desktop" autocomplete="off" checked> Desktop
                                </label>
                                <label class="btn btn-block btn-default btn-flat">
                                    <input type="radio" name="alignment" value="mobile" autocomplete="off"> Mobile
                                </label>
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
                        <label for="domain" class="control-label">Domain</label>
                        <input type="text" name="domain" class="form-control" placeholder="laravel.com" value="{{ $widget->domain }}" />
                    </div>

                    <div class="form-group">
                        <label>Tooltip Background Color
                            <br>
                            <h6><em>(Not require for mobile alignment)</em></h6>
                        </label>
                        <div class="input-group bs-colorpicker colorpicker-element">
                            @php
                                $tooltipBgColor = ($widget->tooltipBgColor != null) ? $widget->tooltipBgColor : null;
                            @endphp
                            <input name="tooltipBgColor" type="text" class="form-control" value="{{ $tooltipBgColor }}">
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
        <form action="{{ route('admin.widgets.delete.post') }}" method="POST" role="form">
            {{ csrf_field() }}
            <input type="hidden" name="widget_id" value="{{ $widget->id }}" />
            <div class="box collapsed-box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Delete Widget</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="delete_input" class="control-label">Type in widget id</label>
                        <input type="text" name="delete_id" value="" class="form-control" placeholder="widget_access" />
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