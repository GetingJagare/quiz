<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $reports = Report::orderBy('from')
            ->get();

        return view('admin.report.index', [
            'reports' => $reports
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
            'position' => 'required|string',
            'filial' => 'required|string',
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i',
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
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i',
        ];

        $this->validate($request, $rules);

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
}
