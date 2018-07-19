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
				<li class=""><a href="#embed" data-toggle="tab" aria-expanded="false">Embed Code</a></li>
				<li class=""><a href="#widget_comp" data-toggle="tab" aria-expanded="false">Widget Component</a></li>
				<li class=""><a href="#component" data-toggle="tab" aria-expanded="false">Components</a></li>
				<li class=""><a href="#widget" data-toggle="tab" aria-expanded="false">Widgets</a></li>
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
				<div class="tab-pane" id="embed" style="width: 50%">
					@foreach ($embed as $embed_each)
						<div class="box-header with-border">
							<h3 class="box-title">Widget #{{ $embed_each['widget_id'] }} - {{ $embed_each['name'] }}</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<figure>
									<pre>
										<code>{{ $embed_each['html_code'] }}</code>
									</pre>
								</figure>
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
									<th>Align</th>
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
									<td>{{ $widget->align }}</td>
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
								@foreach($widget_component as $wc_each)
								<tr>
									<td>{{ $wc_each->id }}</td>
									<td>{{ $wc_each->widget_id }}</td>
									<td>{{ $wc_each->component_id }}</td>
									<td>
										@foreach($wc_each->options as $key => $option)
											<b>{{ $key.' - ' }}</b>{{ $option }}
											<br />
										@endforeach
									</td>
									<td>
										<a href="{{ route('admin.widget.component.edit', ['id' => $wc_each->id]) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
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