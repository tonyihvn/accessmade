@extends('layouts.template')
@php
    $pagetype = 'Table';
@endphp
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Communication</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Send Messages</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <div class="card">

        <div class="col-md-6 col-md-offset-3">
            <div class="card">

                @isset($message)
                    <div class="alert alert-dismissable alert-info">Your message was sent successfully!</div>
                @endisset

                <div style="text-align: right !important"><span class="label label-danger">Credit Balance:
                        <b>{{ $creditbalance * 100 }} </b> </span></div>

                <form method="POST" action="{{ route('sendsms') }}">
                    @csrf
                    <div class="form-group">
                        <label for="recipients">Recipients</label>
                        <input type="text" name="recipients" id="recipients" class="form-control"
                            placeholder="e.g. 234803333333,2349000000,...">
                    </div>

                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea type="text" name="body" id="body" class="form-control" rows="4" maxlength="500"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send SMS') }}
                        </button>
                    </div>




                </form>
            </div>
        </div>


        <div class="card-body" style="overflow: auto;">

            <table class="table responsive-table" id="products">
                <thead>
                    <tr>
                        <th width="20"> Select All <input type="checkbox" id="all" onclick="addnumber('all')"
                                data-allnumbers="{{ $allnumbers }}"></th>
                        <th>Organization</th>
                        <th>Category/Group</th>
                        <th>Contact Person</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allclients as $cl)
                        @php
                            $number = $cl->phone_number;
                            if (substr($number, 0, 1) == '0') {
                                $number = '234' . ltrim($number, '0');
                            }
                        @endphp
                        <tr @if ($cl->status == 'Active') style="background-color: azure !important;" @endif>
                            <td>
                                @isset($cl->phone_number)
                                    <input type="checkbox" id="{{ $number }}" onclick="addnumber({{ $number }})"
                                        class="checkboxes">
                                @endisset
                            </td>
                            <td>{{ $cl->company_name }}</td>
                            <td>{{ $cl->category }}/{{ $cl->role }}</td>
                            <td>{{ $cl->name }}</td>
                            <td>{{ $cl->phone_number }}</td>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
@endsection
