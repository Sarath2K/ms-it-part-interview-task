<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
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
            ->paginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->only(['f_name', 'l_name', 'dob', 'edu_qualification', 'gender', 'address', 'email', 'phone']);
            $input['f_name'] = ucwords($input['f_name']);
            $input['l_name'] = ucwords($input['l_name']);

            $employeeId = User::getUserUniqueId();

            $user = User::create([
                'employee_id' => $employeeId,
                'f_name' => $input['f_name'],
                'l_name' => $input['l_name'],
                'dob' => $input['dob'],
                'edu_qualification' => $input['edu_qualification'],
                'gender' => $input['gender'],
                'address' => $input['address'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'password' => Hash::make('password'),
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
        $user = User::withTrashed()->with('roles')->findOrFail($id);
        return view('employees.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('employees.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $input = $request->only(['f_name', 'l_name', 'dob', 'edu_qualification', 'gender', 'address', 'email', 'phone']);
            $input['f_name'] = ucwords($input['f_name']);
            $input['l_name'] = ucwords($input['l_name']);

            $user = User::withTrashed()->findOrFail($id);

            $user->update([
                'f_name' => $input['f_name'],
                'l_name' => $input['l_name'],
                'dob' => $input['dob'],
                'edu_qualification' => $input['edu_qualification'],
                'gender' => $input['gender'],
                'address' => $input['address'],
                'email' => $input['email'],
                'phone' => $input['phone'],
            ]);

            DB::commit();
            return redirect(route('employees.index'))->with('success', 'Employee Updated Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            logError($e, 'Error While Updating Employee Details', 'app/Http/Controllers/EmployeeController.php');
            return redirect()->back()->with('error', 'Please Try Again Later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();
            return redirect(route('employees.index'))->with('success', 'Deactivated the employee successfully!');;
        } catch (Exception $exception) {
            DB::rollBack();
            logError($exception, 'Error While Deleting User', 'app/Http/Controllers/EmployeeController.php');
            return redirect()->back()->with('error', 'Please Try Again Later!');
        }
    }

    /**
     * @return BinaryFileResponse
     */
    public function exportUsers()
    {
        $fileName = now() . 'users';
        return Excel::download(new UsersExport, $fileName . '.xlsx');
    }
}
