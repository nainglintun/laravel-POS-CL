<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct category list page
   public function list(){
    // take data from database.
    // $categories = Category::orderBy('id','desc')->paginate(4);

    // take data from database with search function to get user input data.
    $categories = Category::when(request('key'),function($query){
            $query->where('name','like','%'. request('key') .'%');                        
    })->orderBy('id','desc')->paginate(5);
    $categories->appends(request()->all());
    //convert raw data to array format of data from database.
    // dd($categories->toArray());
    // as to show object data from database.
    // dd($categories);
    // direct to the list page.
    return view('admin.category.list',compact('categories'));
    }

    // direct category create page
    public function createPage(){
        return view('admin.category.create');
    }


    // for category create button 
    public function create(Request $request){
        // dd($request->all());
        $this->categoryValidationCheck($request);
        // convert user data to array format 
        $data = $this->requestCategoryData($request);

        // create data in category 
        // note to import the class of category
        Category::create($data);
          
        // go to the following page after finishing the above funtion.
        return redirect()->route('category#list')->with(['createSuccess'=>'Category Created....']);

    }


    // for delete function to  delete each category list items.
    public function delete($id){
        // dd($id);
        Category::where('id',$id)->delete();
        return back()->with(['deleteSucess'=>'Category Deleted....']);
    }



    // for edit function to edit each category list items. 
    public function edit($id){
        $category=Category::where('id',$id)->first();
        // take data from the orginal name.
        return view('admin.category.edit',compact('category'));        
    }
    

    // update function for update each category items.
    // request mean the input value of user.
    public function update(Request $request){        
        // dd($id,$request->all());

        //validate with validation rules
        $this->categoryValidationCheck($request);

        // convert user data to array format and take data. 
        $data = $this->requestCategoryData($request);

        // update data
        Category::where('id',$request->categoryId)->update($data);

        // redirect to the category list page.
                return redirect()->route('category#list');
    }



    // private function for category validation rule 
    private function categoryValidationCheck($request){
        Validator::make($request->all(),[
            'categoryName'=>'required|min:5|unique:categories,name,'.$request->categoryId
        ])->validate();

    }

    // private function for request category data
    private function requestCategoryData($request){
                return [
                    'name'=>$request->categoryName
                ];
    }
}


