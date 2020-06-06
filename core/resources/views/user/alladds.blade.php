@extends('layouts.user')

@section('content')
<div class="row">
<div class="col-md-12">
  <div class="panel panel-inverse" data-sortable-id="index-1">
    <div class="panel-heading">
      <h4 class="panel-title">Addresses</h4>
    </div>
    <div class="panel-body table-responsive">
     <table class="table table-striped">
     	<tr>
     		<th>Label</th>
     		<th>Address</th>
     		<th>Pending Balance</th>
     		<th>Balance</th>
     	</tr>
     	@foreach($adds as $add)
     	<tr>
     		<td>{{$add->label == '' ? 'No Label' : $add->label}}</td>
     		<td>{{$add->address}}</td>
     		<td>{{$add->pendingbalance}} BTC</td>
     		<td>{{$add->balance}} BTC</td>
     	</tr>
     	@endforeach
     </table>
     <?php echo $adds->render(); ?>
   </div>
 </div>
</div>   
</div>

@endsection
