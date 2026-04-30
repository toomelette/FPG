@php
    $groupedByClients = $data->projects->groupBy(function ($project){
        return $project?->salesInvoice?->client?->name;
    });
@endphp
<table class="table table-sm small">
    @forelse($groupedByClients as $clientName => $projects)
        <tr>
            <th colspan="2">{{$clientName}}:</th>
        </tr>
        @forelse($projects as $project)
            <tr>
                <td>{{$project?->salesInvoice?->remarks}}</td>
                <td class="text-end">{{Helper::toNumber($project->amount)}}</td>
            </tr>
        @empty

        @endforelse
    @empty
    @endforelse
</table>
