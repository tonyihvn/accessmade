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
                    <h1 class="m-0">My Subscriptions</h1>
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
                <form method="post" action="{{ route('topUp') }}">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $subscriptions[0]->client->id ?? '' }}">
                    <table class="table  responsive-table" id="products" style="font-size: 0.9em !important;">
                        <thead>
                            <tr style="color: ">
                                <th style="width: 2% !important;">Select</th>
                                <th>Client</th>
                                <th>Product</th>
                                <th>Date Subscribed</th>
                                <th>Subscription-Plan</th>
                                <th>Payments-Made</th>
                                <th>Balance</th>
                                <th>My Payments</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $sub)
                                <tr @if ($sub->status == 'Completed') style="background-color: azure !important;" @endif>
                                    <td><input type="checkbox" name="topup[]" value="{{ $sub->id }}" class="topup">
                                    </td>
                                    <td>{{ $sub->client->name }}</td>
                                    <td>{{ $sub->product->title ?? 'Merged' }}</td>
                                    <td>{{ $sub->date_subscribed }}</td>
                                    <td><small>{{ $sub->subplan->title }}</small></td>
                                    <td>{{ $sub->payments->count() }} times (Total Paid:
                                        {{ $sub->payments->sum('amount_paid') }}
                                        )
                                        @if ($sub->subplan->duration <= $sub->payments->count())
                                            <div class="badge badge-success">Completed</div>
                                        @else
                                            <div class="badge badge-warning">Not Completed</div>
                                        @endif
                                    </td>
                                    <td>{{ $sub->subplan->price - $sub->payments->sum('amount_paid') }}</td>
                                    <td>
                                        @if ($sub->status == 'Merged')
                                            Merged
                                        @else
                                            <a href="{{ url('/item-payments/' . $sub->id) }}"
                                                class="btn btn-info btn-xs">My-Payments</a>
                                        @endif
                                        @if (auth()->user()->role == 'Super')

                                            <a href="{{ url('/delete-subs/' . $sub->id) }}"
                                                class="btn btn-danger btn-xs">Delete</a>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <br>
                    <div class="row" id="merged">
                        <div class="form-group col-md-3">
                            <label for="dob">New Subscription Date</label>
                            <div class="input-group date" id="dob_date_activator" data-target-input="nearest">
                                <input type="text" name="date_subscribed" class="form-control datetimepicker-input"
                                    data-target="#dob_date_activator">
                                <div class="input-group-append" data-target="#dob_date_activator"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Status:</label>
                            <select name="status" class="form-control">
                                <option value="Open">Running</option>
                                <option value="New">New</option>
                                <option value="Defaulted">Defaulted</option>
                                <option value="Completed">Completed</option>
                                <option value="Paused">Paused</option>
                                <option value="Terminated">Terminated</option>
                                <option value="Stoppage">Stoppage</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">

                            <button type="submit" class="btn btn-primary float-right"
                                onclick="return confirm('Please verify the items you are merging. Is it ok?')">Merge/TopUp
                                Selected</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
