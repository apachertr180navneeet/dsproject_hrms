@extends('admin.layouts.app')
@section('style')
    <style>
        
    </style>
@endsection  
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Employee /</span> Add
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
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of birth</label>
                                    <input type="date" class="form-control" id="dob" placeholder="Enter Date of birth"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input class="form-control" type="tel" value="" id="phone" placeholder="" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="joining_date" class="form-label">Joining Date</label>
                                    <input type="date" class="form-control" id="joining_date" placeholder="Enter Joining Date"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="base_salary" class="form-label">Base Salary</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">€</span>
                                        <input type="number" class="form-control" placeholder="Enter Base Salary" id="base_salary" min="0" />
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="profile" class="form-label">Profile Picture</label>
                                    <input class="form-control" type="file" id="profile" accept="image/*" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="basic_info_submit">Save</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="employeedetail" role="tabpanel">
                        <form>
                            <div class="row">
                                <input type="hidden" id="employee_id" value="" />
                                <div class="col-md-6 mb-3">
                                    <label for="refrence_name" class="form-label">Refrence Name</label>
                                    <input type="text" class="form-control" id="refrence_name" placeholder="Enter Refrence Name"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="refrence_phone" class="form-label">Refrence Phone</label>
                                    <input class="form-control" type="tel" value="" id="refrence_phone" placeholder="" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ni_number" class="form-label">NI Number</label>
                                    <input type="text" class="form-control" id="ni_number" placeholder="Enter NI Number"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="utr_number" class="form-label">UTR Number</label>
                                    <input type="text" class="form-control" id="utr_number" placeholder="Enter UTR Number"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="basic_info_submit">Save</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="document" role="tabpanel">
                        <form>
                            <div class="row">
                                <input type="hidden" id="doc_employee_id" value="" />


                                <h5>Passport</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="passport" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="passport" value="Passport" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="passport_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="" id="passport_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="passport_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="passport_document_file"/>
                                </div>
                                
                                
                                <h5>BRP/Visa</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="visa" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="visa" value="BRP/Visa" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="visa_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="" id="visa_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="visa_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="visa_document_file"/>
                                </div>
                                
                                
                                <h5>License</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="license" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="license" value="License" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="license_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="" id="license_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="license_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="license_document_file"/>
                                </div>


                                <h5>DBS</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="dbs" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="dbs" value="DBS" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dbs_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="" id="dbs_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dbs_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="dbs_document_file"/>
                                </div>


                                <h5>CSCS card</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="cscscard" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="cscscard" value="CSCS card" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cscscard_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="" id="cscscard_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cscscard_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="cscscard_document_file"/>
                                </div>

                                <h5>NPORS/CPCS card</h5>
                                <div class="col-md-4 mb-3">
                                    <label for="nrors_cpcs" class="form-label">Document Name</label>
                                    <input type="text" class="form-control" id="nrors_cpcs" value="NPORS/CPCS card" placeholder="Enter Document Name" readonly/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="nrors_cpcs_expiry_date" class="form-label">Expiry Date</label>
                                    <input class="form-control" type="date" value="" id="nrors_cpcs_expiry_date" placeholder="" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="nrors_cpcs_document_file" class="form-label">Document File</label>
                                    <input type="file" class="form-control" id="nrors_cpcs_document_file"/>
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
@endsection
