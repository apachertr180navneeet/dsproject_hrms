@extends('admin.layouts.app')
@section('style')
    <style>
        
    </style>
@endsection  
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <h4 class="py-3 mb-4">
                <span class="">Attendence </span>
            </h4>
        </div>
        {{--  <div class="col-md-6 text-end">
            <a href="{{route('admin.employee.add')}}" class="btn rounded-pill btn-outline-primary">Add +</a>
        </div>  --}}
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <h5 class="card-header">
                    {{ $currentMonthName }} {{ $currentYear }} Attendance Sheet ({{ $totalDays }} Days)
                </h5>            
                <div class="table-responsive text-nowrap">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>Employee</th>
                        @for ($day = 1; $day <= $totalDays; $day++)
                            <th>{{ $day }}</th>
                        @endfor
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <span class="fw-medium">Angular Project</span></td>
                        @for ($day = 1; $day <= $totalDays; $day++)
                            <td>P</td> {{-- You can dynamically show P/A/L etc. here --}}
                        @endfor
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function deletes(userid){
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this contacts!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if(result.isConfirmed == true) {
                    var url = '{{ route("admin.employee.destroy", ":userid") }}';
                    url = url.replace(':userid', userid);
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {'_token': "{{ csrf_token() }}"},
                        success: function(response) {
                            if(response.success){
                                setFlesh('success','Employee Deleted Successfully');
                                $('#dataTable').DataTable().ajax.reload();
                            }else{
                                setFlesh('error','There is some problem to delete feedback!Please try again');
                            }
                        }
                    });
                }
            })
        }
    </script>
@endsection
