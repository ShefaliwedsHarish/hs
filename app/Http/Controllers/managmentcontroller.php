<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\managment;
class managmentcontroller extends Controller
{
            // add member     
        public function data(Request $request)
            {
                $image=rand().".".$request->image->extension(); 
                $request->image->move(public_path('managmentimge'),$image);

                $managment=new managment(); 
                $managment->Name=$request->name; 
                $managment->Images=$image;
                $managment->save();
                return back()->withSuccess("Your data is save");        
             }

        // Delete managment code 

        public function deletemanagment($id)
                {
                  $data=managment::Where('id',$id)->first()->delete(); 
                  return back()->withSuccess('Data is delete');
                }
}