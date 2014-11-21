<?php

class TransRequestController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        $query = DB::table('request')
            ->select('request.*', 'lang1.lang_name as lang_name_src', 'lang2.lang_name as lang_name_dest',
                'country.country_name', DB::raw(' CONCAT(user.first_name, \' \', user.last_name) as username'));
        $result = $query
            ->join('language as lang1', 'request.src_lang_id', '=', 'lang1.lang_id')
            ->join('language as lang2', 'request.dest_lang_id', '=', 'lang2.lang_id')
            ->join('country', 'request.country_id', '=', 'country.country_id')
            ->join('user', 'request.user_id', '=', 'user.user_id')
            ->get();

        //$queries = DB::getQueryLog();

//        echo "<pre>";
//        print_r($queries);exit;




        return Response::json($result);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $input = Input::all();

        $request = new TransRequest();
        if(!$request->validate($input)){
            return \Responser::error($request->getErrors());
        }
        $request->setData($input);
        $request->status = TransRequest::STATUS_CREATED;
        $request->save();

        return \Responser::success(trans('Create request successfully.'), $request);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        $request = TransRequest::where('request_id',$id)->first();
        $request->src_lang = $request->srcLanguage()->first()->lang_name;
        $request->dest_lang = $request->destLanguage()->first()->lang_name;
        $request->country = $request->country()->first()->country_name;
        $user = $request->user()->first();
        $request->username = $user->first_name . ' '.$user->last_name;
        return Response::json($request);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
