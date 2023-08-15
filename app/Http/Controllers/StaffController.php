<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::getAllStaffs();

        return view ('staffs.index')->with('staffs', $staffs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input      = $request->all();

        if ($input['password'] != $input['retype_password']) {
            return redirect(route('staff.create'));
        }

        $data_users = array(
            "name"      => $input['name'],
            "email"     => $input['email'],
            "password"  => Hash::make($input['password']),
            "role"      => User::getRoleAdmin()
        );

        $user = User::create($data_users);

        $staff_data = array(
            "user_id"       => $user->id,
            'gender'        => $input['gender']
        );

        Staff::create($staff_data);
        return redirect('staff')->with('status', 'Staff Created!');  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $staff = Staff::getStaffDetails($id);
        return view('staffs.show')->with('staff', $staff);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $staff = Staff::getStaffDetails($id);
        return view('staffs.edit')->with('staff', $staff);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff   = Staff::find($id);
        $input   = $request->all();

        $staff_data = array(
            'gender'         => $input['gender'],
        );

        $staff->update($staff_data);

        $user_id = $staff->user_id;
        $user = User::find($user_id);

        $user_data = array(
            "email" => $input["email"],
            "name"  => $input['name']
        );
        $user->update($user_data);

        return redirect('staff')->with('status', 'Staff Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff   = Staff::find($id);
        $staff->delete();
        return redirect('staff')->with('status', 'Staff Deleted!');
    }
}
