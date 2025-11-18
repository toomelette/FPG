<div class="form-check form-switch text-center" >
    <label class="text-center">
        <input data="{{$cosEmployee->hr_cos_employees_slug}}" @if($cosEmployee->status == 'APPROVED')checked="checked"@endif class="form-check-input allow-print" type="checkbox" name="is_checked" style="width: 40px; height: 18px"/>
    </label>
</div>