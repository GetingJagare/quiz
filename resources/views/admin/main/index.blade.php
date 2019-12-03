@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered text-center tablesorter">
                    <thead>
                    <tr>
                        <th class="align-middle" rowspan="2">ФИО участника, наименование работы</th>
                        <th class="align-middle" colspan="5">Оценки конкурсной комиссии</th>
                        <th class="align-middle" rowspan="2">Средняя оценка конкурсной комиссии</th>
                        <th class="align-middle" colspan="5">Оценки экспертной комиссии</th>
                        <th class="align-middle" rowspan="2">Средняя оценка экспертов</th>
                        <th class="align-middle" rowspan="2">Средняя оценка конкурсной комиссии и экспертов</th>
                        <th class="align-middle" rowspan="2">Средняя оценка зрителей</th>
                    </tr>
                    <tr>
                        <th class="align-middle">Новизна</th>
                        <th class="align-middle">Степень проработки</th>
                        <th class="align-middle">Практическая ценность и актуальность</th>
                        <th class="align-middle">Представление доклада</th>
                        <th class="align-middle">Экономическая эффективность</th>
                        <th class="align-middle">Новизна</th>
                        <th class="align-middle">Степень проработки</th>
                        <th class="align-middle">Практическая ценность и актуальность</th>
                        <th class="align-middle">Представление доклада</th>
                        <th class="align-middle">Экономическая эффективность</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="align-middle">{{ $report->reporter }}<br/><b>{{ $report->name }}</b></td>
                            <td class="align-middle">{{ $report->getAverageCountByType('novelty', 0) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('study', 0) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('worth', 0) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('representation', 0) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('efficiency', 0) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByUserType(0) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('novelty', 1) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('study', 1) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('worth', 1) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('representation', 1) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByType('efficiency', 1) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByUserType(1) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageCountByUserType([0, 1]) ?: '-' }}</td>
                            <td class="align-middle">{{ $report->getAverageMark() }}</td>
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
