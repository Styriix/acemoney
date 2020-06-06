@extends('admin.layout.master')

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-envelope font-blue-sharp"></i>
						<span class="caption-subject font-blue-sharp bold uppercase">Invoice Settings</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form role="form" method="POST" action="{{route('invoice.update')}}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label>Invoice Contact Address</label>
								<textarea class="form-control" name="contac" rows="10">
									{{$invoice->contac}}
								</textarea>
							</div>
							<div class="form-group">
								<label>Invoice Bank Information</label>
								<textarea class="form-control" name="bank" rows="6">
									{{$invoice->bank}}
								</textarea>
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