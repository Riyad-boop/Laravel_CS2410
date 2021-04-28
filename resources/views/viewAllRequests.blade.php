<script src= {{asset('js/home.js')}}></script>

@extends('layouts.app')
@section('content')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>

    <div class="container">
                <div class="card">
                    <div class="card-header">Dashboard</div>
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

                        <table class="table table-striped table-bordered table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th>Animal
                                        <input type="text" id="myAnimalInput" onkeyup="mysearchFunction(0,this.id)" placeholder="Search for animals">
                                    </th>
                                    <th>Users
                                        <input type="text" id="myAccountInput" onkeyup="mysearchFunction(1,this.id)" placeholder="Search for users">
                                    </th>
                                    <th>Status<br>
                                        <input type="hidden" id="myHiddenInput" onload="mysearchFunction(2,this.id)" value = "Pending">
                                            <select class="form-select" id="mySelect" onchange="mysearchFunction(2,this.id)">
                                            <option value="Pending">Pending</option>
                                            <option value="Denied">Denied</option>
                                            <option value="Accepted">Accepted</option>
                                              <option value="">All</option>
                                            
                                        </th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach  ($adoptionRequests as $adoptreq)
                                    <tr>
                                        <td>
                                            <?php $thisanimal; ?>

                                            @foreach ($animals as $animal) 
                                           
                                            <?php $thisanimal = $animal; ?>

                                            @if ($animal->id === $adoptreq->animalid) 
                                                @foreach ($images as $img)
                                                        @if ($img->animalid !== $animal->id) 
                                                            @continue
                                                        @else

                                                        <div class="card" style="width: 10rem; margin: auto; margin-top: 1rem;">
                                                            <a href="{{asset('/storage/uploads/' . $img->name) }}">
                                                                <img  class="card-img-top" src="{{ asset('/storage/uploads/' . $img->name) }}">
                                                            </a>
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $animal->name }}</h5>
                                                              <p class="card-text">{{ $animal->description}}</p>
                                                            </div>
                                                          </div>
                                                        @break

                                                        @endif
                                 
                                                @endforeach
                                               
                                    @break
                                            
                                            @else 
                                    @continue
                                            @endif
                                            
                                        
                                    @endforeach
                                        </td>

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
                                                    
                                                            {{-- if the animal is already owned by someone the buttons will not show  --}}
                                                            @if ($animal->userid === 1) 
                                                                <form method="POST" action="{{ route('modifyStatus') }}">
                                                                    @csrf
                                                                        <input type="hidden" id="useraccount" name="useraccount" value="{{ $account->userid }}">
                                                                        <input type="hidden" id="animalid" name="animalid" value="{{ $thisanimal->id }}">
                                                                      
                                                                        <button type = submit class = "btn btn-danger" id="useradoptstatus_adopt" name="useradoptstatus" value = "Deny" style= "margin-right: 35%">Deny</button>
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

                                                @elseif ($adoptreq->adopted === 1)
                                                <td>   {{ $account->firstname }} {{ $account->lastname }} <br> {{ $account->occupation}} <br>{{ $account->contactemail }} <br> {{ $account->contactnumber }} <br> </td>
                                                <td>
                                                    <div class="alert alert-success">
                                                        <strong>Accepted</strong>
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