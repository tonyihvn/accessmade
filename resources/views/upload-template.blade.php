@extends('layouts.template')
@php
    $pagetype = 'Table';
    $pagetitle = 'MINISTRY UPDATE ' . strtoupper(date('F Y'));
@endphp
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">MINISTRY UPDATE {{ strtoupper(date('F Y')) }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">MINISTRY UPLOAD {{ date('m yy') }} </li>
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
                            <th>S/N</th>
                            <th>MBA</th>
                            <th>NAMES</th>
                            <th>IPPIS NUMBER</th>
                            <th>CATEGORY</th>
                            <th>MONTHLY DED.</th>
                            <th>DURATION</th>
                            <th>START MONTH</th>
                            <th>END MONTH</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; @endphp
                        @foreach ($subscriptions as $sub)
                            @php
                                $monthspaid = $sub->payments->count();

                                $monthsleft = $sub->subplan->duration - $monthspaid;

                                $endmonth = date('M-Y', strtotime(+$monthsleft . ' months', strtotime(date('M-Y'))));

                            @endphp
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $sub->client->company_name }}</td>
                                <td>{{ $sub->client->name }}</td>
                                <td>{{ $sub->client->ippis_no }}</td>
                                <td>{{ $sub->client->category }}</td>
                                <td>{{ $sub->subplan->monthly_contribution }}</td>
                                <td>{{ $monthsleft }}</td>
                                <td>{{ date('M-Y', strtotime($sub->date_subscribed)) }}</td>
                                <td>{{ $endmonth }}</td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
