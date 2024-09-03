<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\setting;
use App\Models\contactdetails; 
use App\Models\contact; 
use App\Models\managment;
use App\Models\Cart;
use Session; 
use App\Models\loan;
use App\Models\kst_requirement;
use App\Models\epfo;
use App\Models\itr_form;

/*
* Click for Ctrl  G then go for line  
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
* line 304 loan request route
*/


class adminController extends Controller
{
      public function admin()
                      {
                        return view('admin/login');
                      }
                
      public function adminuser(Request $request)
                {
                       $request->validate([     
                       "name" => "required",
                        "email" => "required||email|unique:users",
                        "user" => "required|unique:users",
                        "password" => "required",
                        "phone_number" => "required",
                        "user_profile" => "required|mimes:jpeg,jpg,gif,png|max:10000"
                       ]); 

                       $filename=$request->user.".".$request->user_profile->extension();
                       $request->user_profile->move(public_path('adminuser'),$filename);

                        User::create([

                        "name" =>$request->name,
                        "email" =>$request->email,
                        "User" => $request->user,
                        "password" => $request->password,
                        "User_type" => $request->usertype,
                        "Phone_number" => $request->phone_number,
                        "User_profile" => $filename
                       ]);
                    return view('welcome')->withSucess("You are login");
             }

      public function logindata(Request $request)
                          {

                    
                      $output=array(); 
                                                
                                   $request->validate([
                                     
                                                   'user'=>'required',
                                                   'password'=>'required'
                                     ]); 
                                 //    dd("heelo my name is harihshgauta"); 
                      $data=$request->only('user','password');
                      if(Auth::attempt($data))
                           {
                              $user=Auth::user()->User;
                              $cart=Cart::Where('User',$user)->get(); 
                              $num=$cart->count();
                              Session::put('num', $num);

                               $use=Auth::user()->use; 

                                  if($use=='1')
                                      {    
                                                
                                              $number=1; 
                                               $user_name=Auth::user()->User;
                                               $active=user::Where('User',$user_name)->first();
                                               $active->status=$number; 
                                               $active->save(); 
                                                $user=Auth::user()->User_type; 
                                                    if($user=="a")
                                                    {
                                                      $output['status']=true;
                                                      $output['message']="Login Successful";
                                                       //return view('admin/deshbord');   
                                                    }
                                                    else 
                                                    {
                                                      $output['status']=true;
                                                      $output['message']="Login Successfull";
                                                    }
                                      }
                                    
                                  else {
                                         
                                               $number=0;
                                               $user_name=Auth::user()->User;
                                               $active=user::Where('User',$user_name)->first();
                                               $active->status=$number;
                                               $active->save();
                                               Auth::logout();
                                               return view('admin/error');
                                        }
                                  }
                           else
                              {
                                    $output['status']=false;
                                    $output['message']="Sorry wrong username and password";
                              }
                           echo json_encode($output); 
                        } 

      public function registerdata(Request $request)
                    {
                         $filename=$request->user.".".$request->user_profile->extension();
                         $request->user_profile->move(public_path('adminuser'),$filename);
                         $save=User::create([
                                "name" =>$request->name,
                                "email" =>$request->email,
                                "User" => $request->user,
                                "password" => $request->password,
                                "Phone_number" => $request->phone_number,
                                "User_profile" => $filename
                            ]);
                        $data=$request->only('user','password');
                        if(Auth::attempt($data))
                              {
                                   $user=Auth::user()->User_type; 
                                      if($user=="a")
                                      {
                                          return redirect('/');
                                          // return view('admin/deshbord');
                                      }
                                      else 
                                      {
                                          return redirect('/');
                                      }
                                }
                     } 
         


      public function logout()

            {
                 $number=0;
                 $user_name=Auth::user()->User;
                 $active=user::Where('User',$user_name)->first();
                 $active->status=$number;
                 $active->save();
                 Auth::logout();
                 return redirect('/');
            }


      public function editprofile()
                  {
                    
                     //$data=User::Where('id',$id)->first();
                       return view('folder/edit');
                  }

      public function editdata(Request $request,$id)
                  {
                        $update=User::where('id',$id)->first();
                        if(isset($request->user_profile))
                              {
                                  $filename=$request->user.".".$request->user_profile->extension();
                                  $request->user_profile->move(public_path('adminuser'),$filename);
                                  $update->User_profile=$filename;
                              }
                        if(isset($request->password))
                              {
                                 $update->password=$request->password;
                              }
                              $update->name=$request->name;
                              $update->email=$request->email;
                              $update->Phone_number=$request->phone_number;  
                              $update->save(); 
                              return redirect('/');
                   }


      public function setting()
                    {
                       $managment=managment::get(); 
                       $data=setting::get()->first(); 
                       $contact=contactdetails::get()->first();
                       return view('admin/setting',
                          [
                              "id"=>$data,
                              "contact"=>$contact,
                              "managment"=>$managment
                           ]); 
                }


      public function settingdata(Request $request,$id)
                  { 
                      //dd($request->all()); 
                    $request->validate([
                         "site" => "required",
                         "about" => "required"
                    ]); 
                     $data=setting::Where('id',$id)->first(); 
                     $data->sitetitle=$request->site; 
                     $data->description=$request->about;
                     $data->save(); 
                     return back()->withSuccess('Site'); 
                  }



