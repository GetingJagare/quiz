<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExpertController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $experts = User::whereIsExpert(true)
            ->orderBy('name')
            ->get();

        return view('admin.expert.index', [
            'experts' => $experts
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.expert.edit', [
            'expert' => new User()
        ]);
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
            'expert_type' => 'required|integer|in:0,1'
        ];

        $this->validate($request, $rules);

        $user = new User();
        $user->email = uniqid('email-', true);
        $user->password = bcrypt('password');
        $user->filial = "";
        $user->name = $request->get('name');
        $user->is_expert = true;
        $user->expert_type = $request->get('expert_type');

        do {
            $token = Str::random(24);
        }while(User::whereToken($token)->count());

        $user->token = $token;
        $user->save();

        return redirect()->route('admin.expert.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $expert = User::findOrFail($id);

        return view('admin.expert.edit', [
            'expert' => $expert
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $expert = User::findOrFail($id);

        $rules = [
            'name' => 'required|string',
            'expert_type' => 'required|integer|in:0,1'
        ];

        $this->validate($request, $rules);

        $expert->name = $request->get('name');
        $expert->expert_type = $request->get('expert_type');
        $expert->save();

        return redirect()->route('admin.expert.index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, $id)
    {
        $expert = User::findOrFail($id);
        $expert->delete();

        return redirect()->route('admin.expert.index');
    }
}
