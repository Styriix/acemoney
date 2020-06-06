@extends('admin.layout.master')

@section('content')

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="index.html">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Dashboard</span>
        </li>
    </ul>

</div>

<h3 class="page-title"> Dashboard 
    <small>dashboard & statistics </small>
</h3>
@php
   $totalusers = \App\User::where('status','1')->count();
   $banusers = \App\User::where('status','0')->count();
   $trans = \App\Transaction::orderBy('id', 'desc')->paginate(10);
   $total = \App\Transaction::count();
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users"></i> USERS STATISTICS </div>
                </div>
                <div class="portlet-body text-center">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$totalusers}}">{{$totalusers}}</span>
                                    </div>
                                    <div class="desc"> Total User </div>
                                </div>
                                <a class="more" href="{{route('users')}}"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                       
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat red">
                                <div class="visual">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$banusers}}">{{$banusers}}</span>
                                    </div>
                                    <div class="desc"> Banned Users </div>
                                </div>
                                <a class="more" href="{{route('users')}}"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat purple">
                                <div class="visual">
                                    <i class="fa fa-exchange"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$total}}">{{$total}}</span>
                                    </div>
                                    <div class="desc"> Total Transactions </div>
                                </div>
                                <a class="more" href="{{route('users.transactions')}}"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

      <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">

            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>User Transactions </div>
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
                </div>

            </div>
        </div>




@endsection
