@extends('user.layouts.master')

@section('title','Customer Home Page')


@section('content')
       <!-- Shop Start -->
    <div class="container-fluid">
      <div class="row px-xl-5">
          <!-- Shop Sidebar Start -->
          <div class="col-lg-3 col-md-4">
              <!-- Price Start -->
              <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary p-2">Filter by Categories</span></h5>
              <div class="bg-light p-4 mb-30">
                  <form>
                      <div class="d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1">
                          <label class="mt-2" for="price-all">Category</label>
                          {{-- show all category qualtity --}}
                          <span class="badge border font-weight-normal">{{count($category)}}</span>
                      </div>
                      <hr class="bg-primary">  
                      <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="{{route('user#home')}}" class="text-dark"><label class="" for="price-1">All</label></a>
                       {{-- <span class="badge border font-weight-normal">150</span> --}}
                   </div>                    
                    @foreach ($category as $c)
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                 <a href="{{route('user#filter',$c->id)}}" class="text-dark"><label class="" for="price-1">{{$c->name}}</label></a>
                                {{-- <span class="badge border font-weight-normal">150</span> --}}
                            </div>                        
                    @endforeach
                  </form>
              </div>
              <!-- Price End -->
              
              
              <div class="">
                  <button class="btn btn btn-warning w-100">Order</button>
                  
              </div>
              <!-- Size End -->
          </div>
          <!-- Shop Sidebar End -->


          <!-- Shop Product Start -->
          <div class="col-lg-9 col-md-8">
              <div class="row pb-3">
                  <div class="col-12 pb-1">
                      <div class="d-flex align-items-center justify-content-between mb-4">
                          <div>
                                <a href="{{route('user#cartList')}}">
                                        {{-- cart-list --}}                            
                                <button type="button" class="btn bg-dark text-white position-relative">
                                    <i class="fas fa-cart-plus"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{count($cart)}}                                  
                                    </span>
                                </button>
                                {{-- cart-list --}}
                                </a>

                                <a href="{{route('user#history')}}" class="ms-3">
                                        {{-- cart-list --}}                            
                                    <button type="button" class="btn bg-dark text-white position-relative">
                                        <i class="fas fa-history"></i> History
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{count($history)}}                                  
                                        </span>
                                    </button>
                                    {{-- cart-list --}}
                                </a>
                          </div>


                          <div class="ml-2 mt-2">
                              <div class="btn-group">                                
                                <select name="sorting" class="form-control" id="sortingOption">
                                    <option value="">Choose Options...</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>

                                </div>
                              {{-- <div class="btn-group ml-2">
                                  <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item" href="#">10</a>
                                      <a class="dropdown-item" href="#">20</a>
                                      <a class="dropdown-item" href="#">30</a>
                                  </div>
                              </div> --}}                              
                          </div>
                      </div>
                  </div>                                     

                      {{-- product looping section --}}
                        <div class="row" id="dataList">
                            @if(count($pizza) != 0 )
                            @foreach ($pizza as $p)

                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                              <div class="product-item bg-light mb-4" id="myForm">
                                  <div class="product-img position-relative overflow-hidden">
                                      <img class="img-fluid w-100" src="{{asset('storage/'.$p->image)}}" alt="" style="">
                                       <div class="product-action">
                                          <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                          <a class="btn btn-outline-dark btn-square" href="{{route('user#detail',$p->id)}}"><i class="fas fa-info-circle"></i></a>
                                                                                
                                      </div>
                                  </div>
                                  <div class="text-center py-4">
                                      <a class="h6 text-decoration-none text-truncate" href="">{{$p->name}}</a>
                                      <div class="d-flex align-items-center justify-content-center mt-2">
                                          <h5>{{$p->price}} Ks</h5>
                                          {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                      </div>                                    
                                  </div>
                              </div>
                          </div>                          
                            @endforeach
                            @else
                            <h2 class="text-center mt-5 shadow-sm py-5 col-6 offset-3">There is no pizza <i class="fas fa-pizza-slice ms-3"></i></h2>

                            @endif
                        </div>                     
            {{-- product looping section --}}
                  
                 
          <!-- Shop Product End -->
      </div>
  </div>
  <!-- Shop End -->
@endsection

@section('scriptSource')
<script>
     $(document).ready(function(){ 
        // call a data
            // $.ajax({
            //     //method type
            //     type :'get' ,
            //     //call data url link
            //     url :'http://127.0.0.1:8000/user/ajax/pizza/List',
            //     // data format
            //     dataType :'json',
            //     // get success data function, response parameter mean data,
            //     success:function(response){
            //         //show result in console 
            //         console.log(response);

            //     }
            // })
        
           // get value into options
            $('#sortingOption').change(function(){
                $sortingOption = $('#sortingOption').val();
                // console.log($sortingOption);
                // checking with if statement to get for sorting data
            if($sortingOption == 'asc'){
                // call a data
            $.ajax({
                //method type
                type :'get' ,
                //call data url link
                url :'http://127.0.0.1:8000/user/ajax/pizza/List',
                //data to take
                data :{'status':'asc'},
                // data format
                dataType :'json',
                // get success data function, response parameter mean data,
                success:function(response){
                    //show result in console 
                   $list =`  `;
                   for($i=0; $i<response.length;$i++){
                     $list += ` <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                              <div class="product-item bg-light mb-4" id="myForm">
                                  <div class="product-img position-relative overflow-hidden">
                                      <img class="img-fluid w-100" src="{{asset('storage/${response[$i].image}')}}" alt="" style="height:200px;">
                                       <div class="product-action">
                                          <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                          <a class="btn btn-outline-dark btn-square" href=""><i class="fas fa-info-circle"></i></a>
                                                                                
                                      </div>
                                  </div>
                                  <div class="text-center py-4">
                                      <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                      <div class="d-flex align-items-center justify-content-center mt-2">
                                          <h5>${response[$i].price}Ks</h5>
                                          {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                      </div>
                                      {{-- <div class="d-flex align-items-center justify-content-center mb-1">
                                          <small class="fa fa-star text-primary mr-1"></small>
                                          <small class="fa fa-star text-primary mr-1"></small>
                                          <small class="fa fa-star text-primary mr-1"></small>
                                          <small class="fa fa-star text-primary mr-1"></small>
                                          <small class="fa fa-star text-primary mr-1"></small>
                                      </div> --}}
                                  </div>
                              </div>
                          </div>`;
                   }
                   $('#dataList').html($list);
                }
            })                  
                
            }else if($sortingOption == 'desc'){
                
                $.ajax({
                //method type
                type :'get' ,
                //call data url link
                url :'http://127.0.0.1:8000/user/ajax/pizza/List',
                //data to take
                data : {'status':'desc'},
                // data format
                dataType :'json',
                // get success data function, response parameter mean data,
                success:function(response){
                    //show result in console 
                   $list =`  `;
                   for($i=0; $i<response.length;$i++){
                     $list += ` <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                              <div class="product-item bg-light mb-4" id="myForm">
                                  <div class="product-img position-relative overflow-hidden">
                                      <img class="img-fluid w-100" src="{{asset('storage/${response[$i].image}')}}" alt="" style="height:200px;">
                                       <div class="product-action">
                                          <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                          <a class="btn btn-outline-dark btn-square" href=""><i class="fas fa-info-circle"></i></a>
                                                                                
                                      </div>
                                  </div>
                                  <div class="text-center py-4">
                                      <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                      <div class="d-flex align-items-center justify-content-center mt-2">
                                          <h5>${response[$i].price}Ks</h5>
                                          {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                      </div>
                                      {{-- <div class="d-flex align-items-center justify-content-center mb-1">
                                          <small class="fa fa-star text-primary mr-1"></small>
                                          <small class="fa fa-star text-primary mr-1"></small>
                                          <small class="fa fa-star text-primary mr-1"></small>
                                          <small class="fa fa-star text-primary mr-1"></small>
                                          <small class="fa fa-star text-primary mr-1"></small>
                                      </div> --}}
                                  </div>
                              </div>
                          </div>`;
                   }
                   $('#dataList').html($list);
                }

                
            })
            }

            })            

      });

</script>

@endsection