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

                        <table class="table table-striped table-bordered table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th><button class = "btn btn-block" onclick="sortTableByLetters(0)"><strong>Request Status</strong></button>
                                        @if(Auth::user()->role === 1)
                                        <?php 
                                        if($animal->userid ===1){
                                        $message = '<div class="alert alert-info">
                                            <strong>Available for adoption</strong>
                                            </div>';
                                        }
                                        // else the animal is already owned by someone
                                        else{
                                            $message = '
                                                        <div class="alert alert-success">
                                                        <strong>Approved</strong>
                                                        </div>';
                                         }    
                                         echo $message;
                                        ?>
                                        
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
                                        
                                    
                                    <th>Description</th>
                                    <th>Images</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($animals as $animal)
                                    <tr>     
                                        <td>
                                            <?php 
                                            if($animal->userid ===1){
                                            $message = '<div class="alert alert-info">
                                                <strong>Available for adoption</strong>
                                                </div>';
                                            }
                                            // else the animal is already owned by someone
                                            else{
                                                $message = '
                                                            <div class="alert alert-success">
                                                            <strong>Approved</strong>
                                                            </div>';
                                             }    
                                             echo $message;
                                            ?>
                                            @if (Auth::user()->role === 1)
                                                <?php $redirecturl = url('ManageAdoptionRequest'); $redirecturl.= '/'.$animal->id; ?>
                                                <a href= "{{$redirecturl}}">
                                                    <button class="btn btn-primary">                                 
                                                        View Or Manage Adoption Requests
                                                    </button>
                                                </a>
                                            @else
                                                 <div class="alert alert-success">
                                                <strong>Approved!</strong>
                                                </div>
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

                                            @if (Auth::user()->role === 1)
                                                <?php $redirecturl = url('upload-file'); $redirecturl.= '/'.$animal->id; ?>
                                                <a href= "{{$redirecturl}}">
                                                    <button class="btn btn-primary btn-block">                                 
                                                        Upload Another picture
                                                    </button>
                                                </a>
                                            @endif
                                        </td>
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
