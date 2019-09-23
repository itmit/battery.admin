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
     * 
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

    /**
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function dealer()
    {
        return view('client.listOfDealers', [
            'clients' => Client::where('role', '=', 'dealer')
                ->orderBy('created_at', 'desc')->get()
        ]
        );   
    }

    /**
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function seller()
    {
        return view('client.listOfSellers', [
            'clients' => Client::where('role', '=', 'seller')
                ->orderBy('created_at', 'desc')->get()
        ]
        );   
    }

    /**
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function stockman()
    {
        return view('client.listOfStockmans', [
            'clients' => Client::where('role', '=', 'stockman')
                ->orderBy('created_at', 'desc')->get()
        ]
        );   
    }

    /**
     * Показывает страницу создания пользователя.
     *
     * @return Response
     */
    public function dealerCreate()
    {
        return view("client.createDealer");
    }

    /**
     * Показывает страницу создания пользователя.
     *
     * @return Response
     */
    public function sellerCreate()
    {
        $dealers = Client::where('role', '=', 'dealer')->get();
        return view("client.createSeller", ['dealers' => $dealers]);
    }

    /**
     * Показывает страницу создания пользователя.
     *
     * @return Response
     */
    public function stockmanCreate()
    {
        return view("client.createStockman");
    }

    /**
     * Создает нового диспетчера и редиректит на главную страницу представителя.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeDealer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255|unique:clients',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.dealercreate')
                ->withErrors($validator)
                ->withInput();
        }

        $uid = (string) Str::uuid();

        Client::create([
            'login' => $request->input('login'),
            'uid' => $uid,
            'role' => 'dealer',
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()->route('auth.dealer');
    }

    /**
     * Создает нового диспетчера и редиректит на главную страницу представителя.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeSeller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255|unique:clients',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
            'dealer' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.sellercreate')
                ->withErrors($validator)
                ->withInput();
        }

        $uid = (string) Str::uuid();

        Client::create([
            'login' => $request->input('login'),
            'uid' => $uid,
            'role' => 'seller',
            'dealer' => $request->input('dealer'),
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()->route('auth.seller');
    }

    /**
     * Создает нового диспетчера и редиректит на главную страницу представителя.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeStockman(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255|unique:clients',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.stockmancreate')
                ->withErrors($validator)
                ->withInput();
        }

        $uid = (string) Str::uuid();

        Client::create([
            'login' => $request->input('login'),
            'uid' => $uid,
            'role' => 'stockman',
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()->route('auth.stockman');
    }

}
