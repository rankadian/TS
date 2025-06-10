@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
    <div class="card-header">
        
    </div>
    <div class="card-body">
        <div class="p-4 rounded shadow-sm" style="background: #e6f7ff; border-left: 5px solid #1890ff;">
            <h4 class="mb-3" style="font-weight: bold; color: #0050b3;">
                <i class="fas fa-graduation-cap"></i> Welcome, {{ auth()->user()->name }}!
            </h4>
            <p>
                This platform is dedicated to the alumni tracer study. A tracer study is a survey conducted by the university to track the activities and career development of its graduates after completing their studies.
            </p>
            <p>
                Through this study, we aim to gather information about your current job, the relevance of your education to your profession, and any suggestions you may have to improve the academic programs.
            </p>
            <p>
                We kindly ask you to participate by completing the tracer study questionnaire. Your input is highly valuable and will contribute significantly to the improvement of education quality and institutional development.
            </p>
            <hr>
            <p class="mb-0">
                <i class="fas fa-arrow-right"></i> Please proceed to the <strong>Survey Response</strong> section to start.
            </p>
        </div>
    </div>
</div>

@endsection

    @push('css')
    @endpush

    @push('js')
        
    @endpush