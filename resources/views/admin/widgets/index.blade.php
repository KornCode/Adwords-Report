@extends('admin.layout.backend')

@section('title')
Widgets Management
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs (Pulled to the right) -->
			<div class="nav-tabs-custom">
			<ul class="nav nav-tabs pull-right">
				<li><a href="#embed" data-toggle="tab">Embed Code</a></li>
				<li><a href="#widget_comp" data-toggle="tab">Widget Component</a></li>
				<li><a href="#component" data-toggle="tab">Components</a></li>
				<li class="active"><a href="#widget" data-toggle="tab">Widgets</a></li>
				<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					Create <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('admin.widgets.create') }}">Widgets</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('admin.components.create') }}">Components</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('admin.widget.component.create') }}">Widget Component</a></li>
				</ul>
				</li>
				<li class="pull-left header"><i class="fa fa-th"></i> Widgets Tabs</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane" id="embed">
					{{-- check point --}}
					@foreach ($embed_with_ids as $embed_with_id)
						<div class="box-header with-border">
							<h3 class="box-title">Widget #{{ $embed_with_id['widget_id'] }} - {{ $embed_with_id['domain'] }}</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<textarea class="form-control" id="exampleFormControlTextarea1" rows="6">{{ $embed_with_id['html_code'] }}</textarea>
							</div>
						</div>
					@endforeach
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane active" id="widget">
					<div class="table-responsive">
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Member ID</th>
									<th>Domain</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($widgets as $widget)
								<tr>
									<td>{{ $widget->id }}</td>
									<td>{{ $widget->name }}</td>
									<td>{{ $widget->user_id }}</td>
									<td>{{ $widget->domain }}</td>
									<td>
										<a href="{{ route('admin.widgets.edit', ['id' => $widget->id]) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="component">
					<div class="table-responsive">
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Options</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($components as $component)
								<tr>
									<td>{{ $component->id }}</td>
									<td>{{ $component->name }}</td>
									<td>
										@foreach($component->options as $key => $option)
											<b>{{ $key.' - ' }}</b>{{ $option }}
											<br />
										@endforeach
									</td>
									<td>
										<a href="{{ route('admin.components.edit', ['id' => $component->id]) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="widget_comp">
					<div class="table-responsive">
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>ID</th>
									<th>Widget ID</th>
									<th>Component ID</th>
									<th>Options</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($wid_comps as $wid_comp)
								<tr>
									<td>{{ $wid_comp->id }}</td>
									<td>{{ $wid_comp->widget_id }}</td>
									<td>{{ $wid_comp->component_id }}</td>
									<td>
										@foreach($wid_comp->options as $key => $option)
											<b>{{ $key.' - ' }}</b>{{ $option }}
											<br />
										@endforeach
									</td>
									<td>
										<a href="{{ route('admin.widget.component.edit', ['id' => $wid_comp->id]) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
			</div>
			<!-- nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
@endsection