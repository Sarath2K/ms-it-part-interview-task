<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees / Show') }}
        </h2>
    </x-slot>
    <div class="container pt-2">
        @include('layouts.alert')
    </div>
    <section class="section">
        <div class="card">
            <div class="container card-body p-4">
                <h4 class="text-center p-4">Employee Details</h4>
                <div class="row">
                    <div class="row mb-3">
                        @php
                            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                        @endphp
                        <div class="col-sm-2">Unique Id</div>
                        <div class="col-sm-5">{{ $user->employee_id??'-' }}</div>
                        <div
                            class="col-sm-5">{!! $generator->getBarcode( $user->employee_id, $generator::TYPE_CODE_128) !!}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-2">Designation</div>
                        <div class="col-sm-10">{{ $user->roles[0]['name'] }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-2">First Name</div>
                        <div class="col-sm-10">{{ $user->f_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-2">Last Name</div>
                        <div class="col-sm-10">{{ $user->l_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-2">DOB</div>
                        <div class="col-sm-4">{{ $user->dob??'-' }}</div>
                        <div class="col-sm-2">Education Qualification</div>
                        <div class="col-sm-4">{{ $user->edu_qualification }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-2">Gender</div>
                        <div class="col-sm-4">{{ $user->gender }}</div>
                        <div class="col-sm-2">Address</div>
                        <div class="col-sm-4">{{ $user->address?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-2">Email</div>
                        <div class="col-sm-4">{{ $user->email }}</div>
                        <div class="col-sm-2">Phone</div>
                        <div class="col-sm-4">{{ $user->phone }}</div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-end">
                        <a type="button" class="btn btn-primary btn-sm m-1"
                           href="{{ route('employees.edit', $user->id) }}">Edit</a>
                        <a type="button" class="btn btn-secondary btn-sm m-1"
                           href="{{ url()->previous() }}">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
