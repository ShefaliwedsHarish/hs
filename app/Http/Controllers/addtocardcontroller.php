<?php

namespace App\Http\Controllers;
use App\Models\dairyproduct;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Session; 


use Illuminate\Http\Request;

class addtocardcontroller extends Controller
{
    public function cart($id)
       {

        dd($id);
          $user=Auth::user()->User;
          $cart=Cart::Where('Product_id',$id)->Where('User',$user)->first(); 
         
          if(isset($cart))
          {
            echo "<script> alert('Sorry Item is already on cart'); 
                    window.location.href='/dairy';
                  </script> "; 

          }
          else 
          {
             
            
            $product=dairyproduct::Where('productid',$id)->first(); 
            $prid=$product->productid; //productid
            $prname=$product->productname; //productName
            $primg=$product->Image; //productImage
            $qty=1;  //productQty
            $priTotal=$product->Total;  //productidTotal
            $total=$priTotal*$qty;

            $cart=new Cart(); 
            $cart->Product_id=$prid; 
            $cart->User=$user; 
            $cart->Product_Name=$prname; 
            $cart->Image=$primg; 
            $cart->Quantity=$qty;
            $cart->price=$priTotal;
            $cart->Total=$total; 
            $cart->save(); 
            echo "<script> alert('Item is added on Cart'); 
                    window.location.href='/dairy';
                  </script> "; 
             $cart=Cart::Where('User',$user)->get(); 
             $num=$cart->count();
             Session::put('num', $num);
                 }

       }



    public function viewcart()
    {
         $user=Auth::user()->User;
         $cart=Cart::Where('User',$user)->get(); 
         $sum=$cart->sum('Total');
         $discount=$cart->sum('Quantity'); 
         $carts=Cart::Where('User',$user)->paginate(1);
         $num=$cart->count(); 
         
         Session::put('num', $num);
         if(isset($carts))
         {      
         return view('cart/cart',
            [
            'carts'=>$carts,
             'num'=>$num,
             'sum'=>$sum,
             'discount'=>$discount           
            ]); 
         } else
         {
             return view('cart/cart',
                [
                 'num'=>0
                ]); 
         }
    }


    public function updatecart($qty,$prid)
    {
      
      $cart=Cart::Where('Product_id',$prid)->first(); 
      $num=$qty; 
      $price=$cart->price; 
      $total=$price*$num; 
      $cart->Quantity=$num; 
      $cart->Total=$total; 
      $cart->save(); 
       
         
       
    }
   
public function deletecart($id)
    {
        $cart=Cart::Where('Product_id',$id)->delete(); 
        return back();
    }


}
