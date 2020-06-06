@extends('admin.layout.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-envelope font-blue-sharp"></i>
						<span class="caption-subject font-blue-sharp bold uppercase">Block IO Settings</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form role="form" method="POST" action="{{route('block.update')}}">
						{{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label>Block API</label>
								<input type="text" name="blockapi" class="form-control input-lg" value="{{$blockd->blockapi}}">
							</div>
							<div class="form-group">
								<label>Block Pin</label>
								<input type="text" name="blockpin" value="{{$blockd->blockpin}}" class="form-control">
							</div>
							<div class="form-group">
								<label>Admin Wallet ID</label>
								<input type="text" name="adminwallet" class="form-control" value="{{$blockd->adminwallet}}">
							</div>
							<div class="form-group">
								<label>Convertion Charge</label>
								<div class="input-group">
									<input type="text" name="concrg" class="form-control" value="{{$blockd->concrg}}">
									<span class="input-group-addon">%</span>
								</div>
								
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn green btn-block btn-lg">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	@endsection