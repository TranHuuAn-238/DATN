@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin khách đặt hàng
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

            
            <th style="width:30px;"></th>
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
    <div class="panel-heading">
      Thông tin vận chuyển
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
            <th>SĐT liên hệ</th>

            
            <th style="width:30px;"></th>
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
    <div class="panel-heading">
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
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                
              </label>
            </th>
            <th>Tên xe</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng đơn</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
         
        @foreach($order_by_id as $value_content)
          <tr>        
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $value_content->product_name }}</td>
            <td>{{ $value_content->product_sales_quantity }}</td>
            <td>{{ $value_content->product_price }}</td>
            <td>{{ $value_content->order_total }}</td>
            
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