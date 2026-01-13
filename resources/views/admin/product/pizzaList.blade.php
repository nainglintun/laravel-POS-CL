@extends('admin.layouts.master')
@section('title','View all Products')



@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Products List</h2>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{route('product#createPage')}}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Add PIZZA
                            </button>  
                        </a>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="fa-solid fa-file-arrow-down"></i> CSV download
                        </button>  
                    </div>
                </div>
                
               {{-- to show a create suceess message box using function --}}
                    @if(session('createSuccess'))

                         {{-- to show a message after delete a category list item --}}
                                <div class="col-4 offset-8">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-check"></i> {{session('createSuccess')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            {{-- to show a message after delete a category list item --}}
                    @endif

                    {{-- to show a create suceess message box using function --}}

                   @if(session('deleteSuccess'))

                    {{-- to show a message after delete a category list item --}}
                           <div class="col-7 offset-5">
                               <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-trash"></i> {{session('deleteSuccess')}}
                                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                               </div>
                           </div>
                       {{-- to show a message after delete a category list item --}}
               @endif
              
                 {{-- create search box data searching in this category list page--}}
                 <div class="col-3">
                    <h4 class="text-secondary">Search Key:<span class="text-danger">{{request('key')}}</span></h4>
                </div>
                <div class="mb-3 col-4 offset-8">
                <form action="{{route('product#list')}}" method="get">
                    @csrf
                        <div class="d-flex">
                                <input type="text" name="key" class="form-control" placeholder="Search.." value="{{request('key')}}">
                                <button class="btn bg-dark text-white" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>                          
                                </button>
                        </div>
                </form>
                </div>
            {{-- create search box data searching in this category list page--}}

            {{-- total search value show section  --}}
            <div class="row my-2">
                <div class="col-1 text-center offset-10 p-2 bg-white shadow-sm ">
                    <h4><i class="fa-solid fa-database"></i> -{{$pizzas->total()}} </h4>
                </div>
            </div>


                @if(count($pizzas)!=0)
             {{-- total search value show section  --}}                
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>View-Count</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                   

                            @foreach($pizzas as $p)
                            <tr class="tr-shadow">
                                {{-- insert image way from the database and project --}}
                                <td class="col-2"><img src="{{asset('storage/'.$p->image)}}" alt="" class="img-thumbnail shadow-sm"></td>
                                <td class="col-3">{{$p->name}}</td>
                                <td class="col-2">{{$p->price}}</td>
                                <td class="col-2">{{$p->category_name}}</td>
                                <td class="col-2"><i class="fa-solid fa-eye"></i> - {{$p->view_count}}</td>
                                <td class="col-2">
                                    <div class="table-data-feature">
                                        <a href="{{route('product#edit',$p->id)}}">
                                            <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </a>
                                        <a href="{{route('product#updatePage',$p->id)}}">
                                            <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </a>


                                        <a href="{{route('product#delete',$p->id)}}">
                                            <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </a>


                                     </div>
                                </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                   {{-- pagination section --}}
                        <div class="mt-3">
                            {{$pizzas->links()}}
                        </div>
                    {{-- pagination section --}}
                </div>
             <!-- END DATA TABLE -->
             @else 
             <h3 class="text-secondary text-center mt-5">There is no Pizza Here!</h3>
             @endif
            </div>
        </div>
    </div>
</div>
@endsection




