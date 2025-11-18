<div class="form-check form-switch text-center" >
    <label class="text-center">
        <input data="{{$data->slug}}" @if($data->is_active)checked="checked"@endif class="form-check-input is-active-btn" type="checkbox" name="is_active" style="width: 40px; height: 18px"/>
    </label>
</div>