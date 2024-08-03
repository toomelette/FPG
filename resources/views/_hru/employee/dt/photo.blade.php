
@if($data->photo != null)
        @if(File::exists(public_path('symlink/employee_pics/uploaded_300/'.$data->photo)))
                <center>
                        <img class="gj-imagebox" src='/symlink/employee_pics/uploaded_300/{{$data->photo}}' original="/symlink/employee_pics/uploaded/{{$data->photo}}"  style="object-fit: cover;" width="100" height="100" alt="User Image">
                </center>
        @endif
@endif