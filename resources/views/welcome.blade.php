<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="{{url('css/inquiry_onboard.css')}}">
</head>
<body>
    <div class="container" id="container">
      <div class="row mt-1">
          <div class="col-md-12">
            @if(!empty(session('errorMessage')))
                <div class="alert alert-danger mt-2">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('errorMessage') }}
                </div>
            @endif

            @if(!empty(session('successMessage')))
                <div class="alert alert-success mt-2">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('successMessage') }}
                </div>
            @endif

            <center><h2 class="mt-3">Online Support Platform</h2></center>
                <hr>

                <form class="mt-3 p-4" method="POST" action="{{route('search_inquiry')}}">
                  @csrf
                  <div class="col-md-12">
                  <div class="input-group flex-nowrap">
                      <span class="input-group-text" id="addon-wrapping">Check My Ticket</span>
                      <input type="text" class="form-control" placeholder="Type Reference Number Here.." name="reference_number" aria-describedby="addon-wrapping">
                      <button class="input-group-text btn btn-info" type="submit" id="addon-wrapping">Search</button>
                    </div>
                    <span style="color: red;">@error('reference_number')
                      {{$message}}
                  @enderror </span>
                  </div>
              </form>

              <form class="needs-validation mb-3" novalidate method="POST" action="add_inquiry">
                
                @csrf
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom01">Name</label>
                      <input type="text" class="form-control" id="validationCustom01" name="name" placeholder="Achala Adhikari" value="{{old('name')}}" required>
                      
                      <div>
                        <span style="color: red;">@error('name')
                            {{$message}}
                        @enderror </span>
                      </div>  
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom02">E-Mail</label>
                  <input type="email" class="form-control" id="validationCustom02" name="email_id" placeholder="abcd@gmail.com" value="{{old('email_id')}}" required>
                  
                  <div>
                    <span style="color: red;">@error('email_id')
                        {{$message}}
                    @enderror </span>
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom03">Contact Number</label>
                  <input type="text" class="form-control" id="validationCustom03" name="contact_number" placeholder="011xxxxxxx" value="{{old('contact_number')}}" required>
                  
                  <div>
                    <span style="color: red;">@error('contact_number')
                        {{$message}}
                    @enderror </span>
                  </div>
                </div>
  </div>
    <div class="form-row">
        <div class="col-md-12 mb-3">
          <label for="validationCustom03">Problem Description</label>
          <textarea class="form-control" id="validationCustom03" name="description"  placeholder="My Item has ......" required>{{old('description')}}</textarea>
            
            <div>
              <span style="color: red;">@error('description')
                  {{$message}}
              @enderror </span>
            </div>
        </div>
    </div>

<center>
    <button class="btn btn-warning" type="reset">Reset</button>
    <button class="btn btn-primary" type="submit">Submit</button> 
</center>

</form>
</div>
</div>
</div>
</body>
</html>
