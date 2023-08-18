<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container pb-3">
        <div class="row pt-5">
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Employees</h5>
                        <table class="table table-bordered table-sm">
                            <tbody>
                            <tr>
                                <th>Total</th>
                                <td>{{ $employeeCount['total'] }}</td>
                            </tr>
                            <tr>
                                <th>Admin</th>
                                <td>{{ $employeeCount[ROLE_ADMIN] }}</td>
                            </tr>
                            <tr>
                                <th>Employee</th>
                                <td>{{ $employeeCount[ROLE_EMPLOYEE] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- End Employees Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">This Month Employees</h5>
                        <table class="table table-bordered table-sm">
                            <tbody>
                            <tr>
                                <th>Total</th>
                                <td>{{ $employeeCount['this_month'] }}</td>
                            </tr>
                            <tr>
                                <th>Active</th>
                                <td>{{ $employeeCount['active_employee'] }}</td>
                            </tr>
                            <tr>
                                <th>Inactive</th>
                                <td>{{ $employeeCount['in_active_employee'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- End Employees Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Today Employees</h5>
                        <table class="table table-bordered table-sm">
                            <tbody>
                            <tr>
                                <th>Total</th>
                                <td>{{ $employeeCount['today'] }}</td>
                            </tr>
                            <tr>
                                <th>Active</th>
                                <td>{{ $employeeCount['today_active_employee'] }}</td>
                            </tr>
                            <tr>
                                <th>Inactive</th>
                                <td>{{ $employeeCount['today_inactive_employee'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- End Employees Card -->
        </div>

        <div class="pt-4">
            <div class="card">
                <div class="card-body p-5">
                    <h5 class="card-title">Employees Chart</h5>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var employeeCounts = @json($employeeCount);
    var monthNames = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JULY', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Employees',
                    data: Object.values(employeeCounts['by_month']),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
