
@if($cosEmployee->other_data)
    @if(count($cosEmployee->other_data) > 0)
        <a class="btn btn-sm btn-primary" href="{{route('dashboard.cos_employees.index',$cosEmployee->hr_cos_employees_slug)}}?printContract" target="_blank"><i class="fa fa-print"></i> Print Contract</a>
    @else
        <small class="text-muted">Signatories not yet filled out</small>
    @endif
@else
    <small class="text-muted">Signatories not yet filled out</small>
@endif