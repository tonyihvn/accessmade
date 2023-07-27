@extends('layouts.template')
@php
    $pagetype = 'Table';
@endphp
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Contributors / Savers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Contributors / Savers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <div class="card">

        <div class="card-body" style="overflow: auto;">
            <a href="{{ url('new-staff') }}" class="btn btn-primary" style="float: right;">Add New</a>
            <br>
            <table class="table responsive-table" id="products">
                <thead>
                    <tr>
                        <th>Package</th>

                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Credit Officer</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allclients as $cl)
                        <tr @if ($cl->status == 'Active') style="background-color: azure !important;" @endif>
                            <td>{{ $cl->category }}</td>

                            <td>{{ $cl->name }}</td>
                            <td>{{ $cl->phone_number }}</td>
                            <td>{{ $cl->address }}</td>
                            <td>{{ $cl->about }}</td>
                            <td>
                                <form action="{{ route('paycsub') }}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <input type="hidden" name="client_id" value="{{ $cl->id }}">
                                        <input type="hidden" name="saving_plan" value="{{ $cl->category }}">
                                        <input type="hidden" name="credit_officer" value="{{ $cl->about }}">

                                        <div class="row">
                                            <div class="col-md-6">
                                                @if ($cl->category == 'Save for Food')
                                                    <select name="amount" class="form-control">
                                                        <option value="200">Bronze 200</option>
                                                        <option value="300">Silver 300</option>
                                                        <option value="400">Gold 400</option>
                                                        <option value="500">Diamond 500</option>
                                                    </select>
                                                @else
                                                    <input type="number" name="amount" class="form-control"
                                                        placeholder="Amount" value="" required>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <input type="date" name="date_paid" class="form-control"
                                                    placeholder="Date" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="account_head" class="form-control">
                                                    <option value="Deposit">Deposit</option>
                                                    <option value="Withdrawal">Withdrawal</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="status" class="form-control">
                                                    <option value="Paid">Paid</option>
                                                    <option value="Not Paid">Not Paid</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary float-right">Save</button>
                                </form>
                            </td>
                            </td>
                            <td width="90">
                                <div class="btn-group">
                                    <a href="{{ url('/edit-client/' . $cl->id) }}" class="btn btn-default btn-xs">Edit</a>


                                    <a href="{{ url('/delete-client/' . $cl->id) }}" class="btn btn-danger btn-xs"
                                        onclick="if (! confirm('Are you sure you want to delete this user??')) { return false; }">Del</a>



                                </div>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
            <div class="col-md-6 col-md-offset-3">{{$allclients->links()}}</div>
        </div>
    </div>
@endsection
