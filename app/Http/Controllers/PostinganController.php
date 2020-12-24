<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postingan;
use Ramsey\Uuid\Uuid;

class PostinganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if( $request->is('api/*')){
            //write your logic for api call
            $data = Postingan::orderBy('created_at', 'DESC')->paginate(1);
            return response()->json(['data' => $data, 'success' => true],200);
        }else{
            //write your logic for web call
            $data = Postingan::orderBy('created_at', 'DESC')->paginate(4);
            return view('Frontend.index', ['data' => $data]);
        }

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
        // dd($request->all());
        $uuid = Uuid::uuid4();
        $postingan = Postingan::Create([
            'UUID' => $uuid->toString(),
            'nama' => $request->get('nama'),
            'isi' => $request->get('isi'),
            'key' => $request->get('key'),
            'like' => 0,
        ]);
        if($postingan) {
            return $postingan;
        }
        return 'fail';
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
        if($request->get('type') == 'like') {
            $data = Postingan::find($id);
            $data->like =  $data->like + 1;
            $data->save();
            return 'true';
        }

        $data = Postingan::find($id);
        $data->isi =  $request->get('isi');
        $data->save();
        return 'true';
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

    public function cekPostinganKey(Request $request)
    {
     $MatchKeyWithPost = Postingan::find($request->get('UUID'))->where('key', $request->get('key'))->first();
     if($MatchKeyWithPost) {
         return 'true';
     }
     return 'false';
    }
}
