<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\printing;
use App\Models\criteriaproduct;
use App\Models\dairyimage; 
use Illuminate\Support\Facades\DB;

class printingController extends Controller
{
    function mainview(){
       $sel=printing::paginate(5);
                    if(isset($sel)){ 
                       return view('/admin/printing',
                                          [
                                           'products'=>$sel                                                       //'id'=>$posts   
                                                    ]); }
                                        else{
                                              return view('/admin/printing');       
                                        }
         }

         // save data 

    function database(Request $request){

           $output=array(); 
          
            $productid=$request->productid;
            $Productname=$request->Productname;
            $productprice=$request->productprice;
            $discount=$request->discount;
            $total=$request->total;
            $quanity=$request->quanity;
            $des=$request->des;
            $unit=$request->unit;
            

            $product=printing::where('productid',$productid)->first(); 
            if(!empty($product)){
                $output['message']="Product id is already used"; 
                $output['status']=false;              
            }
            else{
             
            $printng=new printing(); 
            $printng->productid =$productid; 
            $printng->productname=$Productname;
            $printng->originalprice=$productprice;
            $printng->Discount=$discount;
            $printng->Total=$total;
            $printng->description=$des;
            $printng->image="12345.jpg";
            $save=$printng->save();
            if($save){
                      $output['message']="Product  is Add "; 
                      $output['status']=true; 
            }
        }
            echo json_encode($output); 
            }
            


public function delete($id){
   $output=array(); 
   $product=printing::where('productid',$id)->delete(); 
   if($product){
       $output['message']="Item is Deleted "; 
       $output['status']=true; 
   }
   echo json_encode($output); 
}

public function getsingle($id){
  $printproduct=printing::where('productid',$id)->first(); 
  echo json_encode($printproduct); 
}

public function update(Request $request,$id){

 $output=array();            
$updateprint=printing::where('productid',$id)->first(); 
 $updateprint->productid =$request->productid; 
$updateprint->productname=$request->Productname;
$updateprint->originalprice=$request->productprice;
$updateprint->Discount=$request->discount;
$updateprint->Total=$request->total;
$updateprint->quanity=$request->quanity;
$updateprint->description=$request->des;
$updateprint->unit=$request->unit;
$save=$updateprint->save();
if($save){
       $output['message']="Prouduct is Updated  "; 
       $output['status']=true;
}
echo json_encode($output);
}



public function viewproduct ($id){
  $sel=printing::where('id',$id)->first(); 
  $product=$sel->productid;
//   $img=dairyimage::where('productid',$product)->where('Selectimage','1')->first(); 
//   $image=$img->Image;
 echo $sel;   

}

public function size(Request $request){
    $output=array(); 
   $productid=$request->productid; 
   $size=$request->size; 
   $qty=$request->quantity; 
   $color=$request->color;
    
    $getqty=criteriaproduct::Where('productid',$productid)->first(); 
    if($getqty){
        $total=$getqty->Total+$qty;
     }
    else{
          $total=$qty;
    }

   $product=new criteriaproduct(); 
   $product->productid=$productid;
   $product->size=$size;
   $product->quanitity=$qty;
   $product->Total=$total;
   $product->color=$color;
   $save=$product->save(); 
   if($save)
   {

    $updatetotal=criteriaproduct::Where('productid',$productid); 
  $output['message']="Product is added successfull "; 
       $output['status']=true;
}
echo json_encode($output);
}


public function viewsize($id){

                             $sel=criteriaproduct::where('productid',$id)->get(); 
                             echo $sel;



}


}

