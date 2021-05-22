<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getUsers(){
        $usersList = User::all();
        return view('users',compact('usersList'));
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'fullName' => 'required|max:255|min:2',
            'fileName' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $path = $request->file('fileName')->store('images');
        $data = [
            'email' => $request->email,
            'full_name' => $request->fullName,
            'file_path' => $path,
            'joining_date' => $request->joiningDate,
            'leaving_date' => $request->leavingDate,
            'is_working' => boolval($request->isWorking)
        ];
        $return = User::create($data);
        if($return)
            return back()
                ->with('success','You have Added User.');
        else{
            return back()
                ->with('failure','Failed to add User');
        }
    }

    public function deleteUser(Request $request){
        $return = User::find($request->id)->delete();
        if($return)
            return back()
                ->with('success','Deleted user Successfully');
        else{
            return back()
                ->with('failure','Failed to delete User');
        }
    }
}
