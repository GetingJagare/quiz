<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Report;
use Carbon\Carbon;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;

class ReportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $reports = Report::orderByDesc('id')->get();

        $reportsData = [];

        foreach ($reports as $report) {
            $reportsData[$report->id] = [
                'id' => $report->id,
                'name' => $report->name,
                'reporter' => $report->reporter,
                'avg_count' => $report->getAverageCountByUserType(0),
                'status' => $report->status
            ];
        }

        $sortedReports = $reportsData;

        usort($sortedReports, function ($first, $second) {
           return $first['avg_count'] < $second['avg_count'] ? 1 : ($first['avg_count'] > $second['avg_count'] ? -1 : 0);
        });

        foreach ($reportsData as $id => &$report) {
            $report['place'] = array_search($id, array_column($sortedReports, 'id')) + 1;
        }

        return view('admin.report.index', [
            'reports' => $reportsData
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.report.edit', [
            'report' => new Report()
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
            'reporter' => 'required|string',
            //'position' => 'required|string',
            //'filial' => 'required|string',
        ];

        $this->validate($request, $rules);

        $report = new Report();
        $report->fill($request->all());
        $report->save();

        return redirect()->route('admin.report.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        return view('admin.report.edit', [
            'report' => $report
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
        $report = Report::findOrFail($id);

        $rules = [
            'name' => 'required|string',
            'reporter' => 'required|string',
            'position' => 'required|string',
            'filial' => 'required|string',
            'from' => 'required|date',
            'to' => 'required|date',
        ];

        $this->validate($request, $rules);

        $request->merge([
            'from' => Carbon::createFromFormat('Y-m-d\TH:i', $request->get('from')),
            'to' => Carbon::createFromFormat('Y-m-d\TH:i', $request->get('to')),
        ]);

        $report->fill($request->all());
        $report->save();

        return redirect()->route('admin.report.index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.report.index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function show(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        return view('admin.report.show', [
            'report' => $report
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $report->active = !$report->active;
        $report->save();

        return redirect()->route('admin.report.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $report = Report::find($request->id);
        $report->status = $request->status;

        $report->save();

        return JsonResponse::create(['status' => 1]);
    }
}
