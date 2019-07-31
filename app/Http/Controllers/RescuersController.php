<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rescuer;
use Image;
use Mail;
use App\Mail\sendMail;

class RescuersController extends Controller
{
    public function index(){
        return view('admin/add-rescuer');
    }

    public function store(request $request){
        $rescuer = new Rescuer();
        if($request->hasFile('file')){
        $filename = $request->file->getClientOriginalName();
        
        $rescuer->image = date('Y-m-d-H:i:s').$filename;
        $rescuer->name=request('name');
        $rescuer->email=request('email');
        $rescuer->aadhar=request('aadhar');
        $rescuer->bloodgroup=request('bloodgroup');
        $rescuer->dob=request('dob');
        $rescuer->phone1=request('phone1');
        $rescuer->phone2=request('phone2');
        $rescuer->constituency=request('constituency');
        $rescuer->address=request('address');
        $rescuer->save();

        $path = public_path('storage/upload/rescuer/' . $filename);
        Image::make($request->file('file')->getRealPath())->resize(300, 200)->save($path);

        //send mail
        Mail::Send(new sendMail());
        }
        return redirect('/admin/add-rescuer');
    }
}