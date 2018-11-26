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
                <p><b>Новизна</b>: {{ $report->getAverageNovelty() }}</p>
                <p><b>Степень проработки</b>: {{ $report->getAverageStudy() }}</p>
                <p><b>Практическая ценность и актуальность</b>: {{ $report->getAverageWorth() }}</p>
                <p><b>Представление доклада</b>: {{ $report->getAverageRepresentation() }}</p>
                <p><b>Экономическая эффективность</b>: {{ $report->getAverageEfficiency() }}</p>
                <p><b>Средняя оценка</b>: {{ $report->getTotalAverage() }}</p>
                <br/>
                <h4>Оценки экспертов</h4>
                <p><b>Новизна</b>: {{ $report->getAverageNovelty(1) }}</p>
                <p><b>Степень проработки</b>: {{ $report->getAverageStudy(1) }}</p>
                <p><b>Практическая ценность и актуальность</b>: {{ $report->getAverageWorth(1) }}</p>
                <p><b>Представление доклада</b>: {{ $report->getAverageRepresentation(1) }}</p>
                <p><b>Экономическая эффективность</b>: {{ $report->getAverageEfficiency(1) }}</p>
                <p><b>Средняя оценка</b>: {{ $report->getTotalAverage(1) }}</p>
                <br/>
                <h4>Средняя оценка жюри и
                    экспертов: {{ $report->getAllTotalAverage() }}</h4>
                <br/>
                <h4>Оценка зрителей: {{ $report->getAverageMark() }}</h4>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        setTimeout(function () {
            location.reload();
        }, 5000);
    </script>
@endsection
