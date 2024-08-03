<div class="accordion {{$class}}">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button {{$state == 0 ?'collapsed' : ''}}" type="button" data-bs-toggle="collapse" data-bs-target="#{{$id}}" aria-expanded="{{$state == 0 ?'false' : 'true'}}" aria-controls="{{$id}}">
                {{$title}}
            </button>
        </h2>
        <div id="{{$id}}" class="accordion-collapse {{$state == 0 ?'collapse' : 'collapse show'}}" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                {{$slot}}
            </div>
        </div>
    </div>
</div>