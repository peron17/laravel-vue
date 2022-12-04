<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $member = Members::with('user')->get();

        // return $member;
        // return $dataTables->make(true);
        return view('Admin.Member.index');
    }
    public function api(Request $request)
    {
        if ($request->gender) {
            $datas = Members::with('user')->where('gender', $request->gender)->get();
        } else {
            $datas = Members::with('user')->get();
        }
        $dataTables = datatables()->of($datas)->addIndexColumn();


        // $members = Members::with('user')->get();
        $dataTables = datatables()->of($datas)
            ->addColumn('tanggal_buat', function ($datas) {
                return DateFormat($datas->created_at);
            })
            ->addIndexColumn();

        return $dataTables->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $this->validate($request, [
            'name' => ['required', 'min:8', 'max:30'],
            'gender' => ['required'],
            'phone_number' => ['required', 'min:12', 'max:13'],
            'adress' => ['required', 'min:20', 'max:100'],
            'email' => ['required', 'min:8', 'max:30'],
        ]);

        Members::create($request->all());

        return redirect('members');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function show(Members $members)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function edit(Members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Members $members)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function destroy(Members $members)
    {
        //
    }
}