<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees / Edit') }}
        </h2>
    </x-slot>
    <div class="container pt-2">
        @include('layouts.alert')
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body p-2">
                <div class="p-2 table-responsive">
                    <form method="post" action="{{route('employees.update',['employee' => $user->id])}}" method="PUT"
                          class="p-4">
                        @csrf
                        @method('PUT')
                        <h4 class="text-center p-4">Employee Details</h4>
                        <div class="row mb-3">
                            <label for="hospital_name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="hospital_name" name="name"
                                       value="{{ old('name', $user->name) }}">
                                @error('name')
                                <div class=" text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="address"
                                          name="address">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email', $user->email) }}">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-4">
                                <input type="phone" class="form-control" id="phone" name="phone"
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                            <div class="col-sm-4">
                                <fieldset class="mb-3 d-flex justify-content-around">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_male"
                                               value="{{ GENDER_MALE }}" {{ $user->gender === GENDER_MALE ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender_male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_female"
                                               value="{{ GENDER_FEMALE }}" {{ $user->gender === GENDER_FEMALE ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender_female">
                                            Female
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                            <label for="dob" class="col-sm-2 col-form-label">D.O.B</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="date" name="dob"
                                       value="{{ old('dob', $user->dob) }}">
                                @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                            <div class="col-sm-4">
                                <fieldset class="mb-3 d-flex justify-content-around">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_active"
                                               value="{{ STATUS_ACTIVE }}" {{ $user->status === STATUS_ACTIVE ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_inactive"
                                               value="{{ STATUS_INACTIVE }}" {{ $user->status === STATUS_INACTIVE ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_inactive">
                                            Inactive
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <hr>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-primary m-1">Update</button>
                            <a type="button" class="btn btn-secondary btn-sm m-1"
                               href="{{ url()->previous() }}">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
<script>
    const emailInput = document.getElementById('phone');
    const emailLoginInput = document.getElementById('phone_login');

    emailInput.addEventListener('input', function () {
        emailLoginInput.value = this.value;
    });
</script>
