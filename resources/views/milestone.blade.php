@extends('layouts.template')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Project Milestone</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Project</li>
                        <li class="breadcrumb-item active">Milestone</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="card card-widget">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-header" style="padding: 10px;">
            <h1>{{ $milestone->title }}</h1>
            <h3>{{ $milestone->project->title }}, <small><i>Client</i>: {{ $milestone->project->client->name }}</small></h3>
            Status: <span class="badge badge-pill badge-primary">{{ $milestone->status }}</span>
            <hr>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {!! $milestone->details !!}
                </div>
                <div class="col-md-6">


                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fa fa-briefcase"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Tasks: {{ $milestone->tasks->count() }}</span>
                            <span class="info-box-number">Completed Task:
                                {{ $milestone->tasks->where('status', 'Completed')->count() }}</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                                <b>Expected Duration:</b> {{ $milestone->start_date }} - {{ $milestone->end_date }}
                                <hr>
                                <b>Staff-in-Charge:</b> {{ $milestone->assignedTo->name }}

                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>


                    <div class="list-group">

                        <a href="{{ url('milestone-task/' . $milestone->id) }}"
                            class="list-group-item list-group-item-action active">Tasks / ToDo <span class="btn btn-default"
                                style="float: right;">Add New</span></a>

                        @foreach ($milestone->tasks as $mt)
                            <div class="list-group-item list-group-item-action"><a
                                    href="{{ url('task/' . $mt->id) }}">{{ $mt->subject }}</a> <span
                                    class="badge badge-pill badge-primary">{{ $mt->status }}</span>
                                <div class="btn-group" style="float: right;">
                                    <a href="{{ url('task/' . $mt->id) }}" class="btn btn-xs btn-primary">View</a>
                                    <a href="{{ url('del-task/' . $mt->id) }}" class="btn btn-xs btn-danger">Delete</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
