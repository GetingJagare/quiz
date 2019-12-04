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
                            <td class="align-middle">{{ $report['reporter'] }}<br/><b>{{ $report['name'] }}</b></td>
                            <td class="align-middle">{{ $report['com_novelty'] }}</td>
                            <td class="align-middle">{{ $report['com_study'] }}</td>
                            <td class="align-middle">{{ $report['com_worth'] }}</td>
                            <td class="align-middle">{{ $report['com_representation'] }}</td>
                            <td class="align-middle">{{ $report['com_efficiency'] }}</td>
                            <td class="align-middle">{{ $report['com_avg'] }}</td>
                            <td class="align-middle">{{ $report['exp_novelty'] }}</td>
                            <td class="align-middle">{{ $report['exp_study'] }}</td>
                            <td class="align-middle">{{ $report['exp_worth'] }}</td>
                            <td class="align-middle">{{ $report['exp_representation'] }}</td>
                            <td class="align-middle">{{ $report['exp_efficiency'] }}</td>
                            <td class="align-middle">{{ $report['exp_avg'] }}</td>
                            <td class="align-middle">{{ $report['com_exp_sum'] }}</td>
                            <td class="align-middle">{{ $report['view_avg'] }}</td>
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
