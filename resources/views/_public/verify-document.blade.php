@extends('adminkit.public-master')

@section('content2')
    <div class="row vh-50">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                @if(!empty($document))
                    <div class="text-center">
                        <h1 class="display-1 fw-bold text-success">
                            <i class="fa fa-check-circle"></i>
                        </h1>
                        <p class="h2">This document is verified to exist in the database of the records section.</p>
                        <p class="lead fw-normal no-margin">Document ID: {{$document->document_id}}</p>
                        <p class="lead fw-normal no-margin">Document Date: {{$document->date}}</p>
                    </div>
                @else
                    <div class="text-center">
                        <h1 class="display-1 fw-bold text-danger">
                            <i class="fa fa-warning"></i>
                        </h1>
                        <p class="h2">The document does not exist in the database.</p>
                        <p class="lead fw-normal no-margin">Please contact the SRA (Sugar Regulatory Administration) Records Section <br>for further verification of the document.</p>
                        <p class="lead fw-normal no-margin mt-2">Document code: <b>{{request('document')}}</b></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection