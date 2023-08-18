<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Retrieve the required data to display in dashboard.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $roles = Role::all();
        $employeeCounts = [];

        // Get current year
        $currentYear = Carbon::now()->year;

        // Total user count
        $totalUserCount = User::count();
        $employeeCounts['total'] = $totalUserCount;

        // User count by this month
        $userCountThisMonth = User::whereYear('created_at', '=', $currentYear)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count();
        $employeeCounts['this_month'] = $userCountThisMonth;

        // Today's user count
        $todayUserCount = User::whereDate('created_at', '=', Carbon::today())
            ->count();
        $employeeCounts['today'] = $todayUserCount;

        // Today's active user count
        $todayActiveUserCount = User::where('status', STATUS_ACTIVE)
            ->whereDate('created_at', '=', Carbon::today())
            ->count();
        $employeeCounts['today_active_employee'] = $todayActiveUserCount;

        // Today's inactive user count
        $todayInactiveUserCount = User::where('status', STATUS_INACTIVE)
            ->whereDate('created_at', '=', Carbon::today())
            ->count();
        $employeeCounts['today_inactive_employee'] = $todayInactiveUserCount;

        // Active user count
        $activeUserCount = User::where('status', STATUS_ACTIVE)->count();
        $employeeCounts['active_employee'] = $activeUserCount;

        // Inactive user count
        $inactiveUserCount = User::where('status', STATUS_INACTIVE)->count();
        $employeeCounts['in_active_employee'] = $inactiveUserCount;

        foreach ($roles as $role) {
            $employeeCounts[$role->name] = User::role($role->name)->count();
        }

        // Calculate user counts for each month
        $currentYear = Carbon::now()->year;
        $userCountsByMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', '=', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize an array to store counts for each month
        $months = range(1, 12);
        $employeeCountsByMonth = array_fill_keys($months, 0);

        // Populate the counts for each month
        foreach ($userCountsByMonth as $count) {
            $employeeCountsByMonth[$count->month] = $count->count;
        }

        $employeeCounts['by_month'] = $employeeCountsByMonth;

        return view('dashboard', ['employeeCount' => $employeeCounts]);
    }
}
