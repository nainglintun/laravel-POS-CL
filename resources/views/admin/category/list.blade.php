@extends('admin.layouts.master')
@section('title','Category List')


@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Category List</h2>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{route('category#createPage')}}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Add Category
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




                    @if(session('deleteSucess'))

                    {{-- to show a message after delete a category list item --}}
                           <div class="col-4 offset-8">
                               <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-trash"></i> {{session('deleteSucess')}}
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
                <form action="{{route('category#list')}}" method="get">
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
                    <h4><i class="fa-solid fa-database"></i> - {{$categories->total()}}</h4>
                </div>
            </div>
             {{-- total search value show section  --}}



                @if (count($categories)!=0)
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                   

                            {{-- take and show category data from database with looping  --}}
                            @foreach($categories as $category)

                                    <tr class="tr-shadow">
                                            <td>{{$category->id}}</td>
                                            <td class="col-6">{{$category->name}}</td>
                                            <td>{{$category->created_at->format('j-F-Y')}}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    {{-- <button class="item" data-toggle="tooltip" data-placement="top" title="View">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button> --}}
                                                    <a href="{{route('category#edit',$category->id )}}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                    </a>


                                                    <a href="{{route('category#delete',$category->id)}}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </a>


                                                 </div>
                                            </td>
                                    </tr>

                            @endforeach
                             {{-- take and show category data from database with looping  --}}
                        </tbody>
                    </table>

                    {{-- pagination section --}}

                        <div class="mt-3">
                            
                            {{$categories->appends(request()->query())->links()}}
                        </div>

                    {{-- pagination section --}}
                </div>
                @else 
                <h3 class="text-secondary text-center mt-5">There is no Category Here!</h3>
                @endif

                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection




