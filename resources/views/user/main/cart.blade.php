
   @extends('user.layouts.master')
   @section('title','Cart Page')
   @section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="datatable">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        {{-- loop table row --}}
                       @foreach ($cartList as $c)
                       <tr>
                        {{-- <input type="hidden" name="" value="{{$c->pizza_price}}" id="price"> --}}
                        <td class="align-middle"><img src="{{asset('Storage/'.$c->product_image)}}" class="img-thumbnail shadow-sm" alt="" width="100px"></td>
                        <td class="align-middle">{{$c->pizza_name}} 
                            <input type="hidden" class="orderId" value="{{$c->id}}">
                            <input type="hidden" class="productId" value="{{$c->product_id}}">
                            <input type="hidden" class="userId" value="{{$c->user_id}}">
                        </td>
                        <td class="align-middle" id="price">{{$c->pizza_price}} Ks</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-warning btn-minus" >
                                    <i class="fa fa-minus text-white"></i>
                                    </button>
                                </div>
                                
                                <input type="text" class="form-control form-control-sm border-0 text-center" value="{{$c->qty}}" id="qty">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-warning btn-plus">
                                        <i class="fa fa-plus text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle col-3" id="total">{{$c->pizza_price * $c->qty}} Ks</td>
                        <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i class="fa fa-times"></i></button></td>
                      </tr>                           
                       @endforeach
                       {{-- loop table row --}}
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
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
                        <button class="btn btn-block btn-warning font-weight-bold my-3 py-3 text-white" id="orderBtn"> <span class="text-white">Proceed To Checkout</span></button>
                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3 text-white" id="clearBtn"> <span class="text-white">Clear Cart</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
   @endsection
   @section('scriptSource')
        <script src="{{asset('js/cart.js')}}"></script>

        <script>
            $('#orderBtn').click(function(){
            // console.log("order.....");
        //looping with array
         $orderList=[];         
         //get ramdon number 0 t0 10000
         $random=Math.floor(Math.random() * 100000000001);
                 // take userid
            $('#datatable tbody tr').each(function(index,row){
                $orderList.push({
                    'user_id': $(row).find('.userId').val(),
                    'product_id':$(row).find('.productId').val(),
                    'qty':$(row).find('#qty').val(),
                    'total': Number($(row).find('#total').text().replace("Ks","")),
                    'order_code':'CL-POS'+$random,
                });
        });


        // console.log($orderList);
         // sending data to server with ajax 
        $.ajax({
                //method type
                type :'get' ,
                //call data url link
                url :'http://127.0.0.1:8000/user/ajax/order',
                //data to take
                // object .assign () mean that covert array to object data type.
                data : Object.assign({},$orderList),
                // data format
                dataType :'json',
                // get success data function, response parameter mean data,
                success:function(response){
                    // console.log(response);
                    if(response.status == 'true'){
                        // redirect page.
                        window.location.href = "http://127.0.0.1:8000/user/homePage";
                    }
                    
                }               
            })
          
       })
        //  function for clear cart button        
        $('#clearBtn').click(function(){
                //  id datatabel > tbody> tr all remove
                $('#datatable tbody tr').remove();
                // change total price to 0kyats
                $('#subTotalPrice').html("0 Kyats");

                // change final price to 3000 kyats
                $('#finalPrice').html("3000 Kyats");


                // calling ajax for deleting data into database
                $.ajax({
                //method type
                type :'get' ,
                //call data url link
                url :'http://127.0.0.1:8000/user/ajax/clear/cart',
                 // data format
                dataType :'json',
                              
            })
        })


        
        // remove current product 
          $('.btnRemove').click(function(){
        $parentNode=$(this).parents("tr");
        $productId=$parentNode.find(".productId").val();
         $orderId=$parentNode.find(".orderId").val();
       $.ajax({
                //method type
                type :'get' ,
                //call data url link
                url :'http://127.0.0.1:8000/user/ajax/clear/current/product',
                data:{'productId':$productId, 'orderId':$orderId} ,
                // data format
                dataType :'json',
                              
            })
             $parentNode.remove();
             $totalPrice=0;
        //row prepresent as one line of data.
        $('#datatable tbody tr').each(function(index,row){
            $totalPrice +=  Number($(row).find('#total').text().replace("Ks",""));
        });
        // console.log($totalPrice);
        $('#subTotalPrice').html(`${$totalPrice} Ks`);
        //total price
        $('#finalPrice').html($totalPrice + 3000 +" Ks");
        
        
    })

       </script>
   @endsection


    