<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animals;
use App\Models\Images;
use Gate;   //lab 4 step 7

class AnimalController extends Controller
{
    //text data upload 
    public function uploadAnimal()
    {
        //abort action if you are not an admin
        if (Gate::denies('displayall')) {
            abort(403, 'Unauthorized action.');
            }

        return view('animalUpload');
    }

    public function animaldataUpload(Request $request){

        
        //abort action if you are not an admin
        if (Gate::denies('displayall')) {
            abort(403, 'Unauthorized action.');
            }

        // $request->validate([
        //     'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);


        /* Store animal into DATABASE */
        $animalModel = new Animals;
      
        $animalModel->userid = 1;   //set default user owner to the admin which is id 1.
        $animalModel->name = strip_tags($request->name);
        $animalModel->type = strip_tags($request->type);
        $animalModel->DOB = strip_tags($request->DOB);
        $animalModel->description = strip_tags($request->animaldescription);
        $animalModel->save();


       

        // //returns session variables on sucessful post
        // $imageName = time().'.'.$request->file->extension();  
        // $request->file->move(public_path('images'), $imageName);

        // redirect()->route()->with();
        return back()
            ->with('success', 'You have sucessfuly uploaded a new animal')
            ->with('animalid', $animalModel->id);
    }


    //image upload 
    public function createForm($id)
    {
        //abort action if you are not an admin
        if (Gate::denies('displayall')) {
            abort(403, 'Unauthorized action.');
            }

        return view('animalImageUpload',array('animal'=>$id));
    }

    public function fileUpload(Request $request)
    {

        //abort action if you are not an admin
        if (Gate::denies('displayall')) {
            abort(403, 'Unauthorized action.');
            }

        $request->validate([

            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);


        /* Store image name in DATABASE and store image file in SERVER */
        $fileModel = new Images;
        
        $fileName = time() . '_' . strip_tags($request->file->getClientOriginalName());
        $filePath = strip_tags($request->file('file')->storeAs('uploads', $fileName, 'public'));

        $fileModel->name = basename($filePath); //stores filename
        $fileModel->file_path = '/storage/' . $filePath;
        $fileModel->animalid = strip_tags($request->myanimalid);
        $fileModel->save();

        return back()
            ->with('success', 'You have successfully uploaded an image.')
            ->with('file', $fileName);
    }
}
