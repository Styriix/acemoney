@extends('layouts.user')

@section('content')
<div class="row">
<div class="col-md-12">
  <div class="panel panel-inverse" data-sortable-id="index-1">
    <div class="panel-heading">
      <h4 class="panel-title">Bitcoin Transactions</h4>
    </div>
    <div class="panel-body table-responsive">
     <table class="table table-striped">
      <tr>
        <th>Type</th>
        <th>Recipient</th>
        <th>Sender</th>
        <th>Amount</th>
        <th>Confirmations</th>
      </tr>
      @foreach($trans as $trn)
      <tr>
        <td><span class="btn btn-{{$trn->type == 1 ? 'success' : 'warning'}}">{{$trn->type == 1 ? 'Recived' : 'Sent'}}</span></td>
        <td>{{$trn->recipient}}</td>
        <td>{{$trn->sender}}</td>
        <td>{{$trn->amount}} BTC</td>
        <td>{{$trn->confirmations<3? $trn->confirmations : 'Confirmed' }} </td>
      </tr>
      @endforeach
     </table>
      <?php echo $trans->render(); ?>
   </div>
 </div>
</div>   
</div>

@endsection
