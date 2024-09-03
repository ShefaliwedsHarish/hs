<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\carousel; 
use App\Models\contactdetails; 
use App\Models\managment;
use App\Models\dairyproduct;
use App\Models\dairyimage; 
use App\Models\reviews; 
use App\Models\loan; 
use App\Models\loantoken; 
use App\Models\kst_requirement;
use Illuminate\Support\Facades\Auth; 
use App\Models\itr_form;

  
class userviewController extends Controller
{
    
 public function index()
      {
        $cra=carousel::get();
        $contact=contactdetails::get()->first(); 
        $reviews=reviews::Where('status',0)->get(); 
        if(isset($cra))
        {
         return view('welcome',
            [
               'cra'=>$cra,
               'contact'=>$contact,
               'review'=>$reviews
            ]);
        }
        else {
                return view('welcome'); 
        }
      }

 public function about()
      {
        
        $managment=managment::get(); 
        if(isset($managment))
        {
         return view('about',
            [
               'managment'=>$managment
            ]);
        }
        else {
                return view('about'); 
        }

      }

 public function contact()
      {
       
        $contactd=contactdetails::get()->first(); 
      if(isset($contactd))
        {
         return view('contact',
            [
              'contact2'=>$contactd
            ]);
        }
        else {
                return view('contact'); 
        }
      }

 public function online()
      {
         return view('online');
      }

 public function epfo()
      {
         return view('online2/epfo');
      }

 public function itr_form()
      {
         return view('online2/itr');
      }

 public function onlineform()
      {
         return view('online2/online2'); 
      }

 public function photo()
      {
         return view('photo');
      }

 public function view()
      {
         return view('view');
      }

 // public function index()
 //      {
 //         return view('welcome');
 //      }

      public function dairy()
          {
               $sel=dairyproduct::get(); 
               return view('dairy',
                [
                   'dairy'=>$sel

                ]);
          }


// view dairy 
    public function viewdairy($id)
           {
              $product=dairyproduct::where('productid',$id)->first(); 
              return view('viewdairy',
                [
                  'product'=>$product
                ]);
           }

// reating
   
   public function starview(Request $request)
          {
         // dd($request->all());   
      $request->validate([

                'name'=>'required',
                'message'=>'required',
                'start'=>'required',
                'file'=>'required'
                
            ]); 
           $ex=$request->file->extension();
            $filename=rand().".".$ex;
            $file=$request->file->move(public_path('userprofile'),$filename); 

            $review=new reviews(); 
            $review->User_name=$request->name; 
            $review->Message=$request->message; 
            $review->Images=$filename; 
            $review->Star=$request->start; 
            $review->save(); 
            return back()->withSuccessfull("Thankyour for giving your feedback"); 

         }


    public function rating()
                              {
                                 $rating=reviews::paginate(3); 
                                 return view('admin/rating',[
                                    'data'=>$rating,
                                         ]);
                                 
                              }
      public function reatingview($id)
                 {
                  $rating=reviews::where('id',$id)->first(); 
                  return json_encode($rating); 
                 }


       public function reatingapprove($id)
                 {
                   $status=0; 
                   $rating=reviews::where('id',$id)->first(); 
                   $rating->status=$status; 
                   $rating->save(); 
                   echo "Comment is approve Successfull";   

                 }

       public function reatingedit($id)
       {
         $rating=reviews::where('id',$id)->first();  
         echo json_encode($rating); 

       }

       public function reatingdelete($id)
       {
         $rating=reviews::where('id',$id)->delete();  
         echo "Comment is Delete "; 

       }
      public function updatereview(Request $request)
      {
      //   dd( $request->all()); message
        $review=reviews::where('id',$request->messageid)->first(); 
        $review->Message=$request->message; 
        $review->save(); 
        return back()->withSuccessfull("comment is Update"); 
        echo "Comment is Update"; 
      //   dd($review); 
      }


//for loan


      public function loan(){
                           return view('loan');
      }

      public function loanrequest(Request $request){
            
         $output=array(); 
                 // dd($request->all()); 
                   $request->validate([
                           
                           "name" => "required",
                           "payment" => "required|numeric",
                           "paymentreturn" => "required",
                           "requestdate" => "required",
                           "returndate" => "required",
                           "pnnumber" => "required",
                           "paymentmethod" => "required"
               ]);

             if(isset($request->token_number)){
              $loantoken=loantoken::Where('token_number',$request->token_number)->first(); 
              // dd($loantoken); 
             if($loantoken){
                              if($request->payment>=$loantoken->till_ruppes){
                              $action="yes";
                            }
                         else{
                                $action="no"; 
                               }
                }
            
            else{
                     
                         $output['status']=false;
                         $output['message']='Verfiy the token'; 
                         

            } }
          $action="SORRY"; 
               

             if($request->payment<=5000 || $action=="yes"){

           $loan=loan::where('name',$request->name)->Where('name',$request->name)->Where('status','0')->first(); 
          if($loan){
                   
                   $output['status']=false;
                   $output['message']='Your request is Already send for admin'; 
          }else{
            
            $profit=$request->paymentreturn-$request->payment; 
            $rand=rand(); 
            // $betch=loan::()->
            $loan=new loan(); 
            $loan->betch_id =$rand; 
            $loan->name =$request->name;
            $loan->payment =$request->payment;
            $loan->paymentreturn =$request->paymentreturn;
            $loan->profit =$profit;
            $loan->requestdate =$request->requestdate;
            $loan->returndate =$request->returndate;
            $loan->phone_number =$request->pnnumber;
            $loan->method=$request->paymentmethod;
            $save=$loan->save(); 
             if($save){

                         $output['status']=true;
                         $output['message']='Request is send for Admin'; 

             }
         }
     }
     else{
                         $output['status']="limit";
                         $output['message']='You are apply more then 5000'; 

     }
   
     echo json_encode($output); 
   }

      // KST Request 
      public function kstrequest(){
                            return view('kst');
      }

      public function kstsave(Request $request){
        // dd("heelo"); 
        
         $output=array(); 
        //  dd($request->all()); 
          $request->validate([
                           "name" => "required",
                           "email"=>"required|email",  
                           "number_of_person" => "required|numeric",
                           "total" => "required",
                           "requestdate" => "required",
                           "lastdate" => "required",
                           "pnnumber" => "required|numeric",
                           "companyname" => "required"
          ]); 

          $betch_id=rand(0,4444); 
          $profit=$request->number_of_person*30; 
         
          $kst=new kst_requirement(); 
          $kst->betch_id=$betch_id; 
          $kst->name=$request->name;
          $kst->email=$request->email;
          $kst->number_of_person=$request->number_of_person;
          $kst->total_pay=$request->total; 
          $kst->profit=$profit; 
          $kst->booking_date=$request->requestdate; 
          $kst->last_date=$request->lastdate; 
          $kst->phone_number=$request->pnnumber; 
          $kst->company_name=$request->companyname; 
          $save=$kst->save(); 
          
         if($save){
          $output['status']=true;
          $output['message']='Data is Save successfull'; 
         }


            echo json_encode($output); 
}
 
// userview

function itrview (){

  $userid=Auth::user()->id; 
  $itr=itr_form::where('user_id',$userid)->get();
   if(isset( $itr)){ 
   return view('user/itrview',
   [
      'itrs_data'=>$itr
   ]); 
  }else{
   return view('user/itrview'); 
  }

}


function viewitr(Request $request,$id){
   if($request->action=="view"){
      
      $data=itr_form::where('id',$id)->first(); 
      echo json_encode($data);  


   }
   
}


}