@extends('layouts.template')
@php
    $pagetype = 'Table';

    if (stripos($_SERVER['REQUEST_URI'], 'client') !== false) {
        $cli = 'for ' . $subscriptions[0]->client->name;
    } else {
        $cli = '';
    }

@endphp
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product Subscriptions {{ $cli ?? '' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Product Subscriptions</li>
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
                            <th>Product</th>
                            <th>Date Subscribed</th>
                            <th>Subscription-Plan</th>
                            <th>Payments-Made</th>
                            <th>Penalty</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $sub)
                            <tr @if ($sub->status == 'Completed') style="background-color: azure !important;" @endif>
                                <td>{{ $sub->client->name }}</td>
                                <td>{{ $sub->product->title ?? 'Top Up' }}</td>
                                <td>{{ $sub->date_subscribed }}</td>
                                <td>{{ $sub->subplan->title }}</td>
                                <td>{{ $sub->payments->count() }} times (Total: {{ $sub->payments->sum('amount_paid') }} )
                                    @if ($sub->subplan->duration <= $sub->payments->count())
                                        <div class="badge badge-success">Completed</div>
                                    @else
                                        <div class="badge badge-warning">Not Completed</div>
                                    @endif
                                </td>
                                <td>{{ $sub->penalties }}</td>
                                <td style="width:20% !important">
                                    <form action="{{ route('paysub') }}" method="post">
                                        @csrf
                                        <div class="form-group row">
                                            <input type="hidden" name="subscription_id" value="{{ $sub->id }}">
                                            <input type="hidden" name="product_id" value="{{ $sub->product_id }}">
                                            <input type="hidden" name="client_id" value="{{ $sub->client_id }}">

                                            <input type="number" name="amount" class="form-control col-md-6"
                                                style="height: 25px !important;" placeholder="Amount"
                                                value="{{ ceil($sub->subplan->monthly_contribution) }}" required><br>
                                            <input type="date" name="date_paid" class="form-control col-md-6"
                                                style="height: 25px !important;" placeholder="Date" required>
                                        </div>
                                        <button class="btn btn-sm btn-primary float-right">Pay</button>
                                    </form>

                                    <a href="{{ url('/delete-subs/' . $sub->id) }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete {{ $sub->subplan->title }}\'s Subscription Plan?')">Delete</a>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
