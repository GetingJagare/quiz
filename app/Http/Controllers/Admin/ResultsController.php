<?php

namespace App\Http\Controllers\Admin;

use App\Mark;
use App\MarkExpert;
use App\Report;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultsController extends Controller
{
    public function index()
    {
        return view('admin.results.index');
    }

    public function viewers()
    {
        return view('admin.results.viewers');
    }

    public function getViewerResults()
    {
        $viewers = User::where(['expert_type' => 2, 'is_admin' => 0])->get();

        $viewersData = [];

        foreach ($viewers as $viewer) {
            $viewersData[$viewer->id] = [
                'name' => $viewer->name,
                'filial' => $viewer->filial
            ];

            /** @var Mark $mark */
            foreach ($viewer->marks as $mark) {
                $viewersData[$viewer->id]['marks'][$mark->report_id] = $mark->mark;
            }
        }

        return JsonResponse::create(['viewers' => $viewersData, 'count' => count($viewersData)]);
    }

    public function getViewerReports()
    {
        $reports = Report::all();

        $reportsData = [];

        foreach ($reports as $report) {
            $reportsData[] = [
                'id' => $report->id,
                'name' => $report->name,
                'reporter' => $report->reporter,
                'avgMark' => $report->getAverageMark()
            ];
        }

        return JsonResponse::create(['reports' => $reportsData]);
    }

    public function getExpertResults()
    {
        $expertsData = [];

        foreach (['com' => 0, 'exp' => 1] as $expertTypeName => $expertType) {
            $experts = User::where(['expert_type' => $expertType, 'is_admin' => 0])->get();

            $expertsData[$expertTypeName]['count'] = count($experts);

            foreach ($experts as $expert) {

                $expertsData[$expertTypeName]['experts'][$expert->id] = [
                    'name' => $expert->name
                ];

                /** @var MarkExpert $expertMark */
                foreach ($expert->expertMarks as $expertMark) {
                    $expertsData[$expertTypeName]['experts'][$expert->id]['marks'][$expertMark->report_id] = [
                        'novelty' => $expertMark->novelty,
                        'study' => $expertMark->study,
                        'worth' => $expertMark->worth,
                        'representation' => $expertMark->representation,
                        'efficiency' => $expertMark->efficiency,
                    ];
                }

            }

        }

        return JsonResponse::create(['experts' => $expertsData]);
    }

    public function getExpertReports()
    {
        $reports = Report::all();

        $reportsData = [];

        foreach ($reports as $report) {
            $comAvgMark = $report->getAverageCountByUserType(0);
            $expAvgMark = $report->getAverageCountByUserType(1);

            $reportsData[] = [
                'id' => $report->id,
                'name' => $report->name,
                'reporter' => $report->reporter,
                'comAvgMark' => $comAvgMark,
                'expAvgMark' => $expAvgMark,
                'avgMarkSum' => round($comAvgMark + $expAvgMark, 2)
            ];
        }

        return JsonResponse::create(['reports' => $reportsData]);
    }
}
