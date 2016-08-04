<?php

namespace App\Http\Controllers;

use App\Requester;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $dispatch = User::whereRole(2)->get();
        $requests = Requester::all();
        return view('admin.index')->withDispatch($dispatch)->withRequests($requests);
    }

    public function store(Request $request)
    {
        $requests = new Requester;
        $requests->title = $request->get('title');
        $requests->details = $request->get('details');
        $requests->recipient_id = $request->get('recipient');
        $requests->requester_id = Auth::user()->id;
        $requests->status = 1;
        $requests->save();
        return redirect()->back();
    }

    public function process(Request $request)
    {
        $requests = Requester::find($request->get('requestid'));
        $requests->sender_id = $request->get('sender');
        $requests->status = 2;
        $requests->save();
        flash('Request processed', 'success');
        return redirect()->back();
    }

    public function sender()
    {

        $requests = Requester::whereSender_id(Auth::user()->id)->get();
        return view('dispatch.index')->withRequests($requests);
    }

    public function show($id)
    {
        $requests = Requester::find($id);
        return view('request.show')->withData($requests);
    }

    public function update(Request $request, $id)
    {


        $requests = Requester::find($id);
        $requests->details = $request->get('details');
        $requests->title = $request->get('title');
        $requests->save();
        return redirect('/');
    }

    public function destroy($id)
    {

        $requests = Requester::find($id);
        $requests->delete();
        return redirect()->back();
    }

    public function delivered($id)
    {
        $requests = Requester::find($id);
        $requests->status = 3;
        $requests->date_delivered = date("Y-m-d H:i:s");
        $requests->save();
        flash('Request delivered', 'success');
        return redirect()->back();
    }
}
