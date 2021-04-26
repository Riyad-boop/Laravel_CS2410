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

                        {{-- show success message on valid adoprtion request--}}
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if (count($account) === 0 && Auth::user()->role !== 1)
                            <label for="back">You need to complete your eligibility registration before you can adopt an animal</label><br>
                                <a href="{{ route('regAccount')}}">
                                    <button class="btn btn-primary" name="back"/>
                                        Click here to register
                                    </button>
                                </a>
                        @else

                            <table class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th><button class = "btn btn-block" onclick="sortTableByLetters(0)">
                                        <strong>Request Status</strong></button>
                                        @if($userrole !== 1)
                                        <input type="text" id="myRequestInput" onkeyup="mysearchFunction(0,this.id)" placeholder="Search for request status">
                                        @endif
                                        </th>
                                        
                                         <th><button class = "btn btn-block" onclick="sortTableByLetters(1)">
                                        <strong>Name</strong></button>
                                        <input type="text" id="myNameInput" onkeyup="mysearchFunction(1,this.id)" placeholder="Search for names. . .">
                                        </th>
                                        
                                        <th><button class = "btn btn-block" onclick="sortTableByDate(2)"><strong>Date of Birth</strong></button></th>
                                        
                                        <th><button class = "btn btn-block" onclick="sortTableByLetters(3)">
                                        <strong>Type</strong></button>
                                        <input type="text" id="mytypeInput" onkeyup="mysearchFunction(3,this.id)" placeholder="Search for type. . .">
                                        
                                        <th>Description </th>
                                        <th>Images</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($animals as $animal)
                                    {{-- if the animal is owned by someone then skip  --}}
                                        @php   
                                        
                                        $adoptionstatus = false;
                                        $message = "";

                                        if($userrole !== 1)
                                        {                                            
                                                // if the foriegn key matches to myuserid then i own this animal
                                                if ($animal->userid === Auth::user()->id) {
                                                        $message = '
                                                        <div class="alert alert-success">
                                                        <strong>Approved</strong>
                                                        </div>';
                                                        $adoptionstatus = true;
                                                        }
                                                //else check if my user id matches in the table other columns
                                                else{
                                                        $pendingarray = explode(',', $animal->pendingUsers);
                                                        $deniedarray = explode(',', $animal->deniedUsers);
                                                        
                                                        
                                                        foreach ($adoptionRequests as $adoptreq) {

                                                            //check request denied column
                                                            if ($adoptreq->denied === 1 && $adoptreq->animalid === $animal->id) {
                                                                $message = '
                                                        <div class="alert alert-danger">
                                                        <strong>Denied</strong>
                                                        </div>';
                                                                $adoptionstatus = true;
                                                                break;
                                                            }
                                                            //check request pending column
                                                            else if ($adoptreq->pending === 1 && $adoptreq->animalid === $animal->id) {
                                                                $message = '
                                                        <div class="alert alert-warning">
                                                        <strong>Pending</strong>
                                                        </div>';
                                                                $adoptionstatus = true;
                                                                break;
                                                            }
                                                        }

                                                     
                                                        
                                                        //animal is owned by someone else and you have not sent a request
                                                        //then skip this animal
                                                        if($message === "" && $animal->userid !== 1){
                                                            continue;
                                                        }
                                                }
                                        }
                                            
                                        //else if animal is available for adoption
                                         else if($animal->userid ===1){
                                            $message = '<div class="alert alert-info">
                                                <strong>Available for adoption</strong>
                                                </div>';
                                            }
                                        // else the animal is already owned by someone so do not show on this tab
                                        else{
                                           continue;
                                        }
                                        @endphp

                                        <tr>
                                            <td>
                                                @php
                                                if($message !== ""){
                                                    echo $message;
                                                    $message = "";
                                                }
                                                
                                                @endphp
                                                
                                                {{-- adoption button if no adopted status is recognised --}}
                                                @if ($adoptionstatus === false && $animal->userid === 1 && $userrole !== 1)
                        
                                                <form action="{{route('adoptionRequest')}}" method="post">
                                                    @csrf
                                                        <label for="myanimalid"></label>
                                                        <input type="hidden" id="myanimalid" name="myanimalid" value= "<?php echo $animal->id; ?>" >

                                                        <label for="myanimalname"></label>
                                                        <input type="hidden" id="myanimalname" name="myanimalname" value= "<?php echo $animal->name; ?>" >


                                                        <label for="adoptionrequestid"><div class="alert alert-info">
                                                            <strong>Available for adoption</strong>
                                                            </div></label><br>
                                                        <button class="btn btn-primary" type ="submit" id="adoptionrequestid" name="adoptionrequestid" value= "{{Auth::user()->id}}">                                 
                                                            Send adoption request
                                                        </button>
                                                </form>
                                            
                                                @endif
                                                
                                            </td>
                                            <td> {{ $animal->name }} </td>
                                            <td> {{ $animal->DOB }} </td>
                                            <td> {{ $animal->type }} </td>
                                            <td> {{ $animal->description }} </td>
                                            <td>
                                                @foreach ($images as $img)
                                                    @php
                                                        //only show the images which match the id of tha animal
                                                        if ($img->animalid !== $animal->id) {
                                                            continue;
                                                        }
                                                    @endphp
                                                    <a href="{{asset('/storage/uploads/' . $img->name) }}">
                                                        <img class = "img animal" src="{{ asset('/storage/uploads/' . $img->name) }}" alt="{{ $img->name }}" />
                                                    </a>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
