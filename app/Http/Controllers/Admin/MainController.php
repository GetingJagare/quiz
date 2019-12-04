<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Report;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $reports = Report::all();

        $reportsData = [];

        foreach ($reports as $report) {
            $com_avg = $report->getAverageCountByUserType(0) ?: '-';
            $exp_avg = $report->getAverageCountByUserType(1) ?: '-';
            $com_exp_sum = (is_numeric($com_avg) ? $com_avg : 0) + (is_numeric($exp_avg) ? $exp_avg : 0);

            $reportsData[] = [
                'reporter' => $report->reporter,
                'name' => $report->name,
                'com_novelty' => $report->getAverageCountByType('novelty', 0) ?: '-',
                'com_study' => $report->getAverageCountByType('study', 0) ?: '-',
                'com_worth' => $report->getAverageCountByType('worth', 0) ?: '-',
                'com_representation' => $report->getAverageCountByType('representation', 0) ?: '-',
                'com_efficiency' => $report->getAverageCountByType('efficiency', 0) ?: '-',
                'com_avg' => $com_avg,
                'exp_novelty' => $report->getAverageCountByType('novelty', 1) ?: '-',
                'exp_study' => $report->getAverageCountByType('study', 1) ?: '-',
                'exp_worth' => $report->getAverageCountByType('worth', 1) ?: '-',
                'exp_representation' => $report->getAverageCountByType('representation', 1) ?: '-',
                'exp_efficiency' => $report->getAverageCountByType('efficiency', 1) ?: '-',
                'exp_avg' => $exp_avg,
                'com_exp_sum' => $com_exp_sum > 0 ? $com_exp_sum : '-',
                'view_avg' => $report->getAverageMark() ?: '-',
            ];
        }

        usort($reportsData, function ($first, $second) {
            return $first['com_avg'] < $second['com_avg'] ? 1 : ($first['com_avg'] > $second['com_avg'] ? -1 : 0);
        });

        return view('admin.main.index', [
            'reports' => $reportsData
        ]);
    }
}
