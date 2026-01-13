<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //user home page

    public function home(){
        // all data take from product table into database using get method of laravel.
        //call data in home poge using compact method.
        $pizza=Product::orderBy('created_at','desc')->get();
        $category=Category::get();
        // user_id mean user_id column in cart table into database.
        //Auth user mean current login user.
        $cart=Cart::where('user_id',Auth::user()->id)->get();
        // history data
        $history=Order::where('user_id',Auth::user()->id)->get();
         return view('user.main.home',compact('pizza','category','cart','history'));
    }

    //chage password page
public function changePassword(){
    return view('user.password.change');

}

// change Password function 
public function changePasswordWork(Request $request){
    
    // check validaton 
    $this->passwordValidationCheck($request);                
    $currentUserId =Auth::user()->id;
    //view password value from database
    $user=User::select('password')->where('id',$currentUserId)->first();
    $hashValue=$user->password;
       // check database hash password value and new password hash value is equal or not equal
       if(Hash::check($request->oldPassword,$hashValue)){
            //change password function S
            $data=[
                //1. insert password function
                'password'=>Hash::make($request->newPassword)
            ]; 
            //2. update password form user input new password.        
          User::where('id',Auth::user()->id)->update($data); 
          
          // 3. logout and redirect to the login page.
        //   Auth::logout();
        //   return redirect()->route('category#list');

         //   return back();
         return back()->with(['passwordSuccess'=>'Password Change Successfully!']);

      }
      return back()->with(['notMatch'=>'The Old Password not match.Try Again!']);
    
}

//user account change page
public function accountChangePage(){
    return view('user.profile.account');
}

// filter category by pizza type
public function filter($categoryId){
    $pizza=Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
    $category=Category::get();
    $cart=Cart::where('user_id',Auth::user()->id)->get();
    $history=Order::where('user_id',Auth::user()->id)->get();
    return view('user.main.home',compact('pizza','category','cart','history'));

}

// to do customer account update function
public function accountChange($id,Request $request){
     // dd($id,$request->all());
        //1.checkvailidation private call
        $this->accountValidationCheck($request);         
        //2.getuerdata
        $data = $this->getUserData($request);
        //3.image update image= name input image input box
        if($request->hasFile('image')){
            // 1.old image name->check<=>delete->store
            //1.get old image value
            $dbImage=User::where('id',$id)->first();
            $dbImage=$dbImage->image;
            // dd($dbImage);
            //delete old image
            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }
            //get new image value
            $fileName =uniqid() . $request->file('image')->getClientOriginalName();
            // dd($fileName);
            //save new image in public folder>storage folder
            $request->file('image')->storeAs('public',$fileName);
            // save new image into database
            // $data mean that the above get user data variable
            $data['image'] = $fileName;   
         }
            // 3. update data
        User::where('id',$id)->update($data);
        // 4.return to this page
        return back()->with(['updateSuccess'=>'Customer Account updated!']);
}

// cartlist
public function cartList(){
    // take data from cart table into database
    $cartList=Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_image')
    ->leftJoin('products','products.id','carts.product_id')
    ->where('carts.user_id',Auth::user()->id)
    ->get();
     // to view include or not include output.
    // dd($cartList->toArray());
    // to show total result
    $totalPrice=0;
    foreach($cartList as $c){
        $totalPrice += $c->pizza_price*$c->qty;
    }
    // dd($totalPrice);
    // dd($cartList->toArray());
    return view('user.main.cart',compact('cartList','totalPrice'));
}

// for pizza product each detail
public function detail($pizzaId){
   $pizza=Product::where('id',$pizzaId)->first();
   $pizzaList=Product::get();
    return view('user.main.detail',compact('pizza','pizzaList'));
}


//history page
public function history(){
    $order=Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('3');
    return view('user.main.history',compact('order'));
}


 // getuserdata private functon for updateprofile function
 private function getUserData($request){
    // insert user data and return user data.
    //$request->name= name is column name database.$request is user input.
    return [
        'name'=> $request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'gender'=>$request->gender,
        'address'=>$request->address,
        // current update time 
        'updated_at'=>Carbon::now()           
    ];
}    

// indicate for going to history page.



// customer account Validation Check
private function accountValidationCheck($request){
    // validator::make($request->all(),[
    //     //declearation of validation rule
    //     'name'=>'required',
    //     'email'=>'required',
    //     'phone'=>'required',
    //     'gender'=>'required',
    //     'address'=>'required'
    // ])->validate();

    $validationRules=[
        'name'=>'required',
        'email'=>'required',
        'phone'=>'required|min:9',
        'gender'=>'required',
        'address'=>'required',
        'image'=>'mimes:png,jpg,jpg,webp|file'
        
    ];
    // //Custom messages
    $validationMessage=[
      'name.required'=>'အမည် ဖြည့်ရန် လိုအပ်ပါသည်...',
      'email.required'=>'email ဖြည့်ရန် လိုအပ်ပါသည်...',
      'phone.required'=>'Phone Number ဖြည့်ရန်လိုအပ်ပါသည်',
      'phone.min'=>'Phone Number မှာ အနည်းဆုံး ၉ လုံးရှိရပါမည်',
      'address.required'=>'နေရပ်လိပ်စာ ဖြည့်ရန်လိုအပ်ပါသည်',
    
    ];
    validator::make($request->all(),$validationRules,$validationMessage)->validate();
 }

// password validation check rule for changePasswordWork function
private function passwordValidationCheck($request){
    validator::make($request->all(),[
        //declearation of validation
        'oldPassword'=>'required|min:6|max:20',
        'newPassword'=>'required|min:6|max:20',
        // same mean that new password and confirm password will be check to be same the password.
        'confirmPassword'=>'required|min:6|max:20|same:newPassword',                
    ])->validate();
}









}

