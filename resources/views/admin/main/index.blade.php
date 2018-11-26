@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered text-center tablesorter">
                    <thead>
                    <tr>
                        <th {{--rowspan="2"--}}>№</th>
                        <th {{--rowspan="2"--}}>ФИО участника, наименование работы</th>
                        <th {{--rowspan="2"--}}>Должность</th>
                        <th {{--rowspan="2"--}}>Филиал</th>
                        <th {{--colspan="5"--}}>Средняя оценка конкурсной комиссии</th>
                        <th {{--colspan="5"--}}>Средняя оценка экспертов</th>
                        <th {{--colspan="5"--}}>Средняя оценка зрителей</th>
                        {{--<th rowspan="2">Результат</th>--}}
                    </tr>
                    {{--<tr>
                        <th>Новизна</th>
                        <th>Степень<br/>проработки</th>
                        <th>Практическая ценность<br/>и актуальность</th>
                        <th>Представление<br/>доклада</th>
                        <th>Экономическая<br/>эффективность</th>
                    </tr>--}}
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="align-middle">{{ $report->id }}</td>
                            <td class="align-middle">{{ $report->reporter }}<br/><b>{{ $report->name }}</b></td>
                            <td class="align-middle">{{ $report->position }}</td>
                            <td class="align-middle">{{ $report->filial }}</td>
                            <td class="align-middle">{{ number_format($report->getTotalAverage(0), 1) }}</td>
                            <td class="align-middle">{{ number_format($report->getTotalAverage(1), 1) }}</td>
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
