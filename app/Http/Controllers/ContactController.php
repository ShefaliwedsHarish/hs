<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contact; 
use App\Models\epfo; 
use App\Models\itr_form;
class ContactController extends Controller
{
  public function contact(Request $request)
    {
          $request->validate([

          'name'   =>'required',
          'email'  =>'required || email ',
          'subject'=>'required',
          'message'=>'required'
      ]); 

         $contact=new contact;
         $contact->Name=$request->name; 
         $contact->Email=$request->email; 
         $contact->Subject=$request->subject; 
         $contact->Message=$request->message; 

         $contact->save(); 
         return back()->withSuccess('Your Complaint is Send  our team we will message you !!!!!!');
}

// function for epfo  
public function epfo(Request $request)
{

$request->validate([

   'name'        =>'required',
   'email'       =>'required||email',
   'phone'       =>'required|numeric|digits:10',
   'image'       =>'required || mimes:jpeg,jpg,png,gif || max:10000',
   'address'     =>'required',
   'una'         =>'required|numeric|digits:12',
   'password'    =>'required'
]); 

      $name=$request->una.'.'.$request->image->extension(); 
      $request->image->move(public_path('EPFO'),$name); 
         
       
       $epfo=new epfo; 
       $epfo->Name=$request->name;
       $epfo->Email=$request->email;
       $epfo->Phone_number=$request->phone; 
       $epfo->Images_passbook=$name; 
       $epfo->Address=$request->address; 
       $epfo->UNA=$request->una; 
       $epfo->Password=$request->password;
       $epfo->payment="0";
       $epfo->profit="0"; 

       $epfo->save(); 
       return back()->withSuccess('Your form is filled our team call you'); 
  }


// function for itr

  function itr (Request $request)
  {

   // $sel=itr_form::get(); 
      //dd($request->all()); 

    $request->validate([

       'name'=>'required',
       'email'=>'required|email',
       'phone'=>'required|numeric',
       'addhar'=>'required || mimes:jpeg,jpg,png,gif || max:10000',
       'pancard'=>'required', 
       'password'=>'required'
    ]); 

   $id=saveuser($request); 
  
 
//dd($request->all()); 
$name=$request->pancard.'.'.$request->addhar->extension();
$request->addhar->move(public_path('itr'),$name); 

 $itr=new itr_form; 
 $itr->user_id=$id; 
 $itr->Name=$request->name; 
 $itr->Email=$request->email; 
 $itr->Phone_number=$request->phone; 
 $itr->Address=$request->address;  
 $itr->Pan_card=$request->pancard; 
 $itr->Password=$request->password; 
 $itr->Addharcard=$name; 
 $itr->save(); 
 return back()->withSuccess('Your form is filled our team call you'); 
 
 }

 









  



}
