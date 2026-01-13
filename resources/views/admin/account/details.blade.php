@extends('admin.layouts.master')
@section('title','Account Detail')


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
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Info</h3>
                        </div>
                        <hr>                        
                        <div class="row mt-3">
                            {{-- for image --}}
                            <div class="col-3 offset-2">
                                     {{-- insert image with if conditional statement --}}
                                     @if(Auth::user()->image == null)
                                                {{-- female or male condition --}}
                                                @if(Auth::user()->gender == 'Male') 
                                                <img src="{{asset('image/default_user.jpg')}}" alt="" class="img-thumbnail shadow-sm">                                                   
                                                @else
                                                <img src="{{asset('image/female.jpg')}}" alt="" class="img-thumbnail shadow-sm">                                                   
                                                @endif
                                                {{-- female or male condition --}}                                                                                                             
                                     @else
                                     <img src="{{asset('storage/'.Auth::user()->image)}}" class="shadow-sm" />
                                     @endif
                                      {{-- insert image with if conditional statement --}} 
                            </div>                            
                            {{-- for detail information --}}
                            <div class="col-5 offset-1">
                                <h4 class="my-3"><i class="fa-solid fa-user-pen me-2"></i>{{Auth::user()->name}}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-envelope me-2"></i>{{Auth::user()->email}}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-phone me-2"></i>{{Auth::user()->phone}}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-person-half-dress me-2"></i>{{Auth::user()->gender}}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-address-card me-2"></i>{{Auth::user()->address}}</h4>                                           
                                <h4 class="my-3"><i class="fa-solid fa-user-clock me-2"></i>{{Auth::user()->created_at->format('j/F/Y')}}</h4>                                           
                            
                            </div>

                     </div>                            
                              {{-- update button function --}}
                                <div class="row">
                                    <div class="col-4 offset-2 mt-3">
                                       <a href="{{route('admin#editProfile')}}">
                                                <button class="btn btn-dark text-white">
                                                    <i class="fa-solid fa-pen-to-square me-2"></i> Edit Profile

                                                </button>
                                       </a>
                                    </div>
                                </div>
                    </div>

                   
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection