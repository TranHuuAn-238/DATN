@extends('layout')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading" style="text-align: center; text-transform: uppercase;">
      <b>Các đơn đặt hàng đã đặt</b>
    </div>
    <div class="row w3-res-tb">
      <!-- <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div> -->
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Tìm kiếm</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
                        <?php
                            $message = Session::get('message');
                            if($message) {
                                echo '<span class="text-alert">' . $message . '</span>';
                                Session::put('message',null);
                                // hiển thị thông báo 1 lần thôi
                            }
                        ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên khách hàng</th>
            <th>Thời gian đặt</th>
            <th>Tổng đơn</th>
            <th style="width: 200px">Xem chi tiết đơn đặt</th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_order as $key => $order)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->order_date }}</td>
            <td>{{ $order->order_total }}</td>     
            <td>
              <a href="{{URL::to('/view-history-order/'.$order->order_id)}}" class="active styling-edit" ui-toggle-class="">
                Xem chi tiết
              </a>
              
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <!-- <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div> -->
        <div class="col-sm-7 text-right text-center-xs">                
          <span> {{ $all_order->links("pagination::bootstrap-4") }} </span>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection