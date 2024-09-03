@include('folder/header'); 
@include('folder/link');


<br> <br> 
<div class="ch" style="position:fixed;width:100%;height:70px;background-color:white;margin-top:8px"> 
<h1 style="text-align:center">   Online  Serive  <hr style="width:20%;margin-left:40%">  </h1> 
</div> 
<br> 
<div class="per" style="width:50%;margin-left:42%">
<br> <br> <br> 
<p>  <a href="/epfoform"> <button type="button" class="btn btn-secondary" id="epfo" value="EPFO">EPFO </button> </a> &nbsp; &nbsp; 
  <a href="/itr_form"> <button type="button" class="btn btn-info" id="itr" value="ITR">ITR</button> </a>  &nbsp; &nbsp;  
<a href="/online2"><button type="button" class="btn btn-warning" id="online" value="Online Form">Online Form </button></a> </p> 
</div> 

<div class="part2" style="background-color:black"> 
 <h1 style="color:white;text-align:center" id="act"> EPFO   </h1> 
</div> 
@if($message = Session::get('success'))
<div class="alert alert-success alert-block">

<strong>  {{  $message }}</strong>

 </div>
@endif

<div class="container" style="background-color:yellow; border:7px solid green">
 <form action="/epfo2" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">    
      <div  class="row"> 
    <div class="col-6"> 

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1"  name="name" value="{{old('name')}}">
      @if($errors->has('name'))
                <span class="text-danger"> {{ $errors->first('name') }}</span>
                @endif
  </div>

    </div> 
    <div class="col-6"> 

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email </label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="email" value="{{old('email')}}">
   @if($errors->has('email'))
                <span class="text-danger"> {{ $errors->first('email') }}</span>
                @endif
    </div>


             </div> 
    </div> 
      
  


        <div  class="row"> 
    <div class="col-6"> 

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Phone Number </label>
    <input type="text" class="form-control" id="exampleInputEmail1"  name="phone"value="{{old('phone')}}">
   
     @if($errors->has('phone'))
                <span class="text-danger"> {{ $errors->first('phone') }}</span>
                @endif
  </div>

    </div> 
    <div class="col-6"> 

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"> Image for Bank Passbook  </label>
    <input type="file" class="form-control" id="exampleInputEmail1"  name="image" value="{{old('image')}}">
      @if($errors->has('image'))
                <span class="text-danger"> {{ $errors->first('image') }}</span>
                @endif
    
  </div>
             </div> 
    </div> 

      <div  class="row"> 
    <div class="col ">
<label for="exampleInputEmail1" class="form-label">Address   </label>
<div class="form-floating">
  <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="address"value="{{old('address')}}" ></textarea>
    @if($errors->has('address'))
                <span class="text-danger"> {{ $errors->first('address') }}</span>
                @endif
  
</div>


             </div> 
    </div>






        <div  class="row"> 
    <div class="col-6"> 

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">UNA Number  </label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="una"value="{{ old('una')}}">
      @if($errors->has('una'))
                <span class="text-danger"> {{ $errors->first('una') }}</span>
                @endif
   
  </div>

    </div> 
    <div class="col-6"> 

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Password   </label>
    <input type="password" class="form-control" id="exampleInputEmail1" name="password" value="{{old('password')}}">
      @if($errors->has('password'))
                <span class="text-danger"> {{ $errors->first('password') }}</span>
                @endif
   
  </div>
             </div> 
    </div> 
             <input type="submit"  class="btn btn-success"  style="margin-left:45%"> 

</form> 
        

        










