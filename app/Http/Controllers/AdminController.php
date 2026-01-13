<?php
namespace App\Http\Controllers;
use Storage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    // change password page.
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //change password function.
    public function changePassword(Request $request){
        // dd($request->all());
        /*
        1.all field must be fill
        2.new password & confirm password length must be grater than 6 and nott grater than 10.
        3.new password & confirm password  must same.
        4.client old password must be same with db password.
        5.password change 

        */
        // check validaton 
        $this->passwordValidationCheck($request);
                
        $currentUserId =Auth::user()->id;
        //view password value from database
        $user=User::select('password')->where('id',$currentUserId)->first();
        $hashValue=$user->password;

           // check database hash password value and new password hash value is equal or not equal
           if(Hash::check($request->oldPassword,$hashValue)){
                //change password function 
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

        //direct admin details page
         public function  details(){
                return view("admin.account.details");
         }


    // direct admin editprofile page
    public function editProfile(){
        return view("admin.account.edit");
    }


    // direct admin profile update function page 
    public function updateProfile($id,Request $request){
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
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Account updated!']);
    }


    //admin list
   public function list(){
    // checking role == admin with where statement.
    $admin=User::when(request('key'),function($query){
        $query->orWhere('name','like','%'.request('key').'%')
               ->orWhere('email','like','%'.request('key').'%')
               ->orWhere('gender','like','%'.request('key').'%')
               ->orWhere('phone','like','%'.request('key').'%')
               ->orWhere('address','like','%'.request('key').'%');
    })
    ->where('role','admin')->paginate(3);
    $admin->appends(request()->all());
    // dd($admin->toArray());
    return view('admin.account.list',compact('admin'));
   }


   // delete each admin 
   public function delete($id)
   {
    //  dd("delete");
    User::where('id',$id)->delete();
    return back()->with(['deleteSucess'=>'Admin Account Deleted!']);
   }


   // change admin role
   public function changeRole($id){
        $account=User::where('id',$id)->first();
       return view('admin.account.changeRole',compact('account'));
   }


   // real change function
   public function change($id,Request $request){
    //requestUserdata private function for change role
    $data=$this->requestUserdata($request);
    // update data
    User::where('id',$id)->update($data);
    return redirect()->route('admin#list');
   }

   //requestUserdata private function for change role
   private function requestUserdata($request){
        return[
            'role'=> $request->role
        ];
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

// account Validation Check
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
    
    
    // direct admin profile update function page 
    
    
 
 // password validation check
      private function passwordValidationCheck($request){
            validator::make($request->all(),[
                //declearation of validation
                'oldPassword'=>'required|min:6|max:10',
                'newPassword'=>'required|min:6|max:10',
                // same mean that new password and confirm password will be check to be same the password.
                'confirmPassword'=>'required|min:6|max:10|same:newPassword',                
            ])->validate();
      }

}