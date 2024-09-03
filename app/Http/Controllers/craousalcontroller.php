<?php

namespace App\Http\Controllers;
use App\Models\carousel; 
use App\Http\Controllers\Auth\mysql_num_rows;

use Illuminate\Http\Request;

class craousalcontroller extends Controller
{
 
 public function craousalshow()
{

  $get=carousel::get();
  if(isset($get))
  {
  return view('admin/craousal',[

   'data'=>$get
  ]); 
}
else 
{
return view('admin/craousal'); 
}


 } 
 // save image in craousal 
 public function imagesave(Request $request)
 {
    $get=carousel::get()->count();
   if($get<6)
    {    
      $imagename=rand().".".$request->craousal->extension(); 
       $request->craousal->move(public_path('craousal'),$imagename);
       $carousel=new carousel(); 
       $carousel->images=$imagename; 
       $carousel->save(); 
       return back()->withSuccess('Your image is added');
  }
  else 
  {
    return back()->with('message','You have enter 6 item Please delete some item');
  }

}



public function deletecraousal($id)
{

   $get=carousel::where('id',$id)->first()->delete(); 
  return back()->withSuccess('You craousal delete'); 
}
}
