@extends('layouts.app')

@section('content')
    <div class="center-all">
        <div class="report-page">
            <div>
                <h1>{{ $report->name }}</h1>
                <h2>{{ $report->reporter }}</h2>
                <h3>{{ $report->position }}, {{ $report->filial }}</h3>
                <br/>

                <report-page id="{{ $report->id }}"></report-page>

                {{--<h4>Оценка конкурсной комиссии <span style="font-size: 150%; font-weight: 700;">{{ $report->getTotalAverage() }}</span></h4>--}}
                {{--<p><b>Новизна</b>: {{ $report->getAverageNovelty() }}</p>
                <p><b>Степень проработки</b>: {{ $report->getAverageStudy() }}</p>
                <p><b>Практическая ценность и актуальность</b>: {{ $report->getAverageWorth() }}</p>
                <p><b>Представление доклада</b>: {{ $report->getAverageRepresentation() }}</p>
                <p><b>Экономическая эффективность</b>: {{ $report->getAverageEfficiency() }}</p>
                <p><b>Средняя оценка</b>: {{ $report->getTotalAverage() }}</p>
                <br/>
                <h4>Оценка экспертов <span style="font-size: 150%; font-weight: 700;">{{ $report->getTotalAverage(1) }}</span></h4>
                {{--<p><b>Новизна</b>: {{ $report->getAverageNovelty(1) }}</p>
                <p><b>Степень проработки</b>: {{ $report->getAverageStudy(1) }}</p>
                <p><b>Практическая ценность и актуальность</b>: {{ $report->getAverageWorth(1) }}</p>
                <p><b>Представление доклада</b>: {{ $report->getAverageRepresentation(1) }}</p>
                <p><b>Экономическая эффективность</b>: {{ $report->getAverageEfficiency(1) }}</p>
                <p><b>Средняя оценка</b>: {{ $report->getTotalAverage(1) }}</p>
                <br/>
                <h4>Средняя оценка жюри и
                    экспертов: <span style="font-size: 150%; font-weight: 700;">{{ $report->getAllTotalAverage() }}</span></h4>
                <br/>
                <h4>Оценка зрителей: <span style="font-size: 150%; font-weight: 700;">{{ $report->getAverageMark() }}</span></h4>--}}
            </div>
        </div>
    </div>

@endsection
