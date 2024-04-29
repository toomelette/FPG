
@if($data->photo != null)
        @if(File::exists(public_path('symlink/employee_pics/uploaded/'.$data->photo)))
                <center>
                        <img class='' src='/symlink/employee_pics/uploaded/{{$data->photo}}'  style="object-fit: cover;" width="100" height="100" alt="User Image">
                </center>
        @endif
@endif