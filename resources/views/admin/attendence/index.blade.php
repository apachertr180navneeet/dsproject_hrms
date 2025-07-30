@extends('admin.layouts.app')

@section('style')
<style>
    /* Custom styles if needed */
</style>
@endsection  

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <h4 class="py-3 mb-4"><span class="">Attendance</span></h4>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="GET" action="{{ route('admin.attendence.index') }}" class="form-inline">
                <div class="input-group">
                    <select name="month" class="form-select" required>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $currentMonth == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" class="form-select" required>
                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn btn-primary">Go</button>
                </div>
            </form>
        </div>
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
                            @foreach($employees as $employee)
                                <tr>
                                    <td>
                                        <i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <span class="fw-medium">{{ $employee->full_name }}</span>
                                    </td>

                                    @for ($day = 1; $day <= $totalDays; $day++)
                                        @php
                                            $date = \Carbon\Carbon::create($currentYear, $currentMonth, $day);
                                            $dayOfWeek = $date->format('l');
                                            $key = $employee->id . '_' . $day;

                                            // Show status only if attendance record exists, otherwise blank
                                            $status = isset($attendances[$key])
                                                ? $attendances[$key][0]->status
                                                : '';

                                            $shortStatus = $status;

                                            $colorClass = match($shortStatus) {
                                                'P' => 'text-success fw-bolder',
                                                'A' => 'text-danger fw-bolder',
                                                'L' => 'text-warning fw-bolder',
                                                default => 'text-muted fw-bolder',
                                            };

                                            $tdClass = $colorClass;
                                            if ($day == \Carbon\Carbon::now()->day && $currentMonth == \Carbon\Carbon::now()->month && $currentYear == \Carbon\Carbon::now()->year) {
                                                $tdClass .= ' bg-light';
                                            }
                                        @endphp
                                        <td class="{{ $tdClass }} addatendence" style="cursor:pointer;">
                                            <input type="hidden" name="user_id" value="{{ $employee->id }}">
                                            <input type="hidden" name="date" value="{{ $date->toDateString() }}">
                                            {{ $shortStatus }}
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attendanceModalLabel">Update Attendance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="attendanceForm">
            <input type="hidden" name="user_id" id="modal_user_id">
            <input type="hidden" name="date" id="modal_date">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" id="modal_status">
                    <option value="P">Present</option>
                    <option value="A">Absent</option>
                    <option value="L">Leave</option>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="saveAttendance" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
    let selectedCell;

    $(document).on('click', '.addatendence', function () {
        selectedCell = $(this);

        const currentStatus = selectedCell.text().trim();
        const userId = selectedCell.find('input[name="user_id"]').val();
        const date = selectedCell.find('input[name="date"]').val();

        $('#modal_user_id').val(userId);
        $('#modal_date').val(date);
        $('#modal_status').val(currentStatus);

        $('#attendanceModal').modal('show');
    });

    $('#saveAttendance').on('click', function () {
        const userId = $('#modal_user_id').val();
        const date = $('#modal_date').val();
        const status = $('#modal_status').val();

        $.ajax({
            url: '{{ route("admin.attendence.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId,
                date: date,
                status: status
            },
            success: function (response) {
                if (response.success) {
                    $('#attendanceModal').modal('hide');
                    location.reload();
                } else {
                    alert('Failed to update status.');
                }
            },
            error: function () {
                alert('Something went wrong while updating attendance.');
            }
        });
    });
</script>
@endsection
