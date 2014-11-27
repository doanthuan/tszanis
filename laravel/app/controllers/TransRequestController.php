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
                'country.country_name',
                DB::raw(' CONCAT(creator.first_name, \' \', creator.last_name) as creator_name'),
                DB::raw(' CONCAT(translator.first_name, \' \', translator.last_name) as translator_name')
            );
        $query
            ->join('language as lang1', 'request.src_lang_id', '=', 'lang1.lang_id')
            ->join('language as lang2', 'request.dest_lang_id', '=', 'lang2.lang_id')
            ->join('country', 'request.country_id', '=', 'country.country_id')
            ->join('user as creator', 'request.user_id', '=', 'creator.user_id')
            ->leftJoin('user as translator', 'request.translator_id', '=', 'translator.user_id');

        if(Input::has('user_id')){
            $roleId = Input::get('role_id', 0);
            if($roleId == Role::ROLE_REQUESTER){
                $query->where('request.user_id', Input::get('user_id'));
            }
            else if($roleId == Role::ROLE_SERVICE_PROVIDER){
                $query->where('request.translator_id', Input::get('user_id'));
                $query->where('request.status', TransRequest::STATUS_ASSIGNED);
            }
        }
        else{
            $query->where('request.status', TransRequest::STATUS_CREATED);
        }

        $query->orderBy('request.request_id','DESC');


        $result = $query->get();

        //$queries = DB::getQueryLog();

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
        $request = TransRequest::find($id);
        if(!$request){
            return \Responser::error('Can not find request record');
        }

        $status = Input::get('status');
        if(!in_array($status, array(
            TransRequest::STATUS_ASSIGNED,
            TransRequest::STATUS_COMPLETED,
            TransRequest::STATUS_CANCELED))){
            return \Responser::error('Status is not valid');
        }

        $request->status = $status;


        //prepare info for email
        $user = $request->user;
        $recipient = $user->email;
        $dataEmail['first_name'] = $user->first_name;
        $dataEmail['last_name'] = $user->last_name;

        $dataEmail['requestUrl'] = \Config::get('app.angular_url').'request/view/'.$request->request_id;

        if($status == TransRequest::STATUS_ASSIGNED){

            $translatorId = Input::get('translator_id');
            if(!$translatorId){
                return \Responser::error('Invalid service provider');
            }
            $translator = User::find($translatorId);
            $dataEmail['translator_name'] = $translator->first_name.' '.$translator->last_name;

            $subject = EmailTemplate::where('file', 'request/accept.blade.php')->first()->subject;
            Mail::send('emails.request.accept', $dataEmail, function($message) use($recipient, $subject)
            {
                $message->to($recipient)->subject($subject);
            });

            $request->translator_id = $translatorId;
            $message = 'Your request has been accepted';
        }
        else if($status == TransRequest::STATUS_COMPLETED){

            $subject = EmailTemplate::where('file', 'request/complete.blade.php')->first()->subject;
            Mail::send('emails.request.complete', $dataEmail, function($message) use($recipient, $subject)
            {
                $message->to($recipient)->subject($subject);
            });

            $message = 'Your request has been completed';
        }
        else if($status == TransRequest::STATUS_CANCELED){
            $message = 'Your request has been canceled';
        }
        $request->save();

        return \Responser::success($message);
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