      public function contactedit(Request $request,$id)
                    {
                         
                      $update=contactdetails::where('id',$id)->first();
                      $update->Address=$request->address;
                      $update->Location=$request->googlemap;
                      $update->Phone_number1=$request->phone_number1;
                      $update->Phone_number2=$request->phone_number2;
                      $update->Email_id=$request->email;
                      $update->Facebook=$request->facebook;
                      $update->Instagram=$request->instagram;
                      $update->Twitter=$request->twitter;
                      $update->Ifram=$request->ifram;
                      $update->save(); 
                      return  back()->withSuccess('Contact');
                    }


      public function userquery()
                {
                        $data=contact::get(); 
                        return view('admin/userquery',
                          [
                           'contact'=>$data,
                          ]); 
                }

            // contact message functioin 
      public function viewmessage($id)
                {
                    $number=0; 
                    $message=contact::where('id',$id)->first();
                    $message->Read=$number;
                    $message->save(); 
                    return back()->withSuccess('You have read a message');  
                }

      public function deletemessage($id)
                {

                  $message=contact::where('id',$id)->delete();
                  return back(); 
                }

       public function readall()
                {
                 contact::query()->update(['Read' => 0]);
                 return back()->withSuccess('All message Read');
                }

        public function deleteall()
                {
                 contact::query()->delete();
                 return back()->withSuccess('All message are Delete');
                }


        public function useractive()
                {
                  $users=user::get(); 
                  return view('admin/viewuser',[
                     'user'=>$users
                  ]); 
                }

         public function checkuser($id)
                  {
                      $number; 
                       $id=user::where('id',$id)->first(); 
                       if($id->use==1)
                       {
                         $number=0;     
                       }
                       else
                       {
                         $number=1; 
                       }
                    $id->use=$number; 
                    $id->save(); 
                    return back()->withSuccess("Your data is update"); 
                  }



// all admin point for route
         public function loanrequest(){
            
             $loanrequest=loan::paginate(4);  
             // $loanrequest=loan::get(); 
            return view('admin/loanrequest',[         
            'loanrequest'=>$loanrequest
            ]);
         }


   public function loanaction (Request $request,$id,$action){

     switch($action){

          case('loanview'):
            $loan=loan::where('id',$id)->first(); 
            echo json_encode($loan);     
            break;
          
            case('delete'):
                $output=array(); 
                  $loan=loan::where('id',$id)->delete(); 
                    if($loan){
                            $output['status']=true;
                            $output['message']='Item is Deleted Successfull'; 
                              }
                      echo json_encode($output);  
              break;

              case('approve'):
                $output=array(); 
                  $loan=loan::where('id',$id)->first(); 
                  $loan->status='1'; 
                  $loan->reason='Approved'; 
                  $save=$loan->save(); 
                    if($save){
                            $output['status']=true;
                            $output['message']='Loan is approved'; 
                              }
                      echo json_encode($output);  
              break;



              case('unapprove'):
                $output=array(); 
                $reason=$request->reason; 
                  $loan=loan::where('id',$id)->first(); 
                  $loan->status='2'; 
                  $loan->reason=$reason; 
                  $save=$loan->save(); 
                    if($save){
                            $output['status']=true;
                            $output['message']='Loan is unapproved '; 
                              }
                      echo json_encode($output);  
              break;
           

  
    }

   }


      public function deshbord(){
        $output=array(); 
        $data=epfo::where('payment_status','1')->get(); 
        $epfosum=0; 
        foreach($data as $sum){
          $epfosum=$epfosum+$sum->profit; 
        }
        
        // kstprofit
        $kst=kst_requirement::where('paymentstatus','1')->get();
        $kstsum=0; 
        foreach($kst as $sum){
          $kstsum=$kstsum+$sum->profit; 
        }
      //loan profit
       
      $loan=loan::where('paymentstatus','2')->get();
      $loansum=0; 
      foreach($loan as $sum){
        $loansum=$loansum+$sum->profit; 
      }

      $itr=itr_form::where('payment_status','1')->get(); 
      $itr_sum=0; 
      foreach($itr as $sum){
        $itr_sum=$itr_sum+$sum->payment; 
      }
      

      


        $output['epfo']=$epfosum; 
        $output['kst']=$kstsum;
        $output['loan']=$loansum;
        $output['itr']=$itr_sum; 


        


       
        return view('admin/deshbord',
        [
          'data'=>$output
        ]);  
       
      }
    
      public function kstrequest(){
        $kst=kst_requirement::paginate(6);
       return view('admin/kstrequest',[         
       'kst'=>$kst
       ]);
      }


      public function kstaction (Request $request,$id,$action){

        switch($action){
   
             case('kstview'):
               $loan=kst_requirement::where('id',$id)->first(); 
               echo json_encode($loan);     
               break;
             
               case('delete'):
                   $output=array(); 
                     $loan=loan::where('id',$id)->delete(); 
                       if($loan){
                               $output['status']=true;
                               $output['message']='Item is Deleted Successfull'; 
                                 }
                         echo json_encode($output);  
                 break;
   
                 case('approve'):
                   $output=array(); 
                     $loan=loan::where('id',$id)->first(); 
                     $loan->status='1'; 
                     $loan->reason='Approved'; 
                     $save=$loan->save(); 
                       if($save){
                               $output['status']=true;
                               $output['message']='Loan is approved'; 
                                 }
                         echo json_encode($output);  
                 break;
   
   
   
                 case('unapprove'):
                   $output=array(); 
                   $reason=$request->reason; 
                     $loan=loan::where('id',$id)->first(); 
                     $loan->status='2'; 
                     $loan->reason=$reason; 
                     $save=$loan->save(); 
                       if($save){
                               $output['status']=true;
                               $output['message']='Loan is unapproved '; 
                                 }
                         echo json_encode($output);  
                 break;
              
   
     
       }
   
      }









}