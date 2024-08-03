<ul style="padding-left: 20px">
    @forelse($data->dates as $date)
        <li>{{\App\Swep\Helpers\Helper::dateFormat($date->date,'M. d, Y - D')}}</li>
    @empty
    @endforelse
</ul>