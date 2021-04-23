@extends('layouts.app')
@section('content')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>

    <style>
        img {
            border: 1px solid #ddd;
            /* Gray border */
            border-radius: 4px;
            /* Rounded border */
            padding: 5px;
            /* Some padding */
            width: 150px;
            /* Set a small width */
        }

        /* Add a hover effect (blue shadow) */
        img:hover {
            box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }

    </style>

    <div class="container">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card" style="width: 18rem; margin: auto; margin-top: 1rem;">
                        <img  class="card-img-top" src="{{ asset('/storage/uploads/' . $images[0]->name) }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $animals[0]->name }}</h5>
                          <p class="card-text">{{ $animals[0]->description}}</p>
                        </div>
                      </div>

                    <div class="card-body">

                        @if (session('status'))
                              <div class="alert alert-success">
                                {{ session('status') }}                           
                              </div>
                        @endif

                        {{-- show sucess message on successful adoption status modification --}}
                        @if ($message = Session::get('success'))
                          <div class="alert alert-success">
                              <strong>{{ $message }}</strong>
                          </div>
                        @endif

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Users</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- adds approved account to top of list by default --}}
                                @if (count($approvedaccount) !== 0)
                                <tr>
                                    @foreach ($approvedaccount as $account )
                                    <td>   {{ $account->firstname }} {{ $account->lastname }} <br> {{ $account->occupation}} <br>{{ $account->contactemail }} <br> {{ $account->contactnumber }} <br> </td>
                                                
                                    <td>
                                        <div class="alert alert-success">
                                        <strong>Approved</strong>
                                        </div>
                                    </td>
                                </tr>
                                    @break
                                    @endforeach
                                @endif


                                @foreach  ($adoptionRequests as $adoptreq)
                                    <tr>
                                        @foreach($accounts as $account)
                                            @if($adoptreq->userid !== $account->userid)
                                                @continue;
                                            
                                            @else
                                                @if ($adoptreq->pending === 1 )
                                                    <td>   {{ $account->firstname }} {{ $account->lastname }} <br> {{ $account->occupation}} <br>{{ $account->contactemail }} <br> {{ $account->contactnumber }} <br> </td>
                                                    
                                                    <td>
                                                        <div class="alert alert-dark">
                                                        <strong>Pending</strong>
                                                        </div>
                                                        {{-- <div style = "transform: translateY(-1rem);">
                                                            <form style = "float: left;" method="POST" action="{{ route('denyStatus') }}">
                                                                @csrf                                                    
                                                                    <label for="myanimalid"></label>
                                                                    <input type="hidden" id="myanimalid" name="myanimalid" value="{{ $animals[0]->id }}">
                
                                                                    <label for="deny" class="col-md-4 col-form-label text-md-right"></label>
                                                                    <button class = "btn btn-danger" id="deny" name="deny" value = "{{ $account->userid}}" >Deny</button>
                                                            </form> --}}

                                                            {{-- if the animal is already owned by someone the buttons will not show  --}}
                                                            @if ($animals[0]->userid === 1) 
                                                                <form method="POST" action="{{ route('modifyStatus') }}">
                                                                    @csrf
                                                                        <input type="hidden" id="useraccount" name="useraccount" value="{{ $account->userid }}">
                                                                        <input type="hidden" id="animalid" name="animalid" value="{{ $animals[0]->id }}">
                                                                      
                                                                        <button type = submit class = "btn btn-danger" id="useradoptstatus_adopt" name="useradoptstatus" value = "Deny" style= "margin-right: 65%">Deny</button>
                                                                        <button type = submit class = "btn btn-success" id="useradoptstatus_deny" name="useradoptstatus" value = "Approve">Approve</button>
                                                                </form>
                                                            @endif
                                                        @break
                                                        </div>
                                                    </td>
                                            
                                                @elseif ($adoptreq->denied === 1)
                                                    <td>   {{ $account->firstname }} {{ $account->lastname }} <br> {{ $account->occupation}} <br>{{ $account->contactemail }} <br> {{ $account->contactnumber }} <br> </td>
                                                    <td>
                                                        <div class="alert alert-danger">
                                                            <strong>Denied</strong>
                                                        </div>
                                                    </td>
                                                    @break;
                                                @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection