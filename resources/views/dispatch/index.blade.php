@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('flash::message')
                <div class="panel panel-default">
                    <div class="panel-heading">Request</div>
                    <div class="panel-body">
                        <table id="users" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Sender(From)</th>
                                <th>Recipient(To)</th>
                                <th>Date Created</th>
                                <th>Date Received</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td>{{$request->title}}</td>
                                    <td>{{$request->recipient->name}}</td>
                                    <td>{{$request->user->name}}</td>
                                    <td> {{$request->created_at}}  </td>
                                    <td> {{$request->date_delivered}}  </td>
                                    <td>     @if($request->status == 1)
                                            <span class="label label-default">Queued</span>
                                        @elseif($request->status == 2)
                                            <span class="label label-warning">Dispatched</span>
                                        @elseif($request->status == 3)
                                            <span class="label label-success">Delivered</span>
                                        @endif  </td>
                                    <td>
                                        @if($request->status == 2 )
                                            <a href="{{URL::route('request.delivered',$request->id)}}" type="button"
                                               class="btn btn-warning">Confrrm Delivery</a>
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
@endsection

@section('script')

    <script type="text/javascript"
            src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#users').DataTable();
        });
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);


    </script>
    </head>
@stop