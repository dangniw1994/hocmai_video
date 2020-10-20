<?php

namespace App\Http\Controllers;

use App\HocMaiAppVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ManagerAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
            $input = $request->all();
    //    // dd($input['app_version']);
    //   
    //     // $data = HocMaiAppVersion::all();
    //     return view('hocmai_app.index')->with(compact('data'));
        $os_id = DB::table('app_versions')->select('os_id')->distinct()->get()->pluck('os_id');
        $status = DB::table('app_versions')->select('status')->distinct()->get()->pluck('status');
        $appVersion = DB::table('app_versions')->select('app_version')->distinct()->get()->pluck('app_version');
        
        $data = HocMaiAppVersion::all();
        if(!empty($input)){
            
            if($input['app_version'] == null && $input['os_id'] == null && $input['status'] == null){
                $data = HocMaiAppVersion::all();
            }
            else if($input['app_version'] == null)
            {
                if($input['os_id'] == null && $input['status'] != null){
                    $data=DB::table('app_versions')
                    ->where('status',$input['status'])
                    ->get();
                }else if($input['os_id'] != null && $input['status'] == null )
                {
                    $data=DB::table('app_versions')->where('os_id',$input['os_id'])
                    ->get();
                }else
                {
                    $data=DB::table('app_versions')->where('os_id',$input['os_id'])
                    ->where('status',$input['status'])
                    ->get();
                }
               
            }
            else if( $input['os_id'] == null )
            {
                if($input['app_version'] == null && $input['status'] != null){
                    $data=DB::table('app_versions')
                    ->where('status',$input['status'])
                    ->get();
                }else if($input['app_version'] != null && $input['status'] == null )
                {
                    $data=DB::table('app_versions')->where('app_version',$input['app_version'])
                    ->get();
                }else
                {
                    $data=DB::table('app_versions')->where('app_version',$input['app_version'])->where('status',$input['status'])->get();
                }
                
            }
            else if($input['status'] == null)
            {
                if($input['app_version'] == null && $input['os_id'] != null){
                    $data=DB::table('app_versions')
                    ->where('os_id',$input['os_id'])
                    ->get();
                }else if($input['app_version'] != null && $input['os_id'] == null )
                {
                    $data=DB::table('app_versions')->where('app_version',$input['app_version'])
                    ->get();
                }else
                {
                    $data=DB::table('app_versions')->where('app_version',$input['app_version'])->where('os_id',$input['os_id'])->get();
                }
                
            }
            else
            {
                $data = DB::table('app_versions')->where('os_id',$input['os_id'])
                ->where('status',$input['status'])
                ->where('app_version',$input['app_version'])
                ->get();
            }
        }else{
            $data = HocMaiAppVersion::all();
        }
        
        return view('hocmai_app.index',[
            'os_id' => $os_id,
            'status'=>$status,
            'appVersion' => $appVersion,
            'data'=>$data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hocmai_app.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if ($input['status'] == APP_ACTIVE) {
            HocMaiAppVersion::whereNull('deleted_at')->update(['status' => APP_INACTIVE]);
        }
        $appVersionId = HocMaiAppVersion::create($input)->id;
        return Redirect::action('ManagerAppController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appVersion = HocMaiAppVersion::find($id);
        return view('hocmai_app.show')->with(compact('appVersion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appVersion = HocMaiAppVersion::find($id);
        return view('hocmai_app.edit')->with(compact('appVersion'));
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
        $input = $request->all();
        $appVersion = HocMaiAppVersion::find($id);
        $appVersion->update($input);
        return Redirect::action('ManagerAppController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HocMaiAppVersion::destroy($id);
        return Redirect::action('ManagerAppController@index');
    }
}
