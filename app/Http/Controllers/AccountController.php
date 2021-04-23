<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account; //task 2
use App\Models\Animals; //cwk
use App\Models\Images; //cwk
use App\Models\AdoptionRequests; //cwk
use DB; //cwk
use Gate;   //lab 4 step 7


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
    

    //adoptionrequests
    public function adoptionRequestsManagerForm($id){

        
        //abort action if you are not an admin
        if (Gate::denies('displayall')) {
            abort(403, 'Unauthorized action.');
            }

            $myanimalid = $id;

            $accounts =  Account::all();
            $requestsQuery = AdoptionRequests::where('animalid',$myanimalid )->get();
            $animalQuery = Animals::where('id',$myanimalid)->get();
            $approvedOwner = $accounts->where('userid',$animalQuery[0]->userid);
            $imagesQuery = Images::where('animalid',$myanimalid)->get();
            

            return view('/adoptionRequestManager', array(
                'animals'=>$animalQuery , 
                'images'=>$imagesQuery, 
                'adoptionRequests'=>$requestsQuery,
                'approvedaccount'=> $approvedOwner,
                'accounts' =>$accounts,
                'myuserid' => auth()->user()->id));
    }

    public function modifyAdoptionStatus(Request $request) {
        
        
        //abort action if you are not an admin
        if (Gate::denies('displayall')) {
            abort(403, 'Unauthorized action.');
            }
            
        $accountid = strip_tags(intval($request->useraccount));
        $myanimalid = strip_tags(intval($request->animalid));
        $message = "";

        if(strip_tags($request->useradoptstatus) === "Approve"){
                

                AdoptionRequests::where('animalid',$myanimalid)->update(array(
                    'pending'=>0,
                    'denied'=>1,
                ));

                AdoptionRequests::where('animalid',$myanimalid)->where('userid',$accountid)->update(array(
                    'denied'=>0,
                    'adopted'=>1,
                ));

                //set new owner
                Animals::where('id',$myanimalid)->update(array(
                    'userid'=>$accountid,
                ));
                $message = 'You have approved an adoption request';
        }
        else if(strip_tags($request->useradoptstatus) === "Deny"){
                AdoptionRequests::where('animalid',$myanimalid)->where('userid',$accountid)->update(array(
                    'pending'=>0,
                    'denied'=>1,
                ));
                $message = 'You have denied an adoption request';
        }
    
        //update pending and denied users string array, and set a new approved user
        // DB::update('update adoption_requests set adopted = ?, pending = ?, denied = ? , where id = ? , where animalid = ?',[1,0,0,$accountid,$myanimalid]); 

        return back()
        ->with('success', $message);
        
    }

    public function processAdoptionRequest(Request $request){

        $AdoptionRequestModel = new AdoptionRequests;
        $AdoptionRequestModel->userid = auth()->user()->id;
        $AdoptionRequestModel->animalid = strip_tags($request->myanimalid);
        $AdoptionRequestModel->pending = 1;
        $AdoptionRequestModel->denied = 0;
        $AdoptionRequestModel->adopted = 0;
        $AdoptionRequestModel->save();

        
         return back()
         ->with('success', 'You have sucessfuly submitted an adoption request for ' . strip_tags($request->myanimalname));
    }
   
}
