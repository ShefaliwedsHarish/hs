<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\epfo; 
use App\Models\contact; 
use App\Models\itr_form;

class usercontroller extends Controller
{
    function admin()
    {
     return view('admin/index'); 
    }

    function desh()
    {
     return view('admin/deshbord'); 
    }

    function epfo()
    {

      $epfo=epfo::get();
           return view('admin/epfoview',[
            'epfo'=>$epfo]); 
    }

    function itr()
    {
       $itr=itr_form::paginate(4);
           return view('admin/itrview',[
            'itr'=>$itr]); 
    }

    function viewsingle($id)
    {
       $itr=itr_form::where('id',$id)->first(); 
       if(!empty($itr))
       {
       return json_encode($itr);
       }
      
    }

   //  function epfosingle($id)
   //  {
   //    $epfo=epfo::where('id',$id)->first();   
     
   //     if(!empty($epfo))
   //     {
   //     return json_encode($epfo);
   //     }  
   //  }

    function itrview(){

      return view('user/itrview'); 



}

   

   
}