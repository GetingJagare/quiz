@extends('layouts.web')

@section('content')
    <div class="center-all">
        <div style="margin: 0 auto;">
            <div>
                <h1>{{ $report->name }}</h1>
                <h2>{{ $report->reporter }}</h2>
                <h3>{{ $report->position }}, {{ $report->filial }}</h3>
                <br/>
                <h4>Оценки конкурсной комиссии</h4>
                <p><b>Новизна</b>: {{ number_format($report->getAverageNovelty(), 1) }}</p>
                <p><b>Степень проработки</b>: {{ number_format($report->getAverageStudy(), 1) }}</p>
                <p><b>Практическая ценность и актуальность</b>: {{ number_format($report->getAverageWorth(), 1) }}</p>
                <p><b>Представление доклада</b>: {{ number_format($report->getAverageRepresentation(), 1) }}</p>
                <p><b>Экономическая эффективность</b>: {{ number_format($report->getAverageEfficiency(), 1) }}</p>
                <p><b>Средняя оценка</b>: {{ number_format($report->getTotalAverage(), 1) }}</p>
                <br/>
                <h4>Оценки экспертов</h4>
                <p><b>Новизна</b>: {{ number_format($report->getAverageNovelty(1), 1) }}</p>
                <p><b>Степень проработки</b>: {{ number_format($report->getAverageStudy(1), 1) }}</p>
                <p><b>Практическая ценность и актуальность</b>: {{ number_format($report->getAverageWorth(1), 1) }}</p>
                <p><b>Представление доклада</b>: {{ number_format($report->getAverageRepresentation(1), 1) }}</p>
                <p><b>Экономическая эффективность</b>: {{ number_format($report->getAverageEfficiency(1), 1) }}</p>
                <p><b>Средняя оценка</b>: {{ number_format($report->getTotalAverage(1), 1) }}</p>
                <br/>
                <h4>Средняя оценка жюри и
                    экспертов: {{ number_format(($report->getTotalAverage() + $report->getTotalAverage(1))/2, 1) }}</h4>
                <br/>
                <h4>Оценка зрителей: {{ number_format($report->getAverageMark(), 1) }}</h4>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        setTimeout(function () {
            location.reload();
        }, 5000);
    </script>
@endsection
