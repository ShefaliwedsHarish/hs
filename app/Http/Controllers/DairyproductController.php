<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dairyproduct;
use App\Models\dairyimage; 
use Illuminate\Support\Facades\DB;


class DairyproductController extends Controller
{
            public function dairyproduct()
                        {
                                       // $posts = dairyproduct::orderBy('id', 'DESC')->take(1)->first();
                                        $sel=dairyproduct::paginate(3);
                                        if(isset($sel))
                                                { 

                                                return view('admin/dairy',
                                                    [
                                                       'dairy'=>$sel
                                                       //'id'=>$posts   
                                                    ]); }
                                        else 
                                        {
                                              return view('admin/dairy');       
                                        }

                        }
            public function viewdiry($id)
                                    {
                                      $sel=dairyproduct::where('id',$id)->first(); 
                                      $product=$sel->productid; 
                                      $img=dairyimage::where('productid',$product)->where('Selectimage','1')->first(); 
                                      $image=$img->Image;
                                     echo $sel;   

                                    }
            public function savedairy(Request $request)
                                    
                                    {
                                      $request->validate([
                                                          
                                                "productid"    => "required||unique:dairyproducts",
                                                "Productname"  => "required",
                                                "productprice" => "required||numeric",
                                                "discount"     => "required||numeric",
                                                "total"        => "required",
                                                "quanity"      => "required||numeric",
                                                "des"          =>"required",
                                                "unit"         => "required"              
                                      ]); 
                                     $dairyproduct=new dairyproduct(); 
                                     $dairyproduct->productid=$request->productid; 
                                     $dairyproduct->productname=$request->Productname; 
                                     $dairyproduct->originalprice=$request->productprice; 
                                     $dairyproduct->Discount=$request->discount; 
                                     $dairyproduct->Total=$request->total; 
                                     $dairyproduct->Quanity=$request->quanity;
                                     $dairyproduct->description=$request->des;  
                                     $dairyproduct->Unit=$request->unit; 
                                     $dairyproduct->Image="12345.jpg"; 
                                     $dairyproduct->save(); 
                                     
                                     $dairyimage=new dairyimage();
                                     $dairyimage->productid=$request->productid;
                                     $dairyimage->Image="12345.jpg";
                                     $dairyimage->Selectimage='1';
                                     $dairyimage->save(); 

                                     return back();
                                  }  
        

        public function saveimage(Request $request)
                     {
                       
                     $filename=rand().".".$request->file->extension();
                     $request->file->move(public_path('dariy'),$filename); 
                     $dairyimage=new dairyimage(); 
                     $dairyimage->productid=$request->productid;
                     $dairyimage->Image=$filename;
                     $dairyimage->save();
                     
                     return back()->withSuccess("Data is save"); 
                     }

        public function getimage($id)
                      {
                           //echo $id; 
                             $sel=dairyimage::where('productid',$id)->get(); 
                             echo $sel;
                      }

        public function Delete($id)
                      {
                         $delete=dairyproduct::where('productid',$id)->first()->delete(); 
                         $sel=dairyimage::where('productid',$id)->delete(); 
                             return back()->withSuccess('Item is Delete'); 
                      }

        public function getdata($id)
                      {
                        $update=dairyproduct::where('productid',$id)->first();    
                        echo $update; 
                      }

        public function updatedariy(Request $request)
                    {
                          //dd($request->all());
                          $product_id=$request->productid; 
                          $update=dairyproduct::where('productid',$product_id)->first(); 
                          $update->productname=$request->Productname; 
                          $update->originalprice=$request->productprice;
                          $update->Discount=$request->discount;
                          $update->Total=$request->total;
                          $update->Quanity=$request->quanity;
                          $update->description=$request->des;
                          $update->Unit=$request->unit;
                          $update->save(); 
                          return back()->withSuccess("Your data is Update"); 

                    }
        public function Delete_image($id)
                    {
                     $del=dairyimage::where('id',$id)->delete(); 
                     if($del)
                     {
                       echo 1;
                     }
                     }

        //thumbnail image 
        public function thumbnail($prid)
                     {
                      //dairyimage
                      $getid= dairyimage::select('productid')->where('id',$prid)->first();
                      $id=$getid->productid; 
                      dairyimage::where('productid', $id)->update(['Selectimage' => 0]); 
                      dairyimage::Where('id',$prid)->update(['Selectimage'=>1]); 
                      $getimage=dairyimage::Where('Selectimage',1)->where('productid', $id)->first(); 
                      $img=$getimage->Image; 
                      dairyproduct::where('productid', $id)->update(['Image' => $img]); 
                      


                      //return back()->withSuccess("Data is change");
                      

                     }

            

}



