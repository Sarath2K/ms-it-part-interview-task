<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::with(['roles' => function ($query) {
            $query->where('name', ROLE_EMPLOYEE);
        }])
            ->withTrashed()
            ->whereHas('roles', function ($query) {
                $query->where('name', ROLE_EMPLOYEE);
            })
            ->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->only(['name', 'email', 'password', 'dob', 'phone', 'gender', 'address', 'status']);
            $input['name'] = ucwords($input['name']);

            $uniqueId = User::getUserUniqueId();

            $user = User::create([
                'unique_id' => $uniqueId,
                'name' => $input['name'],
                'phone' => $input['phone'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'dob' => $input['dob'],
                'gender' => $input['gender'],
                'address' => $input['address'],
                'status' => $input['status'],
            ]);

            $user->assignRole(ROLE_EMPLOYEE);

            DB::commit();

            return redirect(route('employees.index'))->with('success', 'Employee Created Successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            logError($e, 'Error While Storing User Details', 'app/Http/Controllers/EmployeeController.php');
            return redirect()->back()->with('error', 'Please Try Again Later!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('employees.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('employees.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $input = $request->only(['name', 'email', 'dob', 'phone', 'gender', 'address', 'status', 'role_id']);
            $input['name'] = ucwords($input['name']);

            $user = User::findOrFail($id);

            $user->update([
                'name' => $input['name'],
                'phone' => $input['phone'],
                'email' => $input['email'],
                'dob' => $input['dob'],
                'gender' => $input['gender'],
                'address' => $input['address'],
                'status' => $input['status'],
            ]);

            DB::commit();
            return redirect(route('employees.index'))->with('success', 'User Updated Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            logError($e, 'Error While Updating Employee Details', 'app/Http/Controllers/EmployeeController.php');
            return redirect()->back()->with('error', 'Please Try Again Later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->update([
                'status' => STATUS_ACTIVE,
            ]);
            $user->delete();
            DB::commit();
            return redirect()->with('success', 'Deactivated the user successfully!');;
        } catch (Exception $exception) {
            DB::rollBack();
            logError($exception, 'Error While Deleting User', 'app/Http/Controllers/EmployeeController.php');
            return redirect()->back()->with('error', 'Please Try Again Later!');
        }
    }
}
