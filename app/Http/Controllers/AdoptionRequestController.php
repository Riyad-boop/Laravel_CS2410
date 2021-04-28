<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account; //gets accounts model
use App\Models\Animals; //gets animals model
use App\Models\Images; //gets images model
use App\Models\AdoptionRequests; //gets requests model
use Gate;   //authentication

class AdoptionRequestController extends Controller
{
      // Adoptionrequests form
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

    //admin modifying a request
    public function modifyAdoptionStatus(Request $request) {
        
        
        //abort action if you are not an admin
        if (Gate::denies('displayall')) {
            abort(403, 'Unauthorized action.');
            }
            
        $accountid = strip_tags(intval($request->useraccount));
        $myanimalid = strip_tags(intval($request->animalid));
        $message = "";

        //change record's status to adopt and change animal owner to the new owner
        //all requests under this animal are automically denied
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
    
        return back()
        ->with('success', $message);
        
    }

    //user sending an adoption request
    public function processAdoptionRequest(Request $request){

         /* Store Request into DATABASE */
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


     // All user Adoptionrequests 
     public function allAdoptionRequestsForm(){

        
        //abort action if you are not an admin
        if (Gate::denies('displayall')) {
            abort(403, 'Unauthorized action.');
            }

            $accounts =  Account::all();
            $requestsQuery = AdoptionRequests::all();
            $animalQuery = Animals::all();
            $imagesQuery = Images::all();
            

            return view('/viewAllRequests', array(
                'animals'=>$animalQuery , 
                'images'=>$imagesQuery, 
                'adoptionRequests'=>$requestsQuery,
                'accounts' =>$accounts,
                'myuserid' => auth()->user()->id));
    }
}
