@extends('layouts.app')
 
@section('content')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Animal image Upload</title>
</head>


<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload a picture</div>
                        <div class="card-body">
                            <form action="{{ route('fileUpload') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}

                                {{-- show sucess message on successful upload --}}
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    <a href="{{asset('/storage/uploads/' . Session::get('file'))}}"> 
                                        <img class = "img animal" src = "{{asset('/storage/uploads/' . Session::get('file'))}}" >
                                    </a>
                                @endif

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <div class="custom-file">
                                    <label class="custom-file-label" for="chooseFile" ><p id="filename">Select a file</p></label>
                                    <input type="file" name="file" id="chooseFile" onchange="displayFileName(this.files[0].name)" required>
                                    {{-- class="custom-file-input"  --}}
                                </div>
                                <label for="myanimalid"></label>
                                {{-- get the animal id from url --}}
                                <input type="hidden" id="myanimalid" name="myanimalid"
                                    value="{{ $animal}}">

                                <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                                    Upload Files
                                </button>
                            </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
