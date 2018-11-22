@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div>
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th rowspan="2">№</th>
                        <th rowspan="2">ФИО участника, наименование работы</th>
                        <th rowspan="2">Должность</th>
                        <th rowspan="2">Филиал</th>
                        <th colspan="5">Оценки конкурсной комиссии</th>
                        <th rowspan="2">Результат</th>
                    </tr>
                    <tr>
                        <th>Новизна</th>
                        <th>Степень<br/>проработки</th>
                        <th>Практическая ценность<br/>и актуальность</th>
                        <th>Представление<br/>доклада</th>
                        <th>Экономическая<br/>эффективность</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="align-middle">{{ $report->id }}</td>
                            <td class="align-middle">{{ $report->reporter }}<br/><b>{{ $report->name }}</b></td>
                            <td class="align-middle">{{ $report->position }}</td>
                            <td class="align-middle">{{ $report->filial }}</td>
                            <td class="align-middle">{{ number_format($report->getAverageNovelty(), 1) }}</td>
                            <td class="align-middle">{{ number_format($report->getAverageStudy(), 1) }}</td>
                            <td class="align-middle">{{ number_format($report->getAverageWorth(), 1) }}</td>
                            <td class="align-middle">{{ number_format($report->getAverageRepresentation(), 1) }}</td>
                            <td class="align-middle">{{ number_format($report->getAverageEfficiency(), 1) }}</td>
                            <td class="align-middle">{{ number_format($report->getAverageMark(), 1) }}</td>
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
