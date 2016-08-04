@extends('layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Outbox
                        <a type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal"
                           style="float: right">New Reuest</a>
                    </div>

                    <div class="panel-body">
                        <table id="users" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Recipient</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td>{{$request->title}}</td>
                                    <td>{{$request->recipient->name}}</td>
                                    <td> {{$request->created_at}}  </td>
                                    <td>
                                        @if($request->status == 1)
                                            <span class="label label-default">Queued</span>
                                        @elseif($request->status == 2)
                                            <span class="label label-warning">Dispatched</span>
                                        @elseif($request->status == 3)
                                            <span class="label label-success">Delivered</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{URL::route('request.show',$request->id)}}" type="button"
                                           class="btn btn-warning">Deatials</a>
                                        <a href="{{URL::route('request.destroy',$request->id)}}" type="button" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Received

                    </div>

                    <div class="panel-body">
                        <table id="received" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Sender(From)</th>
                                <th>Date Sent</th>
                                <th>Date Received</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($received as $request)
                                <tr>
                                    <td>{{$request->title}}</td>
                                    <td>{{$request->user->name}}</td>
                                    <td> {{$request->created_at}}  </td>
                                    <td>
                                        {{$request->date_delivered}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Rquest</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{URL::route('request.store')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">Sender Name</label>

                            <div class="col-md-7">
                                <label for="name" class="col-md-8 control-label">{{Auth::user()->name}}</label>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">Subject/Title</label>

                            <div class="col-md-7">

                                <input id="title" type="text" class="form-control" name="title"
                                       value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('recipient') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">Recipient</label>

                            <div class="col-md-7">

                                <select class="form-control" id="recipient" name="recipient">
                                    <option value="1">Select Recipient</option>
                                    @foreach($users as $user)
                                        {
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        }
                                    @endforeach
                                </select>

                                @if ($errors->has('recipient'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('recipient') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('details') ? ' has-error' : '' }}">
                            <label for="details" class="col-md-3 control-label">Details</label>
                            <div class="col-md-7">
                                <textarea id="details" type="text" class="form-control" name="details"></textarea>
                                @if ($errors->has('details'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('details') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Send Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('script')

    <script type="text/javascript"
            src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#users').DataTable();
            $('#received').DataTable();
        });
    </script>
    </head>
@stop

