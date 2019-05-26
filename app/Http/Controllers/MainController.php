<?php

namespace App\Http\Controllers;

use App\Mark;
use App\MarkExpert;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return redirect(route('votePage'));
    }

    public function mark(Request $request)
    {
        $now = \Carbon\Carbon::now();

        $report = Report::where('from', '<=', $now)
            ->where('to', '>=', $now)
            ->where('active', '=', 1, 'OR')
            ->findOrFail($request->reportId);

        if (empty($report)) {
            return JsonResponse::create(['status' => -1]);
        }

        $user = \Auth::user();

        if ($report->hasMark($user)) {
            return JsonResponse::create(['status' => -2]);
        }

        /*$rules = [
            'mark' => 'required|in:0,1,2,3,4,5'
        ];

        $this->validate($request, $rules, [
            'required' => 'Выберите оценку'
        ]);*/

        $mark = new Mark();
        $mark->user_id = $user->id;
        $mark->report_id = $report->id;
        $mark->mark = $request->mark;
        $mark->save();

        return JsonResponse::create(['status' => 1]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function markExpert(Request $request, $id)
    {
        $now = \Carbon\Carbon::now();

        $report = Report::where('from', '<=', $now)
            ->where('to', '>=', $now)
            ->whereActive(true)
            ->findOrFail($id);

        $rules = [
            'novelty' => 'required|in:0,1,2,3,4,5',
            'study' => 'required|in:0,1,2,3,4,5',
            'worth' => 'required|in:0,1,2,3,4,5',
            'representation' => 'required|in:0,1,2,3,4,5',
            'efficiency' => 'required|in:0,1,2,3,4,5',
        ];

        $this->validate($request, $rules, [
            'required' => 'Выберите оценку'
        ]);

        $user = \Auth::user();

        if (!$user->is_expert || $report->hasExpertMark($user)) {
            return redirect()->route('main');
        }

        $mark = new MarkExpert();
        $mark->user_id = $user->id;
        $mark->report_id = $report->id;
        $mark->novelty = $request->get('novelty');
        $mark->study = $request->get('study');
        $mark->worth = $request->get('worth');
        $mark->representation = $request->get('representation');
        $mark->efficiency = $request->get('efficiency');
        $mark->expert_type = $user->expert_type;
        $mark->save();

        \Session::put('result', true);

        return redirect()->route('main');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function result(Request $request)
    {
        $reports = Report::orderBy('from')
            ->get();

        return view('result', [
            'reports' => $reports
        ]);
    }

    public function votePage()
    {
        $user = \Auth::user();

        $now = \Carbon\Carbon::now();
        $report = Report::where('from', '<=', $now)
            ->where('to', '>=', $now)
            ->where('active', '=', 1, 'OR')
            ->first();

        $resultMark = null;

        if ($report && ($report->hasMark($user) || $report->hasExpertMark($user))) {
            $resultMark = ($user->is_expert ? $report->getExpertMark($user) : $report->getMark($user));
            $report = null;
        }

        return view('main', [
            'result' => \Session::pull('result', false),
            'report' => $report,
            'resultMark' => $resultMark,
            'user' => $user
        ]);
    }

    public function vote(Request $request) {

    }
}
