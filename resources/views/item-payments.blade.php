@if (auth()->user()->role == 'Super' || auth()->user()->role == 'Admin')
    @php $layout = 'layouts.template' @endphp
@else
    @php $layout = 'layouts.member-template' @endphp
@endif
@extends($layout)
@php
    $pagetype = 'Table';
    
@endphp
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Payments for {{ $item }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Payments</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="row">
        <div class="card">

            <div class="card-body">
                <table class="table  responsive-table" id="products" style="font-size: 0.9em !important;">
                    <thead>
                        <tr style="color: ">
                            <th>Client</th>
                            <th>Month</th>
                            <th>Subscription-Plan</th>
                            <th>Amount</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $sub)
                            <tr>
                                <td>{{ $sub->client->name }}</td>
                                <td>{{ date('F', mktime(0, 0, 0, $sub->month, 10)) }}</td>
                                <td>{{ $sub->subscription->subplan->title }}</td>
                                <td>{{ $sub->amount_paid }}</td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
