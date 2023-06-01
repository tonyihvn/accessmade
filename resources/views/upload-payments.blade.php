@extends('layouts.template')

@php
    
    if (isset($product_id)) {
        $type = 'Edit';
        $button = 'Save Changes';
        $product_id = $product_id;
    } else {
        $cid = 0;
        // $client = (object) [];
        $type = 'New';
        $button = 'Save New ';
        $product_id = '';
    }
@endphp

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Upload Processed Payments</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Upload</a></li>
                        <li class="breadcrumb-item active">Payments</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title">Upload Payment List</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('uploadPayments') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="business_id" value="{{ Auth()->user()->business_id }}">

                <div class="form-group row">

                    <div class="col-md-4">
                        <label for="files">Upload File(s)</label>
                        <input type="file" class="form-control" name="file_name" accept="csv" id="file_name">
                    </div>

                    <div class="col-md-4">
                        <label>Select Month</label>
                        <select name="month" class="form-control" id="month">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="dob">Date of Payment</label>
                        <div class="input-group date" id="dob_date_activator" data-target-input="nearest">
                            <input type="text" name="date_paid" class="form-control datetimepicker-input"
                                data-target="#dob_date_activator">
                            <div class="input-group-append" data-target="#dob_date_activator" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-primary float-right"
                            onclick="return confirm('Please re-cconfirm the month of payment, is it correct?'+document.getElementById('month').text)">Upload</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
