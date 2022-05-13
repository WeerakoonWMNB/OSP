<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="{{url('css/inquiry_onboard.css')}}">
</head>
<body>
<div class="container" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header">Ticket Details</div>
                <div class="card-body">
                    
                        <div class="row">
                            <div class="col-md-12">

                                @if(!empty(session('errorMessage')))
                                <div class="alert alert-danger mt-2">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('errorMessage') }}
                                </div>
                                @endif
                                
                                <div class="panel panel-primary">
                                   
                                @php
                                    $cname = '';
                                    $cemail = '';
                                    $cref = '';
                                @endphp
                                    <div class="panel-body">
                                        <ul class="chat">
                                            @if (count($complains)>0)
                                                @foreach ($complains as $complain)
                                                @php
                                                    $cname = $complain->f_name;
                                                    $cemail = $complain->email;
                                                    $cref = $complain->reference_number;
                                                @endphp
                                                @if ($complain->is_agent==0)

                                                <li class="left col-md-8">
                                                    <div class="chat-body " style="background-color: antiquewhite;padding:5px;margin:5px;border-radius:5px;">
                                                        <b>{{$complain->f_name}}</b>
                                                        <p>
                                                            {{$complain->description}}
                                                        </p>
                                                    </div>
                                                </li>
                                                
                                                @else

                                                <li class="right col-md-8 offset-md-4">
                                                    <div class="chat-body " style="background-color: rgb(209, 195, 175);padding:5px;margin:5px;border-radius:5px;">
                                                        <b>Agent</b>
                                                        <p>
                                                            {{$complain->description}}
                                                        </p>
                                                    </div>
                                                </li>

                                                @endif
                                                @endforeach
                                            @endif
                                            
                                            
                                            
                                        </ul>
                                    </div>
                                    <div class="panel-footer">
                                        <div >
                                            <form  method="POST" action="{{route('add_customer_reply')}}">
                                                @csrf
                                            <input type="hidden" name="ref" value="{{$cref}}">
                                            <input type="hidden" name="name" value="{{$cname}}">
                                            <input type="hidden" name="email" value="{{$cemail}}">   
                                            <div class="input-group"> 
                                            <input id="btn-input" type="text" class="form-control" name="message" placeholder="Type your message here..." />
                                            <span class="input-group-btn">
                                                <button class="btn btn-warning" id="btn-chat" type="submit">
                                                    Send</button>
                                            </span>
                                            </div>
                                            <span style="color: red;">@error('message')
                                                {{$message}}
                                            @enderror
                                            </span>
                                            
                                            </form>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</html>