@extends('layouts.simple.master')
@section('title', 'Product Page')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Product Page</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Country</li>
<li class="breadcrumb-item active">Coiuntry Details</li>
@endsection

@section('content')
<div class="container-fluid">
   <div>
      <div class="row product-page-main p-0">

         <div>
            <div class="card">
               <div class="card-body">
                  <div class="product-page-details">
                     <h3>{{$country->slug}}</h3>
                  </div>
                  <ul class="product-color">
                     <li class="bg-primary"></li>
                     <li class="bg-secondary"></li>
                     <li class="bg-success"></li>
                     <li class="bg-info"></li>
                     <li class="bg-warning"></li>
                  </ul>
                  <hr>
                  <p>Description</p>
                  <hr>
                  <div>
                     <table class="product-page-width">
                        <tbody>
                           <tr>
                              <td> <b>Slug &nbsp;&nbsp;&nbsp;:</b></td>
                              <td>{{$country->slug}}</td>
                           </tr>
                           <tr>
                              <td> <b>Title &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                              <td class="txt-success">{{$country->title}}</td>
                           </tr>
                           <tr>
                              <td> <b>ISO-Code-2 &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                              <td>{{$country->iso_code_2}}</td>
                           </tr>
                           <tr>
                              <td> <b>Currency &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                              <td>{{$country->currency_id}}</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-md-6">
                        <h6 class="product-title">share it</h6>
                     </div>
                     <div class="col-md-6">
                        <div class="product-icon">
                           <ul class="product-social">
                              <li class="d-inline-block"><a href="#"><i class="fa fa-facebook"></i></a></li>
                              <li class="d-inline-block"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                              <li class="d-inline-block"><a href="#"><i class="fa fa-twitter"></i></a></li>
                              <li class="d-inline-block"><a href="#"><i class="fa fa-instagram"></i></a></li>
                              <li class="d-inline-block"><a href="#"><i class="fa fa-rss"></i></a></li>
                           </ul>
                           <form class="d-inline-block f-right"></form>
                        </div>
                     </div>
                  </div>
                  <hr>
                  <div class="m-t-15">
                     <button class="btn btn-primary m-r-10" type="button" title=""> <i class="fa fa-shopping-basket me-1"></i>Add To Cart</button>
                     <button class="btn btn-success m-r-10" type="button" title=""> <i class="fa fa-shopping-cart me-1"></i>Buy Now</button><a class="btn btn-secondary" href="#"> <i class="fa fa-heart me-1"></i>Add To WishList</a>
                  </div>
               </div>
            </div>
         </div>

      </div>
   </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{asset('assets/js/rating/rating-script.js')}}"></script>
<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/ecommerce.js')}}"></script>
@endsection
