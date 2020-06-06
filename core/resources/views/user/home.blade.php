@extends('layouts.user')

@section('content')
<div class="row">
  <div class="col-md-6 col-sm-12">
    <div class="widget widget-stats" style="margin-bottom: 10px; background: linear-gradient(to left, #f2e010, #d2a802)">
      <div class="stats-info">
              <h4>
                BITCOIN BALANCE 
              </h4>
              <p><strong id="balance-btc"> {{number_format(floatval($btcbal) , 8, '.', '')}} BTC</strong></p>
          </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-12">
    <div class="widget widget-stats" style="margin-bottom: 10px; background: linear-gradient(to left, #2ecc71, #27ae60)">
      <div class="stats-info">
              <h4>
                 BALANCE IN USD
              </h4>
              <p><strong id="balance-btc">${{($btcbal*$btcrate)}}</strong></p>
          </div>
    </div>
  </div>
  <!-- end col-3 -->
</div>
<div class="row">
<div class="col-md-12">
  <div class="panel panel-inverse" data-sortable-id="index-1">
    <div class="panel-heading">
      <div class="panel-heading-btn">
        <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#newaddress"><i class="fa fa-plus"></i> New Address</button>
      </div>
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
   </div>
   <div class="panel-footer">
         <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#sendmoney"><i class="fa fa-upload" aria-hidden="true"></i> Send </button>
        <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#request" id="request-button"><i class="fa fa-download" aria-hidden="true"></i> Receive </button>
     <a href="{{ route('addresses') }}" class="btn btn-info pull-right">All Adresses</a>

   </div>
 </div>
</div>   
</div>

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


<!-- Modal -->
<div id="newaddress" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i>New Address</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('create.address') }}">
        	{{csrf_field()}}
        	<div class="form-group">
        		<label>Label</label>
        		<input type="text" name="label" class="form-control" placeholder="Optional.Eg: My Wallet">
        	</div>
        	<div class="form-group">
        		<button class="btn btn-success btn-block btn-lg" type="submit">Create</button>
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!--Send Money -->

<div id="sendmoney" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send BTC</h4>
      </div>
      <div class="modal-body text-center">
        <form action="{{route('send.money')}}" method="POST">
          {{csrf_field()}}
          <div class="form-group">
            <label>Send From</label>
            <select class="form-control" name="fromad" id="fromad">
              @foreach($sendad as $adr)
               <option  value="{{$adr->id}}">{{$adr->label}}- {{$adr->address}} - ( {{$adr->balance}} BTC )</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>To</label>
            <input type="text" name="toid" id="toadd" class="form-control input-sz" placeholder="Enter Wallet Address" required>
          </div>
          <div class="form-group">
            <label>Amount</label>
            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-5">
                    <div class="input-group">
                  <input type="text" name="amount" class="form-control" id="amount" required>
                  <span class="input-group-addon">
                    BTC
                  </span>
                  </div>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12">
                    <i class="fa fa-arrows" aria-hidden="true"></i>
                </div>
                <div class="col-sm-12 col-xs-12 col-md-5">
                    <div class="input-group">
                     <input type="text" id="usd" class="form-control" readonly>
                    <span class="input-group-addon">{{$gnl->cur}}</span>
                    </div>
                </div>
            </div>
          </div>
        <div class="form-group">
                 <label>
                    Transaction Fee: <strong id="tfee"></strong> BTC      
                </label>
            </div
          
          <div class="form-group">
            <button class="btn btn-primary btn-lg btn-block">
              Send Money
            </button>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>

<!-- Request Modal -->
<div id="request" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Receive BTC</h4>
      </div>
      <div class="modal-body text-center">
         <div class="form-group">
            <label>Receive To</label>
            <select class="form-control" name="toacc" id="toacc">
              @foreach($sendad as $adr)
               <option  value="{{$adr->id}}">{{$adr->label}}- {{$adr->address}} - ( {{$adr->balance}} BTC )</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Amount</label>
             <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-5">
                 <div class="input-group">
                  <input type="text" name="btcamount" class="form-control" id="btcamount" required>
                  <span class="input-group-addon">
                    BTC
                  </span>
                  </div>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12">
             
                    <i class="fa fa-arrows" aria-hidden="true"></i>
                  </div>
                <div class="col-sm-12 col-xs-12 col-md-5">
                   <div class="input-group">
                    <input type="text" id="usdamount" class="form-control">
                    <span class="input-group-addon">{{$gnl->cur}}</span>
                 </div>
            </div>
          </div>
        <p>Copy and share this code to Request BTC</p>
        <p id="qrcode" style="min-height:300px; min-width:300px;">Enter Amount to Get Code</p>
        <div class="form-group">
          <div class="input-group">
          <input id="code" placeholder="Enter Amount to Get Code" class="form-control input-lg">
          <span class="btn btn-success input-group-addon" id="copybtn">Copy</span>
        </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Ajax Get Data -->
