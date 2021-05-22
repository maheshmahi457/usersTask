<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Listing Users
     * @param empty
     * @return object and view
     */
    public function getUsers()
    {
        $usersList = User::all();
        return view('users', compact('usersList'));
    }

    /**
     * User registration
     * @param $request
     * @return string
     */
    public function addUser(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email',
            'fullName' => 'required|max:255|min:2',
            'fileName' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'joiningDate' => 'required|before:today',
        ]);
        if ($request->leavingDate and $request->isWorking) {
            return back()
                ->with('failure', 'choose either leaving date or still working field, but not both');
        }
        $data = [
            'email' => $request->email,
            'full_name' => $request->fullName,
            'file_path' => $request->file('fileName')->store('images'),
            'joining_date' => $request->joiningDate,
            'leaving_date' => $request->leavingDate,
            'is_working' => boolval($request->isWorking)
        ];
        $return = User::create($data);
        if ($return)
            return back()
                ->with('success', 'User Added Successfully.');
        else {
            return back()
                ->with('failure', 'Failed to Add User');
        }
    }

    /**
     * User delete
     * @param $request
     * @return string
     */
    public function deleteUser(Request $request)
    {
        $return = User::find($request->id)->delete();
        if ($return)
            return back()
                ->with('success', 'User Deleted Successfully.');
        else {
            return back()
                ->with('failure', 'Failed to Delete User');
        }
    }
}
