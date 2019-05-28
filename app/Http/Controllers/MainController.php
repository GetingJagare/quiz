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
        if (\Auth::user()->is_admin) {
            return redirect(route('admin.index'));
        }
        return view('main');
    }

    public function mark(Request $request)
    {
        $now = \Carbon\Carbon::now();

        $report = Report::where('from', '<=', $now)
            ->where('to', '>=', $now)
            ->where('status', '>=', 1)
            ->findOrFail($request->reportId);

        $user = \Auth::user();

        if ($report->hasMark($user)) {
            return JsonResponse::create(['voteStatus' => -1]);
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

        return JsonResponse::create(['voteStatus' => 1]);
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
        return redirect(route('main'));
    }

    /**
     * @return JsonResponse
     */
    public function checkReports()
    {
        $user = \Auth::user();
        $voteStatus = 0;
        $timeRemaining = 0;

        $now = \Carbon\Carbon::now();
        $report = Report::where('from', '<=', $now)
            ->where('to', '>=', $now)
            ->where('status', '>=', 1)
            ->first();

        if ($report && $report->status == 2) {
            $timeDiff = strtotime($report->vote_to) - time();
            if ($timeDiff > 0) {
                $timeRemaining = $timeDiff * 1000;
            } else {
                $report->status = 3;
                $report->save();
            }
        }

        if ($report && $report->hasMark($user)) {
            //$report = null;
            $voteStatus = -1;
        }

        return JsonResponse::create(['report' => $report ? $report->toArray() : null, 'voteStatus' => $voteStatus, 'time' => $timeRemaining]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signout(Request $request)
    {
        $redirectLink = \Auth::user()->is_admin ? '/login' : '/signin';

        \Auth::logout();

        return redirect($redirectLink);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getVoteResults(Request $request)
    {
        $report = Report::find($request->id);

        $count = 2;
        $results = [$report->getAcceptedCount(), $report->getParticallyAcceptedCount(), $report->getDeclinedCount()];

        return JsonResponse::create([
            'results' => [
                ['Категории', 'Кол-во проголосовавших', ['role' => 'style']],
                ['Приняли', $results[0], '#133d56'],
                ['Приняли с доработками', $results[1], '#133d56'],
                ['Отклонили', $results, '#133d56']
            ],
            'linesCount' => ceil((max($results) - min($results)) / $count)
        ]);
    }
}
