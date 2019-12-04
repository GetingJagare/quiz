<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('signin');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'filial' => 'required|string'
        ];

        $this->validate($request, $rules);

        $user = new User();
        $user->email = uniqid('email-', true);
        $user->password = bcrypt('password');
        $user->filial = $request->get('filial');
        $user->name = $request->get('name');
        $user->expert_type = 2; // зрители
        $user->save();

        \Auth::login($user);

        return redirect()->route('votePage');
    }

    /**
     * @param Request $request
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function byToken(Request $request, $token)
    {
        $user = User::whereToken($token)
            ->whereIsExpert(true)
            ->first();

        if (!$user) {
            abort(404);
        }

        \Auth::login($user);

        return redirect()->route('votePage');
    }
}
