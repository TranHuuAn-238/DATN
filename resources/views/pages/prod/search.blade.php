@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
        <h2 class="title text-center">Kết quả tìm kiếm cho xe "{{ $keywords }}"</h2>
        @foreach($search_product as $key => $product)
        <div class="col-sm-4" style="height: 440px;">
            <div class="product-image-wrapper">

                <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                @csrf
                                <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">                           
                                <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" height="200" width="150" />
                                <h2>{{number_format($product->product_price).' VNĐ'}}</h2>
                                <p>{{$product->product_name}}</p>
                            </a>
                                <!-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a> -->
                                <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm vào giỏ</button>
                            
                                <input style="margin-top: -25px;" type="button" data-toggle="modal" data-target="#xemnhanh" class="btn btn-default xemnhanh" data-id_product="{{$product->product_id}}" name="add-to-cart" value="Xem nhanh">
                            </form>
                        </div>
                        <!-- <div class="product-overlay">
                            <div class="overlay-content">
                                <h2>$56</h2>
                                <p>{{$product->product_desc}}</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                        </div> -->
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào yêu thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
</div><!--features_items-->
<!-- Modal -->
<div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 style="text-align: center;" class="modal-title" id="">
                <span style="color: brown; font-size: 25px; font-weight: bold;" id="product_quickview_title"></span>
            </h5>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button> -->
        </div>
        <div class="modal-body">
            <style type="text/css">
                span#product_quickview_content img {
                    width: 100%;
                }

                /* điện thoại */
                @media screen and (min-width: 768px) {
                    .modal-dialog {
                        width: 700px;
                    }
                    .modal-sm {
                        width: 350px;
                    }
                }

                /* ipad trở lên */
                @media screen and (min-width: 992px) {
                    .modal-lg {
                        width: 1200px;
                    }
                }
            </style>
            <div class="row">
                <div class="col-md-5">
                    <span id="product_quickview_image"></span>
                </div>

                <form action="">
                    @csrf
                    <div id="product_quickview_value"></div>
                    
                <div class="col-md-7">
                    <p style="color: brown; font-size: 20px; font-weight: bold;">Giá sản phẩm: <span id="product_quickview_price"></span></p>
                    <div id="product_quickview_button"></div>

                    <hr>
                    <h4 >Mô tả sản phẩm</h4>
                    <p><span id="product_quickview_desc"></span></p>
                    <p><span id="product_quickview_content"></span></p>
                    
                </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            <button style="margin-top: 0;" type="button" class="btn btn-primary redirect-cart">Tới giỏ hàng</button>
        </div>
        </div>
    </div>
    </div>
    
@endsection