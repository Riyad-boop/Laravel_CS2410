@extends('layouts.app')

@section('content')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- show success message on valid adoprtion request--}}
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
                @endif


                @if (Auth::user()->role !== 1 && count($account) === 0)
                <div class="card">
                    <div class="card-header">Complete registration</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('completeregister') }}">
                            @csrf
    
                            <div class="form-group row">
                                <label for="fname" class="col-md-4 col-form-label text-md-right">First name</label>
    
                                <div class="col-md-6">
                                    <input type="text" id="fname" name="fname" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lname" class="col-md-4 col-form-label text-md-right">Last name</label>
    
                                <div class="col-md-6">
                                    <input type="text" id="lname" name="lname" required>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="Occupation" class="col-md-4 col-form-label text-md-right">Occupation</label>
    
                                <div class="col-md-6">
                                    <input type="text" id="Occupation" name="Occupation" required>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="phonenum" class="col-md-4 col-form-label text-md-right">Mobile number (+44):</label>
    
                                <div class="col-md-6">
                                    <input type="tel" id="phonenum" name="phonenum" pattern="[0-9]{11}" placeholder="07832 22 4268" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="DOB" class="col-md-4 col-form-label text-md-right">Date of birth</label>
                               
                                <div class="col-md-6">
                                    <input type="date" id="DOB" name="DOB" min="1900-01-02" max="<?php echo date('Y-m-d');?>" required>
                                </div>
                            </div>
    
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-8">
                                    <button class="btn btn-primary">
                                        Save
                                    </button>
    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                    <div class="card">
                        <div class="card-header">Registration Complete!</div>
                            <div class="card-body">
                                <a href = "{{ route('home') }}" ><button class ="btn btn-primary">Click here to return home</button></a>
                            </div>
                        </div>
                    </div>
                @endif

         
            </div>
        </div>
    </div>
</div>
@endsection
