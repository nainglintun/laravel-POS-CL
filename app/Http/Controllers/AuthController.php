<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //direct login page
    public function loginPage(){
        return view('login');
    }

    // direct register page
    public function registerPage(){
        return view('register');
    }

    //direct dashboard
    public function dashboard(){
        if(Auth::user()->role == 'admin'){
            return redirect()->route('category#list');
        }
        return redirect()->route('user#home');
    }

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
