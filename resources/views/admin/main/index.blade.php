@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered text-center tablesorter">
                    <thead>
                    <tr>
                        <th rowspan="2">№</th>
                        <th rowspan="2">ФИО участника, наименование работы</th>
                        <th rowspan="2">Должность</th>
                        <th rowspan="2">Филиал</th>
                        <th rowspan="2">Приняли</th>
                        <th rowspan="2">Приняли с доработками</th>
                        <th rowspan="2">Отклонили</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="align-middle">{{ $report->id }}</td>
                            <td class="align-middle">{{ $report->reporter }}<br/><b>{{ $report->name }}</b></td>
                            <td class="align-middle">{{ $report->position }}</td>
                            <td class="align-middle">{{ $report->filial }}</td>
                            <td class="align-middle">{{ $report->getAcceptedCount() }}</td>
                            <td class="align-middle">{{ $report->getParticallyAcceptedCount() }}</td>
                            <td class="align-middle">{{ $report->getDeclinedCount() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">Нет ни одного доклада</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@endsection
