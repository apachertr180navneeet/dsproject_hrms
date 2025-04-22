@extends('admin.layouts.app')
@section('style')
    <style>
        .text-danger {
            font-size: 0.875rem;
            margin-top: 2px;
        }
    </style>
@endsection  
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Employee /</span> Edit 
    </h4>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#basicinformation" aria-controls="basicinformation" aria-selected="true">Basic Infomation</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#employeedetail" aria-controls="employeedetail" aria-selected="false" tabindex="-1">Employee Detail</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#document" aria-controls="document" aria-selected="false" tabindex="-1">Documents</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="basicinformation" role="tabpanel">
                        <form id="basicInfoForm" enctype="multipart/form-data">
                            <input type="hidden" name="employee_id" value="{{ $getUser->id }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $getUser->full_name }}"/>
                                    <div class="text-danger" id="error-name"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter Date of birth" value="{{ \Carbon\Carbon::parse($getUser->date_of_birth)->format('Y-m-d') }}" />
                                    <div class="text-danger" id="error-dob"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input class="form-control" type="tel" id="phone" name="phone" placeholder="" value="{{ $getUser->phone }}" />
                                    <div class="text-danger" id="error-phone"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ $getUser->email }}">
                                    <div class="text-danger" id="error-email"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="joining_date" class="form-label">Joining Date</label>
                                    <input type="date" class="form-control" id="joining_date" name="joining_date" placeholder="Enter Joining Date" value="{{ \Carbon\Carbon::parse($getUser->date_of_joing)->format('Y-m-d') }}"/>
                                    <div class="text-danger" id="error-joining_date"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="base_salary" class="form-label">Base Salary</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">€</span>
                                        <input type="number" class="form-control" placeholder="Enter Base Salary" id="base_salary" name="base_salary" min="0" value="{{ $getUserdetail->base_salary }}" />
                                        <span class="input-group-text">.00</span>
                                    </div>
                                    <div class="text-danger" id="error-base_salary"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="profile" class="form-label">Profile Picture</label>
                                    <input class="form-control" type="file" id="profile" name="profile" accept="image/*" />
                                    <div class="text-danger" id="error-profile"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <img src="{{ $getUser->avatar ? asset('storage/' . $getUser->avatar) : asset('images/default.png') }}" alt="Profile Image" style="width: 28%; border: 1px solid red; padding: 1%;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="basic_info_submit">Save</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="employeedetail" role="tabpanel">
                        <form id="employeeinfoForm" enctype="multipart/form-data">
                            <div class="row">
                                <input type="hidden" id="employee_id" name="employee_id" value="{{ $getUserdetail->user_id }}"/>
                                <div class="col-md-6 mb-3">
                                    <label for="refrence_name" class="form-label">Refrence Name</label>
                                    <input type="text" class="form-control" id="refrence_name" name="refrence_name" placeholder="Enter Reference Name" value="{{ $getUserdetail->refrence_name }}"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="refrence_phone" class="form-label">Refrence Phone</label>
                                    <input type="tel" class="form-control" id="refrence_phone" name="refrence_phone" placeholder="Enter Reference Phone" value="{{ $getUserdetail->refrence_phone }}"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ni_number" class="form-label">NI Number</label>
                                    <input type="text" class="form-control" id="ni_number" name="ni_number" placeholder="Enter NI Number" value="{{ $getUserdetail->ni_number }}"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="utr_number" class="form-label">UTR Number</label>
                                    <input type="text" class="form-control" id="utr_number" name="utr_number" placeholder="Enter UTR Number" value="{{ $getUserdetail->utr_number }}"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit_employee_detail">Save</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="document" role="tabpanel">
                        <form method="POST" action="{{ route('admin.employee.save.employee.document') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="doc_employee_id" name="doc_employee_id" value="{{ $getUser->id }}" />
                                <h5>Passport</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="passport" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="passport" value="Passport" name="passport" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="passport_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" id="passport_expiry_date" name="passport_expiry_date" placeholder="" value="{{ $documents['Passport']['expirydate'] }}" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="passport_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="passport_document_file" name="passport_document_file"/>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <img src="{{ $documents['Passport']['file'] ? asset('storage/' . $documents['Passport']['file']) : asset('images/default.png') }}" alt="Profile Image" style="width: 50%; border: 1px solid red; padding: 1%;">
                                </div>
                                
                                
                                <h5>BRP/Visa</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="visa" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="visa" name="visa" value="BRP/Visa" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="visa_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="{{ $documents['BRP/Visa']['expirydate'] }}" id="visa_expiry_date" name="visa_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="visa_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="visa_document_file" name="visa_document_file"/>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <img src="{{ $documents['BRP/Visa']['file'] ? asset('storage/' . $documents['BRP/Visa']['file']) : asset('images/default.png') }}" alt="Profile Image" style="width: 50%; border: 1px solid red; padding: 1%;">
                                </div>
                                
                                
                                <h5>License</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="license" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="license" name="license" value="License" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="license_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="{{ $documents['License']['expirydate'] }}" id="license_expiry_date" name="license_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="license_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="license_document_file" name="license_document_file"/>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <img src="{{ $documents['License']['file'] ? asset('storage/' . $documents['License']['file']) : asset('images/default.png') }}" alt="Profile Image" style="width: 50%; border: 1px solid red; padding: 1%;">
                                </div>


                                <h5>DBS</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="dbs" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="dbs" value="DBS" name="dbs" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dbs_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="{{ $documents['DBS']['expirydate'] }}" id="dbs_expiry_date" name="dbs_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="dbs_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="dbs_document_file" name="dbs_document_file"/>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <img src="{{ $documents['DBS']['file'] ? asset('storage/' . $documents['DBS']['file']) : asset('images/default.png') }}" alt="Profile Image" style="width: 50%; border: 1px solid red; padding: 1%;">
                                </div>


                                <h5>CSCS card</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="cscscard" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="cscscard" name="cscscard" value="CSCS card" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cscscard_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="{{ $documents['CSCScard']['expirydate'] }}" id="cscscard_expiry_date" name="cscscard_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="cscscard_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="cscscard_document_file" name="cscscard_document_file" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <img src="{{ $documents['CSCScard']['file'] ? asset('storage/' . $documents['CSCScard']['file']) : asset('images/default.png') }}" alt="Profile Image" style="width: 50%; border: 1px solid red; padding: 1%;">
                                </div>

                                <h5>NPORS/CPCS card</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="nrors_cpcs" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="nrors_cpcs" name="nrors_cpcs" value="NPORS/CPCS card" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="nrors_cpcs_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="{{ $documents['NPORS/CPCScard']['expirydate'] }}" id="nrors_cpcs_expiry_date" name="nrors_cpcs_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="nrors_cpcs_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="nrors_cpcs_document_file" name="nrors_cpcs_document_file" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <img src="{{ $documents['NPORS/CPCScard']['file'] ? asset('storage/' . $documents['NPORS/CPCScard']['file']) : asset('images/default.png') }}" alt="Profile Image" style="width: 50%; border: 1px solid red; padding: 1%;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="basic_info_submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
