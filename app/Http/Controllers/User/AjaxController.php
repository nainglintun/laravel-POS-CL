<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //call pizza list data from ajax 
    public function pizzaList(Request $request){
        // logger($request->status);

        if($request->status == 'desc'){
            $data = Product::orderBy('created_at','desc')->get();
        }else{
            $data = Product::orderBy('created_at','asc')->get(); 

        }        
        // return as a json format
        // return response()->json($pizza,200);
       return $data;
    }

    // add to cart function
    public function addToCart(Request $request){
        // logger($request->all());
        $data=$this->getOrderData($request);
        // logger($data);
        Cart::create($data);

        $response=[
            'status'=>'success',
            'message'=>'Add To Cart Complete',
        ];
        // return as a json format
         return response()->json($response,200);
        // show message with object format.
        // return[
        //     'status'=>'success',
        //     'message'=>'Add To Cart Complete',
        // ];
    }


    //for order List
    public function order(Request $request){
        logger($request->all());
        // insert into  order list database table using for each looping.
        // item represented as each array index.
        // to get total price assign variable
        $total=0;
        // looping
        foreach($request->all() as $item){
            // insert array format into database table
            // logger($item);            
            $data=OrderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'total' => $item['total']+3000,
                'order_code' => $item['order_code'],

            ]);
            // to get result of total price
            $total += $data->total;
        }
             // after insert database and then delete the data into cartList.
             Cart::where('user_id',Auth::user()->id)->delete();

             //to check the total result into log file of lavaral.
            // logger($total+3000);
             // insert and change from order list table to order table into database.
             Order::create([
                'user_id'=>Auth::user()->id,
                'order_code'=> $data->order_code,
                'total_price'=>$total,
                
             ]);             
             // return to page with carrying data and showing a message or status.
            return response()->json([
                'status'=>'true',
                'message'=>'order Complete',
            ],200);      
    }


    // private function for getorderdata
    private function getOrderData($request){
        // key is column name in data.
        //value is user input in request data into $source in ajax function of deatail.blade.php.
        
        return[
            'user_id'=>$request->userId,
            'product_id'=>$request->pizzaId,
            'qty'=>$request->count,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];
    }

    // for clearcart function 
    public function clearCart(){
        Cart::where('user_id',Auth::user()->id)->delete();
    }
    // for clear current cart product
    public function clearCurrentProduct(Request $request){
        Cart::where('user_id',Auth::user()->id)->
        where('product_id',$request->productId)
        ->where('id',$request->orderId)
        ->delete();

    }

    

}
