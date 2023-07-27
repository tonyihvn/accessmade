@if (auth()->user()->role == 'Super' || auth()->user()->role == 'Admin')
    @php $layout = 'layouts.template' @endphp
@else
    @php $layout = 'layouts.member-template' @endphp
@endif
@extends($layout)
@php

    if (isset($client->id)) {
        $type = 'Edit';
        $password_action = 'Change';
        $button = 'Save Changes';
        $status = $client->status;
    } else {
        $cid = 0;
        // $client = (object) [];

        $type = 'New';
        $password_action = '';
        $button = 'Save New ' . $object;
        $status = '';
    }
@endphp
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $type }} {{ $object }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('clients') }}">{{ $object }}</a></li>
                        <li class="breadcrumb-item active">{{ $type }} {{ $object }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title">{{ $type }} {{ $object }} Form</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('saveClient') }}" method="post">
                @csrf
                <input type="hidden" name="cid" value="{{ isset($client->id) ? $client->id : 0 }}">
                <input type="hidden" name="object" value="{{ $object }}">
                <input type="hidden" name="oldpassword" value="{{ isset($client->password) ? $client->password : '' }}">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Enter a Full Name" value="{{ isset($client->name) ? $client->name : '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="company_name">Employer / Organization</label>
                        <input type="text" class="form-control" name="company_name" id="company_name"
                            placeholder="Organization"
                            value="{{ isset($client->company_name) ? $client->company_name : '' }}">
                    </div>
                </div>
                @if ($object == 'Client')
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="service_no">Service Number</label>
                            <input type="text" class="form-control" name="service_no" id="service_no"
                                placeholder="Service Number"
                                value="{{ isset($client->service_no) ? $client->service_no : '' }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="ippis_no">IPPIS NO:</label>
                            <input type="text" class="form-control" name="ippis_no" id="ippis_no"
                                placeholder="IPPIS Number" value="{{ isset($client->ippis_no) ? $client->ippis_no : '' }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="grade_level">Salary Grade Level</label>
                            <select name="grade_level" id="grade_level" class="form-control">
                                <option value="{{ isset($client->grade_level) ? $client->grade_level : '' }}" selected>
                                    {{ isset($client->grade_level) ? $client->grade_level : 'Select' }}</option>

                                @for ($i = 0; $i <= 17; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor

                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="step">Step:</label>
                            <input type="text" class="form-control" name="step" id="step" placeholder="Step"
                                value="{{ isset($client->step) ? $client->step : '' }}">
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="salary_account">Salary Acc. No:</label>
                            <input type="text" class="form-control" name="salary_account" id="salary_account"
                                placeholder="Salary Account"
                                value="{{ isset($client->salary_account) ? $client->salary_account : '' }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="bank">Bank Name:</label>
                            <input list="banklist" name="bank" id="bank" class="form-control"
                                placeholder="Bank Name">
                            <datalist id="banklist">
                                <option value="Access Bank Plc">
                                <option value="Citibank Nigeria Limited">
                                <option value="Ecobank Nigeria Plc">
                                <option value="First City Monument Bank Plc">
                                <option value="Globus Bank Limited">
                                <option value="Guaranty Trust Bank Plc">
                                <option value="Heritage Banking Company Ltd.">
                                <option value="Keystone Bank Limited">
                                <option value="Parallex Bank Ltd">
                                <option value="Polaris Bank Plc">
                                <option value="Premium Trust Bank">
                                <option value="Providus Bank">
                                <option value="Stanbic IBTC Bank Plc">
                                <option value="Standard Chartered Bank Nigeria Ltd.">
                                <option value="Sterling Bank Plc">
                                <option value="SunTrust Bank Nigeria Limited">
                                <option value="Titan Trust Bank Ltd">
                                <option value="Union Bank of Nigeria Plc">
                                <option value="United Bank For Africa Plc">
                                <option value="Unity  Bank Plc">
                                <option value="Wema Bank Plc">
                                <option value="Zenith Bank Plc">
                            </datalist>


                        </div>
                        <div class="form-group col-md-3">
                            <label for="kin_name">Next of Kin Name</label>
                            <input type="text" class="form-control" name="kin_name" id="kin_name"
                                placeholder="Next of Kin Name"
                                value="{{ isset($client->kin_name) ? $client->kin_name : '' }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="kin_address">Next of Kin Address:</label>
                            <input type="text" class="form-control" name="kin_address" id="kin_address"
                                placeholder="Nxt of Kin Address"
                                value="{{ isset($client->kin_address) ? $client->kin_address : '' }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="rank">Rank</label>
                            <input type="text" class="form-control" name="rank" id="rank" placeholder="Rank"
                                value="{{ isset($client->rank) ? $client->rank : '' }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="service_length">Length of Service:</label>
                            <input type="text" class="form-control" name="service_length" id="service_length"
                                placeholder="Service Length"
                                value="{{ isset($client->service_length) ? $client->service_length : '' }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="retirement_date">Retirement Date</label>
                            <div class="input-group date" id="start_date_activator" data-target-input="nearest">
                                <input type="text" name="retirement_date" class="form-control datetimepicker-input"
                                    data-target="#start_date_activator"
                                    value="{{ isset($client->retirement_date) ?? '' }}">
                                <div class="input-group-append" data-target="#start_date_activator"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lga">LGA</label>
                            <input type="text" class="form-control" name="lga" id="lga"
                                placeholder="Local Govt. Area" value="{{ isset($client->lga) ? $client->lga : '' }}">
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="form-group col-md-9">
                        <label for="about"> {{ $object == 'Contributors' ? 'Credit Officer Name' : 'About' }}
                            {{ $object }} </label>
                        <input type="text" class="form-control" name="about" id="about"
                            aria-describedby="about_client" placeholder="About"
                            value="{{ isset($client->about) ? $client->about : '' }}">
                        <small id="about_client" class="form-text text-muted">Please, write a brief information about the
                            {{ $object }}</small>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="dob">Date of Birth</label>
                        <div class="input-group date" id="dob_date_activator" data-target-input="nearest">
                            <input type="text" name="dob" class="form-control datetimepicker-input"
                                data-target="#dob_date_activator" value="{{ isset($client->dob) ?? '' }}">
                            <div class="input-group-append" data-target="#dob_date_activator"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="address">Home Address </label>
                        <input type="text" class="form-control" name="address" id="address"
                            placeholder="Home Address" value="{{ isset($client->address) ? $client->address : '' }}">

                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number"
                            placeholder="Phone Number"
                            value="{{ isset($client->phone_number) ? $client->phone_number : '' }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Email Address" value="{{ isset($client->email) ? $client->email : '' }}"
                            {{ isset($client->role) && $client->role == 'Client' ? 'readonly' : '' }}>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="password">{{ $password_action }} Password</label>
                        <input type="text" class="form-control" name="password" id="password"
                            placeholder="{{ $type }} Password for the  {{ $object }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="account_manager">Account Manager/Officer</label>
                        <input type="text" class="form-control" name="account_manager" id="account_manager"
                            placeholder="Name of Account Officer"
                            value="{{ isset($client->account_manager) ? $client->account_manager : '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="state">State</label>
                        <select name="state" id="state" class="form-control">
                            <option value="{{ isset($client->state) ? $client->state : '' }}" selected>
                                {{ isset($client->state) ? $client->state : 'Select state' }}</option>

                                <option value="FCT">FCT</option>
                                <option value="Plataeu">Plataeu State</option>
                                <option value="Nasarawa">Nasarawa State</option>
                                <option value="Benue">Benue State</option>
                        </select>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="{{ isset($client->category) ? $client->category : '' }}" selected>
                                {{ isset($client->category) ? $client->category : 'Select Category' }}</option>

                            @foreach ($categories as $cats)
                                <option value="{{ $cats->title }}">
                                    {{ $cats->title }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="{{ isset($client->status) ? $client->status : '' }}" selected>
                                {{ isset($client->status) ? $client->status : 'Select Status' }}</option>

                            @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Super')
                                <option value="Active">Active</option>
                                <option value="Suspended">Suspended</option>
                                <option value="Terminated">Terminated</option>
                                <option value="Awaiting Approval">Awaiting Approval</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="role">System Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="{{ isset($client->role) ? $client->role : '' }}" selected>
                                {{ isset($client->role) ? $client->role : 'Select Role' }}</option>

                            @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Super')
                                <option value="Client">Client User</option>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                                <option value="Contributor">Contributor</option>
                            @endif

                            @if (auth()->user()->role == 'Super')
                                <option value="Super">Super</option>
                            @endif


                        </select>
                    </div>
                </div>
                @if ($object == 'Client')
                    <div style="font-size: 0.7em">

                        <b>Terms and Conditions:</b>
                        <hr>
                        <p><b>Terms and Conditions</b><br>
                            1. This document shall be interpreted as the governing document of the transaction where in all
                            the
                            fundamental terms binding both parties are contained and referenced to this form shall be
                            reference
                            to the contractual agreement upon which said transaction is formed. <br>
                            2. Items requested for, shall be picked up at designated places and date upon the commencement
                            of
                            deduction of the cost of the item requested. items delivered on the agreed time and not
                            collected by
                            the customer shall attract additional transport cos t of N5,000 only.<br>
                            3. Where the company fails to supply the requested item after the number of deduction agreed by
                            the
                            customer either by reason of availability of the product, delay in shipping, clearing or
                            otherwise;
                            the customer will be duly noticed on the state of the item.<br>
                            4. Where the circumstance in 3(above) occur, the customer is at liberty to enter fresh
                            negotiation
                            for a further extension of time.<br>
                            5. All item will supply upon completion at current market prevailing price (inflation)<br>
                            6. Item requested for when tested certified to be in good working condition shall no longer be
                            accepted once same is delivered to the customer, through the company may at its discretion
                            consider
                            genuine complaints from customers and proffer any remedy it might deem expedient<br>
                            7. No cancelation of transaction when deduction has commenced. The company may allow
                            cancellation in
                            some special circumstances provided that; the applicant will forfeit 30% of the total deduction
                            made.<br>
                            8. Cancellation of transaction by applicant after 5(five) working days of registration attracts
                            a
                            contingency/administrative fee of N7,000 only<br>

                            I hereby declare that I fully understand the legal consequences, economic and commercial
                            obligation
                            incurred by virtue of my subscription to the scheme as offered by Accessmade Limited and
                            therefore
                            authorize Accesmade Limited to effect a monthly deduction of the amount against my name from my
                            monthly salary for the purpose of defraying the cost of the asset I am obtaining through
                            Accessmade
                            Limited. I sincerely and expressly agree to be bound by the terms and condition herein contained
                            and
                            declared that I shall abide by said terms and agree to be held accountable wherever I am in
                            default.
                            The authority shall Subsist for the period as indicated and cannot be revoked, cancelled or set
                            aside until the entire sum is fully defrayed. Service Charges Applied. <br>
                        </p>
                        <input type="checkbox" name="Agree" id="Agree" required> I Agree
                    </div>
                @endif

                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary  float-right">{{ $button }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
