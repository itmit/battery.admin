<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ClientWebController extends Controller
{

    /**
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function index()
    {
        return view('client.listOfClients', [
            'clients' => Client::select('*')
                ->orderBy('created_at', 'desc')->get()
        ]
        );   
    }
    
    /**
     * Показывает страницу создания пользователя.
     *
     * @return Response
     */
    public function create()
    {
        return view("client.createClient");
    }

    /**
     * Создает нового диспетчера и редиректит на главную страницу представителя.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255|unique:clients',
            'role' => 'required',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.client.create')
                ->withErrors($validator)
                ->withInput();
        }

        $uid = (string) Str::uuid();

        $role = NULL;

        switch ($request->input('role')) {
            case 'stockman':
                $role = 'stockman';
                break;
            case 'dealer':
                $role = 'dealer';
                break;
            case 'seller':
                $role = 'seller';
                break;
            default:
                $role = NULL;
        }

        Client::create([
            'login' => $request->input('login'),
            'uid' => $uid,
            'role' => $role,
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()->route('auth.client.index');
    }

    public function destroy(Request $request)
    {
        Client::destroy($request->input('ids'));

        return response()->json(['Clients destroyed']);
    }

    public function show($id)
    {
        $client = Client::where('id', '=', $id)->first();

        return view("client.detailClient", [
            'client' => $client
        ]);
    }

}
