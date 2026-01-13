<?php

namespace App\Http\Controllers;
use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function list(){
        // get all data from product table of database.
        $pizzas = Product::select('products.*','categories.name as category_name')
        ->when(request('key'),function($query){
            $query->where('products.name','like','%'.request('key').'%');
        })
        ->leftJoin('categories','products.category_id','categories.id')
        -> orderBy('products.created_at','desc')->paginate(3);
        $pizzas->appends(request()->all());

        // dd($pizzas->toArray());
        // output with compact method.
        return view('admin.product.pizzaList',compact('pizzas'));
    }
    //direct pizza create page.
    public function createPage(){
        //call all data from category table
        // $Categories=Category::get();
        // call id and name from category table
        $Categories=Category::select('id','name')->get();
        // trial view with dd function
        // dd($Categories->toArray());
        return view('admin.product.create',compact('Categories'));
        
    }
    // create function section
    public function create(Request $request){
        // dd($request->all());
        $this->productValidationCheck($request,"create");
        // get product data with private function from the input user data
        $data =$this->requestProductInfo($request);
        // create function step
        // get image and save the image in public and image name into the database.
        
        $fileName =uniqid() . $request->file('pizzaImage')->getClientOriginalName();
         $request->file('pizzaImage')->storeAs('public',$fileName);
        $data['image']=$fileName;
        //create
        Product::create($data);
        return redirect()->route('product#list')->with(['createSuccess'=>'Product Created']);
    }

    // delete each product items
    public function delete($id){
        Product::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Product Delete Successfully.....']);
    }

    // edit each product items
   public function edit($id){
    $pizzas=Product::select('products.*','categories.name as category_name')
    ->leftJoin('categories','products.category_id','categories.id')
    ->where('products.id',$id)->first();
    return view('admin.product.edit',compact('pizzas'));
   }


   // call updatepage each product items
   public function updatePizzaPage($id){
   $pizza = Product::where('id',$id)->first();
   $category=Category::get();
   return view('admin.product.update',compact('pizza','category'));
   }


   // to update for pizza information
   public function updatePizza(Request $request){
        //validation check
        $this->productValidationCheck($request,"update"); 
        // get data from user input
        $data=$this->requestProductInfo($request);

        // dd($data);        
        // image has or has check
        if($request->hasFile('pizzaImage')){
            $oldImage=Product::where('id',$request->pizzaId)->first();
            $oldImage=$oldImage->image;
            // dd($oldImage);
            if($oldImage != null){
                Storage::delete('public/'.$oldImage);
               
            }            
            $fileName=uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
             // image = field name into database.
            $data['image']=$fileName;        
                    
        }
        Product::where('id',$request->pizzaId)->update($data);
        return redirect()->route('product#list');    
    
    }

    

    // getproductinfo private function 
    private function requestProductInfo($request){
        return[
            'category_id'=>$request->pizzaCategory,
            'name'=>$request->pizzaName,
            'description'=>$request->pizzaDescription,
            'price'=>$request->pizzaPrice,
            'waiting_time'=>$request->pizzaWaitingTime
            
        ];
    }
    // private function for productvalidationCheck rule 
    private function productValidationCheck($request,$action){
        $validationRules=[
            // unique:products,name where products = table name, name =coloumn name.
            'pizzaName'=>'required|min:5|unique:products,name,'.$request->pizzaId,
            'pizzaCategory'=>'required',
            'pizzaDescription'=>'required|min:10',
            'pizzaPrice'=>'required',
            'pizzaWaitingTime'=>'required'
            
        ];
        //  checking with using the ternary operator to work the image validation rule depending upon the calling function of create or update.
        $validationRules['pizzaImage'] = $action == "create" ? 'required|mimes:jpg,jpeg,png,webp|file':"mimes:jpg,jpeg,png,webp|file";
        // dd($validationRules);
       Validator::make($request->all(),$validationRules)->validate();
    }
    
}