@section('script')
    <script>
        flatpickr("#dob", {
            dateFormat: "d-m-Y", // Format as DD-MM-YYYY
            allowInput: true,
        });
        flatpickr("#joining_date", {
            dateFormat: "d-m-Y", // Format as DD-MM-YYYY
            allowInput: true,
        });
        flatpickr("#expiry_date", {
            dateFormat: "d-m-Y", // Format as DD-MM-YYYY
            allowInput: true,
        });
        document.getElementById("base_salary").addEventListener("input", function () {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#basic_info_submit').on('click', function (e) {
                e.preventDefault();
        
                // Clear previous error messages
                $('.text-danger').text('');
        
                let formData = new FormData($('#basicInfoForm')[0]);
                console.log(formData);
        
                $.ajax({
                    url: "{{ route('admin.employee.save.basic.info') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('#basic_info_submit').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Basic info saved successfully!');
                            $('#employee_id').val(response.user_id);
                    
                            // Switch tabs
                            $('#basicinformation').removeClass('active show');
                            $('#employeedetail').addClass('active show');
                    
                            // Update the tab buttons
                            $('.nav-link').removeClass('active'); // Remove active class from all tabs
                            $('button[data-bs-target="#employeedetail"]').addClass('active'); // Add active class to the target tab
                        } else {
                            // Handle validation errors
                            if (response.errors) {
                                $.each(response.errors, function (key, value) {
                                    $('#error-' + key).text(value[0]);
                                });
                            } else {
                                alert('Something went wrong!');
                            }
                        }
        
                        $('#basic_info_submit').prop('disabled', false).text('Save');
                    }, // <-- Add a comma here
                    error: function (xhr) {
                        $('#basic_info_submit').prop('disabled', false).text('Save');
        
                        console.log(xhr.responseJSON); // Log the entire response for debugging
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $('#error-' + key).text(value[0]);
                            });
                        } else {
                            alert('Something went wrong!');
                            console.log(xhr.responseText);
                        }
                    }
                });
            });


            $('#submit_employee_detail').on('click', function (e) {
                e.preventDefault();
        
                // Clear previous error messages
                $('.text-danger').text('');
        
                let formData = new FormData($('#employeeinfoForm')[0]);
                console.log(formData);
        
                $.ajax({
                    url: "{{ route('admin.employee.save.employee.detail') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('#submit_employee_detail').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Employee Detail saved successfully!');
                            $('#doc_employee_id').val(response.user_id);
                    
                            // Switch tabs
                            $('#employeedetail').removeClass('active show');
                            $('#document').addClass('active show');
                    
                            // Update the tab buttons
                            $('.nav-link').removeClass('active'); // Remove active class from all tabs
                            $('button[data-bs-target="#document"]').addClass('active'); // Add active class to the target tab
                        } else {
                            // Handle validation errors
                            if (response.errors) {
                                $.each(response.errors, function (key, value) {
                                    $('#error-' + key).text(value[0]);
                                });
                            } else {
                                alert('Something went wrong!');
                            }
                        }
        
                        $('#submit_employee_detail').prop('disabled', false).text('Save');
                    }, // <-- Add a comma here
                    error: function (xhr) {
                        $('#submit_employee_detail').prop('disabled', false).text('Save');
        
                        console.log(xhr.responseJSON); // Log the entire response for debugging
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $('#error-' + key).text(value[0]);
                            });
                        } else {
                            alert('Something went wrong!');
                            console.log(xhr.responseText);
                        }
                    }
                });
            });
        });   
    </script>
    
@endsection
