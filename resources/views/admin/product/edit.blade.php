@extends('admin.layouts.master')
@section('title','Each Product Detail')


@section('content')
<div class="main-content">
    <div class="row">
            <div class="col-3 offset-7 mb-2">
                     {{-- to show a create suceess message box using function --}}
                     @if(session('updateSuccess'))
                     {{-- to show a message after delete a category list item --}}
                            <div class="">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fa-solid fa-circle-check"></i> {{session('updateSuccess')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        {{-- to show a message after delete a category list item --}}
                    @endif

                {{-- to show a create suceess message box using function --}}
            </div>
    </div>


    <div class="section__content section__content--p30">
        <div class="container-fluid">
             <div class="col-lg-10 offset-1">

                <div class="card">
                
                    <div class="card-body">
                        {{-- back arrow section --}}
                        <div class="ms-5">
                           {{-- <a href="{{route('product#list')}}">
                            <i class="fa-solid fa-arrow-left text-dark"></i>                            
                           </a> --}}

                           {{-- another way with javascript function and event. --}}
                           <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i> 


                        </div>
                        {{-- back arrow section --}}

                        <div class="card-title">
                            {{-- <h3 class="text-center title-2">Pizza Detail</h3> --}}
                        </div>
                                               
                        <div class="row mt-3">
                            {{-- for image --}}
                            <div class="col-3 offset-2">
                                     {{-- insert image with if conditional statement --}}
                                     <img src="{{asset('storage/'.$pizzas->image)}}" class="shadow-sm" />                                                                        
                                    {{-- insert image with if conditional statement --}} 
                            </div>                            
                            {{-- for detail information --}}
                            <div class="col-7">
                                <span class="my-3 bg-danger text-white text-center w-75 fs-5 btn d-block">{{$pizzas->name}}</span>
                                <span class="my-2 btn btn-dark text-white"><i class="fa-solid fs-5 fa-money-bill-1 me-2"></i>{{$pizzas->price}} Kyats</span>
                                <span class="my-2 btn btn-dark text-white"><i class="fa-regular fs-5 fa-hourglass-half me-2"></i>{{$pizzas->waiting_time}}-mins</span>
                                <span class="my-2 btn btn-dark text-white"><i class="fa-solid fs-5 fa-eye me-2"></i>{{$pizzas->view_count}}</span>
                                <span class="my-2 btn btn-dark text-white"><i class="fa-solid fa-clone me-2"></i>{{$pizzas->category_name}}</span>
                                <span class="my-2 btn btn-dark text-white"><i class="fa-solid fs-5 fa-user-clock me-2"></i>{{$pizzas->created_at->format('j/F/Y')}}</span>
                                <div class="my-2"><i class="fa-solid fs-5 fa-file-lines me-2"></i>Detail:</div>
                                <div class="text-justify my-2 me-2 h6" style="text-indent:20px;">{{$pizzas->description}}</div>
                                                                                                
                            </div>
                     </div>                            
                             
                    </div>                   
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection