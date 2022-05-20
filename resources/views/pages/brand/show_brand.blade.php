@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
        @foreach($brand_name as $key => $brand_two)
        <h2 class="title text-center">Thương hiệu {{$brand_two->brand_name}}</h2>
        @endforeach

        <div class="row">
            <div class="col-md-4">
                <label for="amount">Bộ lọc giá sản phẩm (VNĐ)</label>
                <form action="">
                    <div id="slider-range2"></div>
                    <style type="text/css">
                        .style-range p {
                            float: left;
                            width: 50%;
                        }
                    </style>
                    <div class="style-range">
                        <p><input type="text" id="amount_start2" readonly style="border:0; color:blue; font-weight:bold;"></p>
                        <p><input type="text" id="amount_end2" readonly style="border:0; color:blue; font-weight:bold;"></p>
                    </div>
                    

                    <input type="hidden" name="start_price" id="start_price2">
                    <input type="hidden" name="end_price" id="end_price2">

                    <?php 
                        if(isset($_GET['start_price']) && isset($_GET['end_price'])) {
                            $min = $_GET['start_price'];
                            $max = $_GET['end_price'];
                
                            if($min != '' && $max != '') {
                    ?>
                    <p style="color: green;">Giá từ {{number_format($min)}} VNĐ đến {{number_format($max)}} VNĐ</p>
                    <?php
                            }
                        }
                    ?>

                    
                    <div class="clearfix"></div>
                    {{-- submit đẩy giá trị lên url --}}
                    <input type="submit" name="filter_price" value="Lọc giá" class="btn btn-primary">
                    <br><br>
                </form>
            </div>
        </div>

        @foreach($brand_by_id as $key => $product)
        <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
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
                            <input type="button" value="Thêm vào giỏ" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
                        
                            <input style="margin-top: -25px;" type="button" data-toggle="modal" data-target="#xemnhanh" class="btn btn-default xemnhanh" data-id_product="{{$product->product_id}}" name="add-to-cart" value="Xem nhanh">
                        </form>
                        </div>
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào yêu thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>
        </a>
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
    <!--category-tab-->
    <!-- <div class="category-tab">
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tshirt" data-toggle="tab">T-Shirt</a></li>
            
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tshirt" >
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{('public/frontend/images/gallery1.jpg')}}" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                            
                        </div>
                    </div>
                </div>	
                

            </div>
            
            
        </div>
    </div> -->
    <!--/category-tab--> <!--recommended_items-->
    <!-- <div class="recommended_items">
        <h2 class="title text-center">recommended items</h2>
        
        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">	
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">	
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />>
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
                </a>			
        </div>
    </div> -->
    <!--/recommended_items-->
    <div class="col-sm-7 text-right text-center-xs">                
      <span> {{ $brand_by_id->links("pagination::bootstrap-4") }} </span>
    </div>
@endsection