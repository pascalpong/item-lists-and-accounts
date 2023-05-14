<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Payload;
use Tymon\JWTAuth\Claims\Collection as ClaimCollection;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $json = json_decode(file_get_contents(storage_path('json/data.json')));
        return $json;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);

        $data = json_decode(file_get_contents(storage_path('json/data.json')));

        $newData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'username' => $request->username,
            'company' => $request->company,
            'nationality' => $request->nationality,
        ];
        $data[] = $newData;

        file_put_contents(storage_path('json/data.json'), json_encode($data));

        return response()->json(['message' => 'Data added successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $search = $request->search ?? null;
        $data = collect(json_decode(file_get_contents(storage_path('json/data.json'))));
        if($search) {
            $data = $data->filter(function ($data) use ($search) {
                return str_contains(strtolower($data->name) , $search) !== false
                || str_contains(strtolower($data->email) , strtolower($search)) !== false
                || str_contains(strtolower($data->phone) , strtolower($search)) !== false
                || str_contains(strtolower($data->username) , strtolower($search)) !== false
                || str_contains(strtolower($data->nationality) , strtolower($search)) !== false;
            });
        }
        return view('accounts',[
            "data" => $data,
            "search" => $search,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = json_decode(file_get_contents(storage_path('json/data.json')));

        if (!$data) {
            return response()->json(['message' => 'data not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach($data as $key => $item) {
            if($item->username == $request->input('username')) {
                $item->name = $request->input('name');
                $item->phone = $request->input('phone');
                $item->password = $request->input('password');
                $item->email = $request->input('email');
                $item->company = $request->input('company');
                $item->nationality = $request->input('nationality');
            }
        }

        file_put_contents(storage_path('json/data.json'), json_encode($data));

        return response()->json([
            'message' => 'Data updated successfully!'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $data = json_decode(file_get_contents(storage_path('json/data.json')), true);
        $index = array_search($request->username, array_column($data, 'username'));

        if ($index !== false) {

            array_splice($data, $index, 1);
            file_put_contents(storage_path('json/data.json'), json_encode($data));

            return response()->json(['message' => 'Record deleted'], 200);
        } else
            return response()->json(['message' => 'Record not found'], 404);

    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $json = file_get_contents(storage_path('json/data.json'));
        $data = json_decode($json, true);
        $user = collect($data)->where('username', $credentials['username'])->first();

        if (!$user || $credentials['password'] != $user['password'])
            return response()->json(['error' => 'Invalid credentials'], 401);

        $claims = ['username' => $user['username'], 'password' => $user['password']];

        // encode the JWT token
        $token = crypt(json_encode($claims), env('APP_KEY'));

        return $token;

    }
}