<script>
  $(document).ready(function(){
      
    $("#toacc").change(function()
    {

        
        var toaccount = $( "#toacc" ).val();
        var bitamo = $("#btcamount").val();
        getAjaxfun(toaccount,bitamo);
    });

     $("#btcamount").keyup(function()
     {
          var toaccount = $( "#toacc" ).val();
          var bitamo = $("#btcamount").val();
          getAjaxfun(toaccount,bitamo);
    }); 
     
    $("#usdamount").keyup(function()
     {
          var toaccount = $( "#toacc" ).val();
          var bitamo = $("#btcamount").val();
          getAjaxfun(toaccount,bitamo);
    });
     
    function getAjaxfun(toaccount, bitamo)
      {
          $.ajax({
               type:'GET',
               url:'{{ route('receive.btc') }}',
                data:
              {
                'toacc':toaccount,
                'btcamount':bitamo
              },
               success:function(data)
               {
                  console.log(data);
                  $('#qrcode').html(data.qcode);
                  $('#code').val(data.code);
               },
              error:function(res){
                $('#code').text('Enter Valid Amount and Wallet ID');
              }
          });
      }
  });
</script>

<!-- Transaction Fee -->
<script type="text/javascript">
$(document).ready(function(){

    $("#toadd").keyup(function(){
        //         var frmac = $( "#fromad" ).val();
        // alert(frmac);
        
        
        
        $('#tfee').text(0);
    var jadd = $( "#toadd" ).val();
    var amount = $( "#amount" ).val();

    $.ajax({
      type: "POST",
      url:"{{route('tran.fee')}}",
      data:{
        'toid':jadd,
        'amount':amount
      },
      success:function(data){
          if(data.length<12){
         $('#tfee').text(data);
}else{
      $('#tfee').text('Enter Valid Wallet To send &  Try With A Lower Amount of');
}
      },
      error:function(res){
  $('#tfee').text('Enter Valid Wallet To send & Valid Amount of');

      }
    });

  });

  $("#amount").keyup(function(){
        $('#tfee').text(0);
    var jadd = $( "#toadd" ).val();
    var amount = $( "#amount" ).val();

     $.ajax({
      type: "POST",
      url:"{{route('tran.fee')}}",
      data:{
        'toid':jadd,
        'amount':amount
      },
      success:function(data){
          if(data.length<12){
         $('#tfee').text(data);
}else{
      $('#tfee').text('Enter Valid Wallet To send &  Try With A Lower Amount of');
}
      },
      error:function(res){
  $('#tfee').text('Enter Valid Wallet To send & Valid Amount of');

          
      }
    });

  });
});
</script>

<!-- change Receive Value -->
<script type="text/javascript">
         $(document).ready(function(){

               $("#btcamount").keyup(function(){
                 var bdata = $("#btcamount").val();
                 var btcrate = {{$btcrate}};
                 var btotal = bdata*btcrate;
                 $("#usdamount").val(btotal);
                 });

               $("#usdamount").keyup(function(){
                 var udata = $("#usdamount").val();
                 var btrate = {{$btcrate}};
                 var utotal = udata/btrate;
                 $("#btcamount").val(utotal);
                 });
          });
       </script>


<!-- change Send Value -->
<script type="text/javascript">
         $(document).ready(function(){

               $("#amount").keyup(function(){
                 var data = $("#amount").val();
                 var rate = {{$btcrate}};
                 var total = data*rate;
                 $("#usd").val(total);
                 });

               $("#usd").keyup(function(){
                 var data = $("#usd").val();
                 var rate = {{$btcrate}};
                 var total = data/rate;
                 $("#amount").val(total);
                 });

          });

       </script>

<!--Copy Data -->
<script type="text/javascript">
  document.getElementById("copybtn").onclick = function()
  {
    document.getElementById('code').select();
    document.execCommand('copy');
  }
</script>

@endsection
