@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header">Agent Pannel</div>

                <form class="mx-5 my-3">
                    <div class="col-md-7 offset-md-3">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">Search Customer</span>
                        <input type="text" class="form-control" placeholder="Name" id="serach_name" aria-describedby="addon-wrapping">
                      </div>
                    </div>
                </form>

                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ref Number</th>                           
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>                                                        
                            <th scope="col">Contact Number</th>
                            <th scope="col">Complain</th>
                            <th scope="col">Status</th>
                            <th scope="col">View Details</th>
                          </tr>
                        </thead>
                        <tbody id="namewise">
                            @if(count($complains)>0)
                            @php
                              $i=1;  
                            @endphp
                            @foreach ($complains as $complain)
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{$complain->reference_number}}</td>
                                <td>{{$complain->f_name}}</td>
                                <td>{{$complain->email}}</td>
                                <td>{{$complain->contact_number}}</td>
                                <td>{{$complain->description}}</td>
                                <td>
                                    @if ($complain->mark_as_read =='0')
                                        
                                        <button class="btn btn-warning" type="button"><span style="color: brown">NEW</span></button>
                                        @else
                                        <button class="btn btn-success" type="button"><span>Attended</span></button>
                                    @endif
                                </td>
                                <td>
                                    
                                    <a href="{{URL::to('ticket-details',[$complain->reference_number])}}" class="btn btn-info" role="button">view</a>

                                </td>
                              </tr>
                              @php
                              $i++;  
                              @endphp
                            @endforeach
                       @else
    
                       @endif
                          
                          
                        </tbody>
                      </table>
                  <div id="pag">
                   {{$complains->links()}}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#serach_name").keyup(function(){ 
        var name = document.getElementById('serach_name').value ;
    
        
        if(name.length >= 3){
            $.ajax({
              url: '{{URL::to('search_customer')}}',
              type: 'GET',
              data: {'name':name},

              success:function(response) {

                document.getElementById('pag').innerHTML ='';
                document.getElementById('namewise').innerHTML ='';
                 $('#namewise').html(response); 
              }
            });
        }
        
    });
</script>
@endsection
