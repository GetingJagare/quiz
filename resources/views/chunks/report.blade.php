<div class="center-all">
    @if($report !== null)
        <report-vote-form :report="{{ json_encode($report->toArray()) }}"></report-vote-form>
    @else
        <div style="margin: 0 auto;">
            <h1>Нет активных голосований</h1>
            {{--<p><a href="{{ route('result') }}">Посмотреть результаты</a></p>--}}
        </div>
    @endif
</div>