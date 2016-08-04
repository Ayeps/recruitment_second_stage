@extends('layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('flash::message')
                <div class="panel panel-default">
                    <div class="panel-heading">Requests
                    </div>

                    <div class="panel-body">
                        <table id="users" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Sender(From)</th>
                                <th>Recipient(To)</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td>{{$request->title}}</td>
                                    <td>{{$request->user->name}}</td>
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
                                        @if($request->status == 1)
                                            <button type="button" id="process" data-process="{{$request->id}}"
                                                    class="btn btn-default">Process
                                            </button>
                                        @endif
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
                    <h4 class="modal-title">Assign Sender</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{URL::route('request.process')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('sender') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">Senders</label>

                            <div class="col-md-7">

                                <select class="form-control" id="sender" name="sender">
                                    <option value="1">Select Sender</option>
                                    @foreach($dispatch as $user)
                                        {
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        }
                                    @endforeach
                                </select>

                                @if ($errors->has('sender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <input type="hidden" value="" name="requestid" id="requestid">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Assign
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
        });
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

        $("#process").click(function () {
            var requestid = $(this).data('process');
            $('#requestid').val(requestid);
            $('#myModal').modal({show: true});


        });

    </script>
    </head>
@stop

