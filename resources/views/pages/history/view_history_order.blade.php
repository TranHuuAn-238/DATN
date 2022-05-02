@extends('layout')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading" style="text-align: center; text-transform: uppercase;">
      Chi tiết đơn đặt hàng
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
            
            <th>Tên khách đặt</th>
            <th>Số điện thoại liên hệ</th>

            
            
          </tr>
        </thead>
        <tbody>
        @foreach($order_by_id as $value_content)
          <tr>
           
            <td>{{ $value_content->customer_name }}</td>
            <td>{{ $value_content->customer_phone }}</td>
            
            
          </tr>
          @break;
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
</div>

<br>

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading" style="text-align: center; text-transform: uppercase;">
      Thông tin nhận hàng
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
            
            <th>Người nhận</th>
            <th>Địa chỉ</th>
            <th>SĐT người nhận</th>

            
        
          </tr>
        </thead>
        <tbody>
        @foreach($order_by_id as $value_content) 
          <tr>
           
            <td>{{ $value_content->shipping_name }}</td>
            <td>{{ $value_content->shipping_address }}</td>
            <td>{{ $value_content->shipping_phone }}</td>
            
          </tr>
          @break;
        @endforeach  
        </tbody>
      </table>
    </div>
    
  </div>
</div>

<br><br>

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading" style="text-align: center; text-transform: uppercase;">
      Liệt kê chi tiết đơn đặt hàng
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
            <th>Tên xe</th>
            <th>Số lượng</th>
            <th>Giá (VNĐ)</th>
            
          </tr>
        </thead>
        <tbody>
         
        @foreach($order_by_id as $key => $value_content)
          <tr>        
            <td>{{$key+1}}</td>
            <td>{{ $value_content->product_name }}</td>
            <td>{{ $value_content->product_sales_quantity }}</td>
            <td>{{ number_format($value_content->product_price) }}</td>
            
          </tr>
        @endforeach

        @if ($value_content->order_coupon !== null)
          <tr>
            <td colspan="3"><b>Mã khuyến mãi áp dụng: </b></td>
            <td><i>
              {{ $value_content->order_coupon }}
            </i></td>
          </tr>
        @else
        <tr>
          <td colspan="3"><b>Mã khuyến mãi áp dụng: </b></td>
          <td><i>
              Không có mã
          </i></td>
        </tr>
        @endif
          
          <tr>
            <td colspan="3"><b>Phí vận chuyển: </b></td>
            <td>{{ number_format($value_content->shipping_fee) }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"><b>Tổng đơn: </b></td>
            <td>{{ number_format($value_content->order_total) }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <!-- <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div> -->
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection