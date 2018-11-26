@extends('layouts.web')

@section('content')
    <div class="center-all">
        @if($report !== null)
            <div style="margin: 0 auto;">
                <h1>{{ $report->name }}</h1>
                <h3>{{ $report->reporter }}<br/>
                    {{ $report->position }}, {{ $report->filial }}</h3>
                @if($user->is_expert)
                    <p>&nbsp;</p>
                    <form method="POST" action="{{ route('markExpert', $report->id) }}">
                        @csrf
                        <p>Новизна:</p>
                        <div class="form-group">
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info">
                                        <input type="radio" name="novelty" id="novelty{{ $i }}" autocomplete="off"
                                               value="{{ $i }}"> {{ $i }}
                                    </label>
                                </div>
                            @endfor
                            @if ($errors->has('novelty'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('novelty') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <p>Степень проработки:</p>
                        <div class="form-group">
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info">
                                        <input type="radio" name="study" id="study{{ $i }}" autocomplete="off"
                                               value="{{ $i }}"> {{ $i }}
                                    </label>
                                </div>
                            @endfor
                            @if ($errors->has('study'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('study') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <p>Практическая ценность и актуальность:</p>
                        <div class="form-group">
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info">
                                        <input type="radio" name="worth" id="worth{{ $i }}" autocomplete="off"
                                               value="{{ $i }}"> {{ $i }}
                                    </label>
                                </div>
                            @endfor
                            @if ($errors->has('worth'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('worth') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <p>Представление доклада:</p>
                        <div class="form-group">
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info">
                                        <input type="radio" name="representation" id="representation{{ $i }}"
                                               autocomplete="off"
                                               value="{{ $i }}"> {{ $i }}
                                    </label>
                                </div>
                            @endfor
                            @if ($errors->has('representation'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('representation') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <p>Экономическая эффективность:</p>
                        <div class="form-group">
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info">
                                        <input type="radio" name="efficiency" id="efficiency{{ $i }}" autocomplete="off"
                                               value="{{ $i }}"> {{ $i }}
                                    </label>
                                </div>
                            @endfor
                            @if ($errors->has('efficiency'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('efficiency') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button class="btn btn-success">Оценить</button>
                    </form>
                @else
                    <p>&nbsp;</p>
                    <p>Ваша оценка:</p>
                    <form method="POST" action="{{ route('mark', $report->id) }}">
                        @csrf
                        <div class="form-group">
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info">
                                        <input type="radio" name="mark" id="mark{{ $i }}" autocomplete="off"
                                               value="{{ $i }}"> {{ $i }}
                                    </label>
                                </div>
                            @endfor
                            @if ($errors->has('mark'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('mark') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button class="btn btn-success">Оценить</button>
                    </form>
                @endif
            </div>
        @elseif($result)
            <div style="margin: 0 auto;">
                <h1>Спасибо за оценку!</h1>
                {{--<p><a href="{{ route('result') }}">Посмотреть результаты</a></p>--}}
            </div>
        @else
            <div style="margin: 0 auto;">
                <h1>Нет активных голосований</h1>
                {{--<p><a href="{{ route('result') }}">Посмотреть результаты</a></p>--}}
            </div>
        @endif
    </div>
@endsection
