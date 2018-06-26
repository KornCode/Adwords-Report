@extends('admin.layout.backend')

@section('title')
Members Management
@endsection

@section('content')
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Members</h3>
			<div class="box-tools pull-right">
				<a href="{{ route('admin.members.create') }}" style="width: 150px;" class="btn btn-info btn-sm"><i class="fa fa-user-plus"></i> New Member</a>
			</div>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Roles</th>
							<th>Ads Key</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($members as $member)
						<tr>
							<td>{{ $member->id }}</td>
							<td>{{ $member->first_name.' '.$member->last_name }}</td>
							<td>{{ $member->email }}</td>
							<td>
								@foreach($member->roles as $role)
									@if ($role->name == 'admin')
										<span class="label label-success" style="font-size: 14px;">{{ $role->name }}</span>
									@else
										<span class="label label-primary" style="font-size: 14px;"> user </span>
									@endif
								@endforeach
							</td>
							<td>
								{{ $member->getAdwordsId() }}
							</td>
							<td>
								<a href="{{ route('admin.members.edit', ['id' => $member->id]) }}" style="width: 60px;" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
							</td>
						</tr>
						@endforeach
						@foreach($ads_keys as $ads_key)
						<tr>
							<td>
								{{-- @foreach($ads_key->key as $key) --}}
								<span class="label label-success" style="font-size: 14px;">{{ $ads_key->meta_value }}</span>
								{{-- @endforeach --}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
