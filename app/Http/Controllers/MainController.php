<?php

namespace App\Http\Controllers;

use App\Mark;
use App\MarkExpert;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth::user();

        if (Carbon::createFromFormat('Y-m-d', config('app.date'))->startOfDay() != Carbon::now()->startOfDay()) {
            $report = null;
        } else {
            $now = \Carbon\Carbon::now();
            $report = Report::where('from', '<=', $now->format('H:i:s'))
                ->where('to', '>=', $now->format('H:i:s'))
                ->first();

            if ($report->hasMark($user) || $report->hasExpertMark($user)) {
                $report = null;
            }
        }

        return view('main', [
            'result' => \Session::pull('result', false),
            'report' => $report,
            'user' => $user
        ]);
    }

    public function mark(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $rules = [
            'mark' => 'required|in:0,1,2,3,4,5'
        ];

        $this->validate($request, $rules, [
            'required' => 'Выберите оценку'
        ]);

        $user = \Auth::user();

        if ($user->is_expert || $report->hasMark($user)) {
            return redirect()->route('main');
        }

        $mark = new Mark();
        $mark->user_id = $user->id;
        $mark->report_id = $report->id;
        $mark->mark = $request->get('mark');
        $mark->save();

        \Session::put('result', true);

        return redirect()->route('main');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function markExpert(Request $request, $id)
    {
        $report = Report::findOrFail($id);

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
}
