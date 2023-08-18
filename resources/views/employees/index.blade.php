<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-body p-2">
                <div class="p-2 table-responsive">
                    <table class="table table-bordered data-table w-100">
                        <thead>
                        <tr class="table-primary text-center">
                            <th>Name</th>
                            <th>Unique ID</th>
                            <th>Designation</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->unique_id }}</td>
                                <td>{{ $employee->roles[0]['name'] }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->gender }}</td>
                                <td>{{ $employee->status }}</td>
                                <td class="d-flex justify-content-around">
                                    <div>
                                        <a type="button" class="btn btn-sm btn-info"
                                           href="{{ route('employees.show',$employee->id) }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <a type="button" class="btn btn-sm btn-warning"
                                           href="{{ route('employees.edit',$employee->id) }}"><i
                                                class="ri-file-edit-line"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <form action="{{ route('employees.destroy', $employee->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="ri-delete-bin-6-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
