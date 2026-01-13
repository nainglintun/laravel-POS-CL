
@extends('user.layouts.master')
@section('title','Ordered History Page')
@section('content')
 <!-- Cart Start -->
 <div class="container-fluid" style="height:350px;">
     <div class="row px-xl-5">
         <div class="col-lg-8 offset-2 table-responsive mb-5">
             <table class="table table-light table-borderless table-hover text-center mb-0" id="datatable">
                 <thead class="thead-dark">
                     <tr>
                         
                         <th>Date</th>
                         <th>Order ID</th>
                         <th>Total Price</th>
                         <th>Status</th>
                         
                     </tr>
                 </thead>
                 <tbody class="align-middle">
                     {{-- loop table row --}}
                     @foreach($order as $o) 
                                <tr>
                                    <td class="align-middle">{{$o->created_at->format('F-j-Y')}}</td>
                                    <td class="align-middle">{{$o->order_code}}</td>
                                    <td class="align-middle">{{$o->total_price}}</td>
                                    <td class="align-middle">
                                        @if($o->status ==0)
                                        <span class="text-warning"><i class="far fa-clock me-2"></i> Pending...</span>
                                         @elseif($o->status ==1)
                                         <span class="text-success"><i class="fas fa-check me-2"></i> success...</span>
                                         @elseif($o->status ==2)
                                         <span class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Reject...</span>

                                        @endif

                                    </td>
                                </tr>
                     @endforeach

                    
                    {{-- loop table row --}}
                     
                 </tbody>
             </table>
            <span>
                {{$order->links()}}
            </span>

         </div>
         {{-- <div class="col-lg-4">
             <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
             <div class="bg-light p-30 mb-5">
                 <div class="border-bottom pb-2">
                     <div class="d-flex justify-content-between mb-3">
                         <h6>Subtotal</h6>
                         <h6 id="subTotalPrice">{{$totalPrice}} Ks</h6>
                     </div>
                     <div class="d-flex justify-content-between">
                         <h6 class="font-weight-medium">Delivery</h6>
                         <h6 class="font-weight-medium">3000 Ks</h6>
                     </div>
                 </div>
                 <div class="pt-2">
                     <div class="d-flex justify-content-between mt-2">
                         <h5>Total</h5>
                         <h5 id="finalPrice">{{$totalPrice+3000}} Ks</h5>
                     </div>
                     <button class="btn btn-block btn-warning font-weight-bold my-3 py-3 text-white" id="orderBtn">Proceed To Checkout</button>
                 </div>             </div>
         </div> --}}
     </div>
 </div>
 <!-- Cart End -->
@endsection



 