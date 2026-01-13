@extends('admin.layouts.master')
@section('title','Create Category List')
@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
             <div class="col-lg-10 offset-1">

                <div class="card">
                    <div class="card-body">
                       <div class="ms-5">
                        {{-- back arrow button --}}
                        <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i> 
                       </div>
                        <div class="card-title">
                           
                            <h3 class="text-center title-2">Change Role</h3>
                        </div>
                        <hr>   

                        <form action="{{route('admin#change',$account->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf 
                            <div class="row">
                                                       
                                <div class="col-4 offset-1">
                                        {{-- insert image with if conditional statement --}}
                                        @if($account->image == null)
                                                    {{-- female or male condition --}}
                                                    @if($account->gender == 'Male') 
                                                    <img src="{{asset('image/default_user.jpg')}}" alt="" class="img-thumbnail shadow-sm">                                                   
                                                    @else
                                                    <img src="{{asset('image/female.jpg')}}" alt="" class="img-thumbnail shadow-sm">                                                   
                                                    @endif
                                                    {{-- female or male condition --}}                                                                                                           
                                        @else
                                        <img src="{{asset('storage/'.$account->image)}}" class="shadow-sm" />
                                        @endif
                                        {{-- insert image with if conditional statement --}}

                                        <div class="mt-3">
                                            {{-- update button section --}}
                                                <button class="btn bg-dark text-white col-12" type="submit"><i class="fa-solid fa-circle-chevron-right me-1"></i>Change</button>
                                        </div>
                                    
                                       
                                </div>

                                {{-- input box section--}}
                                <div class="row col-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" disabled name="name" type="text" value="{{old('name',$account->name)}}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin Name">
                                       
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <select name="role" class="form-control">
                                             <option value="admin" @if($account->role == 'admin') selected @endif>Admin</option>
                                             <option value="user" @if ($account->role == 'user') selected @endif>User</option>
                                        </select>
                                        {{-- <input id="cc-pament" name="role" type="text" value="{{old('role',$account->role)}}" class="form-control" aria-required="true" aria-invalid="false" disabled> --}}
                                        
                                    </div>      
                                    

                                    <div class="form-group">
                                        <label class="control-label mb-1">E-Mail</label>
                                        <input id="cc-pament" disabled name="email" type="text" value="{{old('email',$account->email)}}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin email">

                                     </div>

                                    
                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" disabled name="phone" type="text" value="{{old('phone',$account->phone)}}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin Phone">
                                       
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Gender</label>
                                        <select name="gender" disabled class="form-control">
                                                <option value="">Choose Gender......</option>
                                                <option value="Male" @if($account->gender =='Male') selected @endif >Male</option>                                            
                                                <option value="Female" @if($account->gender =='Female') selected @endif >Female</option>
                                        </select>
                                    
                                    </div>

                                  <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                       <textarea name="address" disabled class="form-control" id="" cols="30" rows="10" placeholder="Enter Admin Address">{{old('address',$account->address)}}</textarea>
                                      
                                    </div>
                                                                       
                                                                                                  
                                    
                                </div>
    
                            </div> 

                           
                            
                        
                        </form>                         
                             
                    </div>

                   
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection