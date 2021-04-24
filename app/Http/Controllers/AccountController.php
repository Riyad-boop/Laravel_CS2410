<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account; //gets accounts model
use App\Models\Animals; //gets animals model
use App\Models\Images; //gets images model
use App\Models\AdoptionRequests; //gets requests model
use Gate;   //authentication


class AccountController extends Controller
{
  
    public function getRegisterForm(){
       
        $account = Account::all();
        
        $account=$account->where('userid', auth()->user()->id);

        return view('registerAccount', array('account' => $account));
    }


    public function saveUserdetails(Request $request) {
        /* Store userdetails into DATABASE */
        $accountModel = new Account;
            
        $accountModel->userid = auth()->user()->id;  
        $accountModel->firstname = strip_tags($request->fname);
        $accountModel->lastname = strip_tags($request->lname); 
        $accountModel->occupation = strip_tags($request->Occupation);
        $accountModel->contactemail = auth()->user()->email; 
        $accountModel->contactnumber = strip_tags($request->phonenum); 
        $accountModel->DOB = strip_tags($request->DOB);
        $accountModel->save();

        return back()
            ->with('success', 'You have sucessfuly registred, and now eligible to send adoption requests');
            }


    //display myanimals 
    public function showAnimals()
    {

    $animalQuery = Animals::all();
    $imagesQuery = Images::all();

    //only show all animals if you are the admin, else display animals which are not already adopted by this user 
    if (Gate::denies('displayall')) {
        $animalQuery=$animalQuery->where('userid', auth()->user()->id);
    }
   
        
    return view('/showMyAnimals', array('animals'=>$animalQuery , 'images'=>$imagesQuery));
    }


     //displaying all animals
     public function displayAnimals()
     {
 
     $animalQuery = Animals::all();
     $imagesQuery = Images::all();
     $requestsQuery = AdoptionRequests::all();
     $account =  Account::all();
 
     //only display animals which are not already adopted by this user 
     if (Gate::denies('displayall')) {
         $animalQuery=$animalQuery->whereNotIn('userid', auth()->user()->id); //get all animals which are not adopted by any user
         $requestsQuery=$requestsQuery->where('userid', auth()->user()->id);
          $account=$account->where('userid', auth()->user()->id);
     }
 
     return view('/displayAnimals', array('animals'=>$animalQuery , 'images'=>$imagesQuery, 'adoptionRequests' => $requestsQuery, 'account' => $account, 'userrole' => auth()->user()->role));
     }
   
}
