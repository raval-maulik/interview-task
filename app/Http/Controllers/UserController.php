<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    public function index()
    {
    	$data['users'] = User::all();
    	return view('users',$data);
    }

    public function user_list(Request $request)
    {

    	$users = User::select('id', 'name', 'email',"gender");

        $total_count=$users->count();
        if ($request->search['value']) {
            $users = $users->where("name", "LIKE", "%" . $request->search['value'] . "%")
            					->orWhere("email", "LIKE", "%" . $request->search['value'] . "%")
            					->orWhere("gender", "LIKE", "%" . $request->search['value'] . "%");
        }
        if (!empty($request->order[0]['column'])) {
	        switch ($request->order[0]['column']) {
	            case 0:
	                $users->orderBy('name', $request->order[0]['dir']);
	                break;
	            case 1:
	                $users->orderBy('email', $request->order[0]['dir']);
	                break;
	            case 2:
	                $users->orderBy('gender', $request->order[0]['dir']);
	                break;
	        }
        }else{
        	$users->orderBy('updated_at', "desc");
        	
        }

        $filtered_count=$users->count();
//           echo "<pre>";print_r($users->get());die; 
        $page = ($request->start / $request->length) + 1;
        // $data = $users->paginate($request->length, "*", 'page', $page);
        $data = $users->skip($request->start)->take($request->length)->get();
        $data = [
            "draw" => $request->draw, "recordsTotal" => $total_count,
            "recordsFiltered" => $filtered_count, "data" => $data
        ];
        return json_encode($data);


    }
    public function user_detail($id)
    {
    	return User::select("id","name","gender","city","address","email")->where("id",$id)->first();
    	echo "string";
    }
}
