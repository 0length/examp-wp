<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::getAllCustomers();

        return view ('customers.index')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input      = $request->all();
        $file       = $request->file('ktp');
        $filename   = str_replace(" ", "_", $request->post('nama')) . '-' . md5(date('Y-m-d H:i:s')) . '.' . $file->extension();

        if ($input['password'] != $input['retype_password']) {
            return redirect(route('customer.create'));
        }

        $path = 'public/images';
        $path = $file->storeAs($path, $filename);

        if (!$path) {
            echo "error upload";
            exit;
        }

        $data_users = array(
            "name"      => $input['name'],
            "email"     => $input['email'],
            "password"  => Hash::make($input['password']),
            "role"      => User::getRoleCustomer()
        );

        $user = User::create($data_users);

        $item_data = array(
            "user_id"       => $user->id,
            "born_date"     => $input['born_date'],
            'born_place'    => $input['born_place'],
            'gender'        => $input['gender'],
            'address'       => $input['address'],
            'ktp_path'      => $path
        );

        Customer::create($item_data);
        return redirect('customer')->with('status', 'Customer Created!');  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::getCustomerDetails($id);
        $customer->ktp_path = Storage::url($customer->ktp_path);
        return view ('customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::getCustomerDetails($id);
        $customer->ktp_path = Storage::url($customer->ktp_path);

        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer   = Customer::find($id);
        $input  = $request->all();

        $file   = $request->file('ktp');
        $path   = $customer->ktp_path;
        if (isset($file)) {
            $filename   = str_replace(" ", "_", $request->post('nama')) . '-' . md5(date('Y-m-d H:i:s')) . '.' . $file->extension();

            $path = 'public/images';
            $path = $file->storeAs($path, $filename);

            if (!$path) {
                echo "error upload";
                exit;
            }
        }

        $customer_data = array(
            "born_date"          => $input['born_date'],
            'born_place'     => $input['born_place'],
            'gender'         => $input['gender'],
            'address'          => $input['address'],
            'ktp_path'     => $path
        );

        $customer->update($customer_data);

        $user_id = $customer->user_id;
        $user = User::find($user_id);

        $user_data = array(
            "email" => $input["email"],
            "name"  => $input['name']
        );
        $user->update($user_data);

        return redirect('customer')->with('status', 'Customer Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer   = Customer::find($id);
        $user       = User::find($customer->user_id);

        $customer->delete();
        $user->delete();

        return redirect('customer')->with('status', 'Customer Deleted!');
    }
}
