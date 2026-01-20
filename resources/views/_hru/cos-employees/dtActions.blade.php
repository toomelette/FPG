<div class="btn-group btn-group-sm">
    <button type="button" data="{{$cosEmployee->hr_cos_employees_slug}}" data-bs-toggle="modal" data-bs-target="#edit-cos-employee-modal" class="btn btn-sm btn-outline-secondary edit-cos-employee-btn">
        <i class="fa fa-edit"></i>
    </button>
    <a href="{{route('dashboard.employee.index_cos')}}?find={{$cosEmployee?->employee?->employee_no}}" target="_blank" type="button" data="{{$cosEmployee->hr_cos_employees_slug}}" class="btn btn-sm btn-outline-secondary edit-cos-employee-btn">
        <i class="fa fa-user"></i>
    </a>
    <button type="button" data="{{$cosEmployee->hr_cos_employees_slug}}" onclick="delete_data('{{$cosEmployee->hr_cos_employees_slug}}','{{route('dashboard.cos_employees.destroy','slug')}}')" class="btn btn-sm btn-danger delete_jo_employee_btn">
        <i class="fa fa-trash"></i>
    </button>
</div>