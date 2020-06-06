@extends('admin.layout.master')

@section('content')
<div class="row">
  <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption font-dark">
          <i class="icon-settings font-dark"></i>
          <span class="caption-subject bold uppercase">User Transaction Log</span>
        </div>

      </div>
      <div class="portlet-body">

       <table class="table table-striped table-responsive">
      <tr>
        <th>User</th>
        <th>Recipient</th>
        <th>Sender</th>
        <th>Amount</th>
        <th>Confirmations</th>
      </tr>
      @foreach($trans as $trn)
      <tr>
        <td><a href="{{route('user.single', $trn->user_id)}}">{{$trn->user->username}}</a></td>
        <td>{{$trn->recipient}}</td>
        <td>{{$trn->sender}}</td>
        <td>{{$trn->amount}} BTC</td>
        <td>{{$trn->confirmations<3? $trn->confirmations : 'Confirmed' }} </td>
      </tr>
      @endforeach
     </table>
      <?php echo $trans->render(); ?>
  </div>

</div><!-- row -->
</div>
</div>
@endsection