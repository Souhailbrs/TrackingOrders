<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\UserJoinRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JoinRequests extends Controller
{
    /* ##  States
     *  # 0 => First Time
     *  # 2 => Call Again
     *  # 3 => ignore
     *  # 1 => create account & accepted
     *  # 4 => Pending Accept
     * */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function searchRequests(Request $request,$state)
    {
        $search = $request->search;
        $records = UserJoinRequest::Where('id', 'like', '%' . $search . '%')->where('state', 0)
            ->orWhere('name', 'like', '%' . $search . '%')->where('state', 0)
            ->orWhere('email', 'like', '%' . $search . '%')->where('state', 0)
            ->get();

        return view('admin.joinRequests.avilable', compact('records','search'));
    }
    public function getRequests($type)
    {
        if ($type == 'avilable') {
            $state = 0;
        } elseif ($type == 'penddingAccept') {
            $state = 4;
        } else {
            $state = -1;
        }
        if ($state == -1) {
            $records = UserJoinRequest::whereNotIn('state', [0, 4])->get();
        } else {
            $records = UserJoinRequest::where('state', $state)->get();
        }
        return view('admin.joinRequests.' . $type, compact('records'));
    }
    public function ChangeState($requestId, $state)
    {
        $record = UserJoinRequest::find($requestId);
        $record->update([
            'state' => $state,
            'times' =>  intval($record->times) + 1
        ]);
        return redirect()->back();
    }
    public function ChangeStateAccept($requestId)
    {
        $record = UserJoinRequest::find($requestId);
        $record->update([
            'state' => 1
        ]);
        Seller::create([
            'name' => $record->name,
            'email' => $record->email,
            'phone' => $record->mobile,
            'password' => Hash::make($record->password),
            'image' => ''
        ]);
        return redirect()->back();
    }
    public function UpdateNotes(Request $request)
    {

        $record = UserJoinRequest::find($request->requestId);
        $record->update([
            'notes' => $request->notes,
        ]);
        return redirect()->back();
    }
    public function UpdateFile(Request $request)
    {

        $fileName = $request->image->getClientOriginalName();
        $file_to_store = time() . '_' . $fileName;
        $request->image->move(public_path('assets/admin/joinRequests'), $file_to_store);

        $record = UserJoinRequest::find($request->requestId);
        $record->update([
            'file' => $file_to_store,
            'state' => 4,
            'times' => intval($record->times) + 1
        ]);
        return redirect()->back();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
