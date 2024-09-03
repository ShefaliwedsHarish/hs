<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController; 
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\adminController;
use App\Http\Controllers\userviewController;
use App\Http\Controllers\craousalcontroller;
use App\Http\Controllers\managmentcontroller;
use App\Http\Controllers\DairyproductController;
use App\Http\Controllers\addtocardcontroller;
use App\Http\Controllers\printingController;    
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/',[ContactController::class,'index']);

function saveuser($request){
   $name=$request->name;
   $email=$request->email;  
   $phone_number=$request->phone;
   $sel_id=''; 
   
   $sel = User::where('email', $email)
   ->where('phone_number', $phone_number)
   ->first(); 
   if(!empty($sel))
   {
      // dd($sel->id); 
      $sel_id=$sel->id;
   }else{
      $save=User::create([
         "name" =>$name,
         "email" =>$email,
         "User" => $email,
         "password" => $phone_number,
         "User_profile"=>'1234.jpg',
         "Phone_number" => $phone_number      
     ]); 
     $sel2 = User::where('email', $email)
     ->where('phone_number', $phone_number)
     ->first();
     if($sel2){
       $sel_id= $sel2->id; 
     }
   }
   return $sel_id;  
}

function random()
{
  $value=rand(1001,9999); 
  return $value; 

}


Route::get('/',[userviewController::class,'index']);
Route::get('/about',[userviewController::class,'about']);
Route::get('/contact',[userviewController::class,'contact']);
Route::get('/online',[userviewController::class,'online']);
Route::get('/epfoform',[userviewController::class,'epfo']);
Route::get('/itr_form',[userviewController::class,'itr_form']);
Route::get('/online2',[userviewController::class,'onlineform']);
Route::get('/photo',[userviewController::class,'photo']);
Route::get('/views',[userviewController::class,'view']);
Route::get('/dairy',[userviewController::class,'dairy']);
Route::get('viewdairy/{id}/cus',[userviewController::class,'viewdairy']);
Route::POST('/savereview',[userviewController::class,'starview']); 
Route::get('/site_rating',[userviewController::class,'rating'])->name('rating');
Route::post('/viewreview/{id}',[userviewController::class,'reatingview']); 
Route::post('/approvedreview/{id}',[userviewController::class,'reatingapprove']); 
Route::POST('/reviewedit/{id}',[userviewController::class,'reatingedit']); 
Route::POST('/reatingdelete/{id}',[userviewController::class,'reatingdelete']); 
Route::POST('/updatereview',[userviewController::class,'updatereview']);
Route::get('/loan',[userviewController::class,'loan'])->name('loan');
Route::POST('/loanrequest',[userviewController::class,'loanrequest']);
Route::get('/kstrequest',[userviewController::class,'kstrequest'])->name('kst');
Route::POST('/kst',[userviewController::class,'kstsave']);


//Route::get('/',[userviewController::class,'getdata'])
Route::POST('/admin/{id}/view',[usercontroller::class,'viewsingle']);
Route:: get('/epfoview',[usercontroller::class,'epfo']);
Route:: get('/itrview',[usercontroller::class,'itr']);
Route::get('/admin2',[usercontroller::class,'admin']);
Route::get('/user',[usercontroller::class,'desh']);
Route:: post('/contact',[ContactController::class,'contact']);
Route::post('/epfo2',[ContactController::class,'epfo']);
Route::post('/itr2',[ContactController::class,'itr']);
Route::post('/admin/{id}/epfo',[usercontroller::class,'epfosingle']);

// user view Deshbord 
Route::get('/itrview_user',[userviewController::class,'itrview']);




// for admin

Route::get('/active',[adminController::class,'admin']);
Route::POST('/adduser',[adminController::class,'adminuser'])->name('admin_data');
Route::POST('/logindata',[adminController::class,'logindata'])->name('login');
Route::POST('/registerdata',[adminController::class,'registerdata'])->name('register');
Route::get('/setting',[adminController::class,'setting'])->name('setting');
Route::POST('setting/{id}/data',[adminController::class,'settingdata']); 
Route::POST('contact/{id}/data',[adminController::class,'contactedit']); 
Route::get('/userquery',[adminController::class,'userquery'])->name('userquery');
Route::get('/contact/{id}/update', [adminController::class,'viewmessage']);
Route::get('/contact/{id}/delete',[adminController::class,'deletemessage']);
Route::get('/readall',[adminController::class,'readall']);
Route::get('/deleteall',[adminController::class,'deleteall']);
//logout 
Route::get('/logout',[adminController::class,'logout'])->name('logout');

//User 
Route::get('/userdetails',[adminController::class,'useractive'])->name('users');
Route::get('use/{id}/change',[adminController::class,'checkuser']);

//loan request for admin 
Route::get('/loanrequest',[adminController::class,'loanrequest'])->name('loanrequest'); 
Route::POST('/admin/{id}/loan',[adminController::class,'view_single_request']);
Route::POST('/admin/{id}/{action}',[adminController::class,'loanaction']);
Route::POST('/adminkst/{id}/{action}',[adminController::class,'kstaction']);

//kst
Route::get('/kstrequest2', [adminController::class, 'kstrequest'])->name('kstrequest');


Route::get('/userdashboard', function () {
   return view('user/index');
})->name('userdeshbord')->middleware('cart');












// profile
Route::get('/profile',function ()
{ 
   return view('folder/profile');
})->name('profile');

Route::get('/users-profile',function (){
return view('user/users-profile'); 
}); 


// update data 
Route::get('/editprofile',[adminController::class,'editprofile']); 
Route::POST('/hsgroup/{id}/editdata',[adminController::class,'editdata']); 
// craousel 
Route::get('/craousalshow',[craousalcontroller::class,'craousalshow'])->name('imagecraousal');
Route::POST('/savecraousal',[craousalcontroller::class,'imagesave']);
Route::get('/craousal/{id}/delete',[craousalcontroller::class,'deletecraousal']);

// Managment  
Route::POST('/managmentdata',[managmentcontroller::class,'data']);
Route::get('/managment/{id}/delete',[managmentcontroller::class,'deletemanagment']);

/*
*
* All Route for Dairy Product 
*
*/ 
Route::get('/dairyproduct',[DairyproductController::class,'dairyproduct'])->name('dairyproduct'); 
//Route::get('/savedairy',[DairyproductController::class,'dairyproduct']))
Route::POST('/viewdairy/{id}',[DairyproductController::class,'viewdiry']); //view for product
Route::POST('/savedairy',[DairyproductController::class,'savedairy'])->name('savedairyproduct');
Route::POST('/addimage',[DairyproductController::class,'saveimage']);
Route::POST('/viewimage/{id}',[DairyproductController::class,'getimage']);//This product show all images product for both  
Route::get('/delete/{id}/data',[DairyproductController::class,'Delete']);
Route::POST('/getproduct/{id}',[DairyproductController::class,'getdata']);
Route::POST('/updatedairy',[DairyproductController::class,'updatedariy'])->name('updatedairy');
Route::POST('/deleteimage/{id}',[DairyproductController::class,'Delete_image']);
Route::POST('/selectimage/{id}',[DairyproductController::class,'thumbnail']);

/*
*
* All Route for printing product  
*
*/ 
Route::get('/printing',[printingController::class,'mainview'])->name('printing');
Route::POST('/saveprinting',[printingController::class,'database']); 
Route::POST('/deleteprinting/{id}',[printingController::class,'delete']); 
Route::POST('/getprinting/{id}',[printingController::class,'getsingle']);
Route::POST('/updateprinting/{id}',[printingController::class,'update']);
Route::POST('/viewproduct/{id}',[printingController::class,'viewproduct']); //view for product
Route::POST('/addsize',[printingController::class,'size']);
Route::POST('/viewsize/{id}/',[printingController::class,'viewsize']); 
Route::get('/deshbord',[admincontroller::class,'deshbord'])->middleware('admin'); 




// add to car 
Route::get('/dairy/{id}/cart',[addtocardcontroller::class,'cart'])->middleware('cart');
Route::get('/viewcart',[addtocardcontroller::class,'viewcart'])->middleware('cart');
Route::POST('/updatecart/{qty}/{prid}',[addtocardcontroller::class,'updatecart']);
Route::GET('delete/{id}/cart',[addtocardcontroller::class,'deletecart']);

// userview
Route::POST('/itr/{id}/userview',[userviewController::class,'viewitr']);


Route::get('/login',function (){

         return view('folder/login'); 
});

Route::get('/register',function ()
{
   return view('folder/register');
}); 