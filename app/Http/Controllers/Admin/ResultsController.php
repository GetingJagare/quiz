<?php

namespace App\Http\Controllers\Admin;

use App\Mark;
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
        $viewers = User::where(['expert_type' => 2])->get();

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
}
