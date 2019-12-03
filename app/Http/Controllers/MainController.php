<?php

namespace App\Http\Controllers;

use App\Mark;
use App\MarkExpert;
use App\Report;
use App\User;
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
        $report = Report::where('status', '>=', 1)
            ->first();

        if (!$report) {
            return JsonResponse::create(['voteStatus' => 0]);
        }

        $user = \Auth::user();

        if ($report->hasMark($user)) {
            return JsonResponse::create(['voteStatus' => 1]);
        }

        $mark = new Mark();
        $mark->user_id = $user->id;
        $mark->report_id = $report->id;
        $mark->mark = $request->mark;
        $mark->save();

        return JsonResponse::create(['voteStatus' => 1]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function markExpert(Request $request)
    {
        $report = Report::whereActive(true)->where('status', '>=', 1)->first();

        if (!$report) {
            return JsonResponse::create(['voteStatus' => 0]);
        }

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

        return JsonResponse::create(['voteStatus' => 1, 'voteMessage' => $this->getVoteMessage($user, $report)]);
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

        $report = Report::where('status', '>=', 1)
            ->first();

        if (!$report) {
            return JsonResponse::create([
                'report' => null,
                'voteStatus' => 0,
                'voteMessage' => '',
                'time' => 0,
                'userType' => $user->expert_type,
            ]);
        }

        if ($report->status == 2) {
            $timeDiff = strtotime($report->vote_to) - time();
            if ($timeDiff > 0) {
                $timeRemaining = $timeDiff * 1000;
            } else {
                $report->status = 3;
                $report->save();
            }
        }

        if ($report->hasMark($user) || $report->hasExpertMark($user)) {
            $voteStatus = 1;
        }

        return JsonResponse::create([
            'report' => $report ? $report->toArray() : null,
            'voteStatus' => $voteStatus,
            'voteMessage' => $this->getVoteMessage($user, $report),
            'time' => $timeRemaining,
            'userType' => $user->expert_type,
        ]);
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
        $results = [
            $report->getAverageCountByType('novelty'),
            $report->getAverageCountByType('study'),
            $report->getAverageCountByType('worth'),
            $report->getAverageCountByType('representation'),
            $report->getAverageCountByType('efficiency')
        ];

        return JsonResponse::create([
            'results' => [
                ['Категории', 'Средняя оценка', ['role' => 'style']],
                ['Новизна', $results[0], '#133d56'],
                ['Степень проработки', $results[1], '#133d56'],
                ['Практическая ценность и актуальность', $results[2], '#133d56'],
                ['Представление доклада', $results[3], '#133d56'],
                ['Экономическая эффективность', $results[4], '#133d56'],
            ],
            'linesCount' => ceil((max($results) - min($results)) / $count)
        ]);
    }

    /**
     * @param User $user
     * @param Report $report
     * @return string
     */
    private function getVoteMessage($user, $report) {
        $averageVote = "";

        // юзер - не зритель
        if ($user->expert_type <= 1) {
            $averageVote = "<br>Ваша средняя оценка: " . $user->getReportAverageCount($report->id);
        }

        return "Ваш голос принят.$averageVote";
    }
}
