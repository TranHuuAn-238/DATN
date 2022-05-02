@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách mã giảm giá
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
            <!-- <th style="width:20px;">
              <label class="i-checks m-b-none">
                
              </label>
            </th> -->
            <th>STT</th>
            <th>Tên mã giảm giá</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Code mã giảm giá</th>
            <th>Số lượng mã</th>
            <th>Loại mã</th>
            <th>Giảm</th>
            <th>Trạng thái</th>
            <th>Hết hạn</th>
            {{-- <th>Mô tả</th> --}}
            
            <th style="width:30px;">Quản lý</th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupon as $key => $cou)
          <tr>
            <!-- <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td> -->
            <td>{{$key + 1}}</td>
            <td>{{ $cou->coupon_name }}</td>
            <td>{{ $cou->coupon_date_start }}</td>
            <td>{{ $cou->coupon_date_end }}</td>
            <td>{{ $cou->coupon_code }}</td>
            <td>{{ $cou->coupon_time }}</td>
            <td><span class="text-ellipsis">
                <?php
                    if($cou->coupon_condition == 1) {
                ?>
                        Giảm % đơn
                <?php
                    } else {
                ?>
                        Giảm tiền
                <?php
                    }
                ?>
            </span></td>

            <td><span class="text-ellipsis">
                <?php
                  if($cou->coupon_condition == 1) {
                ?>
                      -{{ $cou->coupon_discount }} %
                <?php
                  } else {
                ?>
                      -{{ number_format($cou->coupon_discount,0,',','.') }} VNĐ
                <?php
                  }
                ?>
              </span></td>
            <td>
              @if ($cou->coupon_status == 1)
                <a href="{{ URL::to('/unactive-coupon/'.$cou->coupon_id) }}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
              @else
                <a href="{{URL::to('/active-coupon/'.$cou->coupon_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
              @endif
            </td>
            <td>
              @if (strtotime($today) > strtotime($cou->coupon_date_end))
                <span style="color: red;">Đã hết hạn</span>
              @else
                <span style="color: green;">Còn hạn</span>
              @endif
            </td>
            {{-- <td>{{ $cou->coupon_desc }}</td> --}}
            <td>
              <a href="{{URL::to('/edit-coupon/'.$cou->coupon_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
              <a onclick="return confirm('Bạn chắc chắn muốn xóa mã giảm giá {{ $cou->coupon_code }}?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active styling-edit" ui-toggle-class="">  
                <i class="fa fa-times text-danger text"></i>
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
          <span> {{ $coupon->links("pagination::bootstrap-4") }} </span>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection