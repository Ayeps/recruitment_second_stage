@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit User</div>

                    <div class="panel-body">
                        {!!  Form::model($data,['method'=>'PATCH','route'=>['request.update',$data->id],'id'=>'commentForm', 'class' => 'form-horizontal'])!!}
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

                                {!! Form::text('title', null, ['class' => 'form-control','placeholder'=>"title","required"=>"required"]) !!}


                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('details') ? ' has-error' : '' }}">
                            <label for="details" class="col-md-3 control-label">Details</label>
                            <div class="col-md-7">
                                {!! Form::textarea('details', null, ['class' => 'form-control','type'=>'text','placeholder'=>"details","required"=>"required"]) !!}

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
                                    <i class="fa fa-btn fa-user"></i> Edit
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
