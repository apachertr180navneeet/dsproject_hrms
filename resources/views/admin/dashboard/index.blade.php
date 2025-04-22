@extends('admin.layouts.app')
@section('style')
@endsection  

@section('content')

<!-- Content -->

<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card" style="height: 100%;">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Welcome! {{ Auth::user()->full_name }}
                                🎉</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-medium d-block mb-1">Employee</span>
                            <h5 class="card-title mb-2">{{ $employee }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-medium d-block mb-1">Attendance </span>
                            <h5 class="card-title mb-2">{{ $attendancecount }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-2 mb-2">
            <div class="card">
                <h5 class="card-header">Employee Document Expiry</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Document Name</th>
                                <th>Employee Name</th>
                                <th>Employee Mobile</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($documents as $key => $document)
                            @php
                                $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($document->expiring_date), false);
                            @endphp
                                <tr>
                                    <td>{{ $document->document_name }}</td>
                                    <td>{{ $document->user->full_name }}</td>
                                    <td>{{ $document->user->phone }}</td>
                                    <td>{{ $document->expiring_date }}</td>
                                    <td>
                                        @if($daysLeft >= 0)
                                            <span class="badge bg-label-warning me-1">Expiring in {{ $daysLeft }} day{{ $daysLeft != 1 ? 's' : '' }}</span>
                                        @else
                                            <span class="badge bg-label-danger me-1">Expired {{ abs($daysLeft) }} day{{ abs($daysLeft) != 1 ? 's' : '' }} ago</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</div>
<!-- / Content -->

                   
@endsection

@section('script')
@endsection