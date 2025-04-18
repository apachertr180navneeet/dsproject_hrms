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
                <span class="">Employee </span>
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{route('admin.employee.add')}}" class="btn rounded-pill btn-outline-primary">Add +</a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $('#dataTable').DataTable({
            processing: true,
            ajax: {
            url: "{{route('admin.employee.getall')}}",
            },
            order: [],
            columns: [

                {
                    data: "name",
                    render: (data,type,row) => {
                        return row.name;
                    }
                },
                {
                    data: "email",
                    render: (data,type,row) => {
                        return '<a href="mailto:'+row.email+'">'+row.email+'</a>';
                    }
                },
        
                {
                    data: "phone",
                    render: (data,type,row) => {
                        return row.message;
                    }
                },
                {
                    data: "action",
                    render: (data,type,row) => {
                            return '<button type="button" class="btn btn-sm btn-danger" onclick="deletes('+row.id+')">Delete</button>';
                    }
                }
                
            ],
        });
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
