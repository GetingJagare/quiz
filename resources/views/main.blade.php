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
                        <div class="form-group" style="position:relative;display:inline-block;">
                            <a href="#"
                               style="border: 1px solid #3490dc;border-radius: 50%;display: inline-block;width: 25px;height: 25px;position: absolute;top: 50%;left: -30px;line-height: 25px;transform: translateY(-50%);"
                               data-toggle="modal"
                               data-target="#noveltyModal">i</a>
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn @if(old('novelty') && old('novelty') == $i) btn-success @else btn-info @endif">
                                        <input type="radio" name="novelty" id="novelty{{ $i }}" autocomplete="off"
                                               @if(old('novelty') && old('novelty') == $i) checked @endif
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
                        <div class="form-group" style="position:relative;display:inline-block;">
                            <a href="#"
                               style="border: 1px solid #3490dc;border-radius: 50%;display: inline-block;width: 25px;height: 25px;position: absolute;top: 50%;left: -30px;line-height: 25px;transform: translateY(-50%);"
                               data-toggle="modal"
                               data-target="#studyModal">i</a>
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn @if(old('study') && old('study') == $i) btn-success @else btn-info @endif">
                                        <input type="radio" name="study" id="study{{ $i }}" autocomplete="off"
                                               @if(old('study') && old('study') == $i) checked @endif
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
                        <div class="form-group" style="position:relative;display:inline-block;">
                            <a href="#"
                               style="border: 1px solid #3490dc;border-radius: 50%;display: inline-block;width: 25px;height: 25px;position: absolute;top: 50%;left: -30px;line-height: 25px;transform: translateY(-50%);"
                               data-toggle="modal"
                               data-target="#worthModal">i</a>
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn @if(old('worth') && old('worth') == $i) btn-success @else btn-info @endif">
                                        <input type="radio" name="worth" id="worth{{ $i }}" autocomplete="off"
                                               @if(old('worth') && old('worth') == $i) checked @endif
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
                        <div class="form-group" style="position:relative;display:inline-block;">
                            <a href="#"
                               style="border: 1px solid #3490dc;border-radius: 50%;display: inline-block;width: 25px;height: 25px;position: absolute;top: 50%;left: -30px;line-height: 25px;transform: translateY(-50%);"
                               data-toggle="modal"
                               data-target="#representationModal">i</a>
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn @if(old('representation') && old('representation') == $i) btn-success @else btn-info @endif">
                                        <input type="radio" name="representation" id="representation{{ $i }}"
                                               autocomplete="off"
                                               @if(old('representation') && old('representation') == $i) checked @endif
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
                        <div class="form-group" style="position:relative;display:inline-block;">
                            <a href="#"
                               style="border: 1px solid #3490dc;border-radius: 50%;display: inline-block;width: 25px;height: 25px;position: absolute;top: 50%;left: -30px;line-height: 25px;transform: translateY(-50%);"
                               data-toggle="modal"
                               data-target="#efficiencyModal">i</a>
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn @if(old('efficiency') && old('efficiency') == $i) btn-success @else btn-info @endif">
                                        <input type="radio" name="efficiency" id="efficiency{{ $i }}" autocomplete="off"
                                               @if(old('efficiency') && old('efficiency') == $i) checked @endif
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
                        <button class="btn btn-success" style="display:block;margin:0 auto;">Оценить</button>
                    </form>
                    <div class="modal fade" id="noveltyModal" tabindex="-1" role="dialog"
                         aria-labelledby="noveltyModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="noveltyModalTitle">Новизна разработки</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <p>При определении оценки по данному критерию учитывается наличие аналогичных
                                        разработок:</p>
                                    <ul>
                                        <li>5 баллов – аналогичные разработки отсутствуют;</li>
                                        <li>3-4 балла – имеются аналогичные разработки с худшими показателями;</li>
                                        <li>1-2 балла – имеются аналогичные разработки с аналогичными показателями;</li>
                                        <li>0 баллов – имеются аналогичные разработки с лучшими показателями.</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="studyModal" tabindex="-1" role="dialog"
                         aria-labelledby="studyModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="studyModalTitle">Степень проработки темы</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <p>При определении оценки по данному критерию учитывается степень подготовки
                                        материалов работы:</p>
                                    <ul>
                                        <li>5 баллов – работа качественно подготовлена, снабжена большим количеством
                                            подготовленных иллюстративных материалов и доказательствами результатов
                                            экспериментов.
                                        </li>
                                        <li>3-4 балла – работа хорошо подготовлена, однако количество и качество
                                            иллюстративного материала и доказательств проведенных экспериментов
                                            недостаточно. Необходимо проиллюстрировать некоторые положения работы.
                                        </li>
                                        <li>1-2 балла – работа подготовлена с существенными недостатками, мало
                                            иллюстративного материала или низкое качество иллюстративного материала,
                                            отсутствует экспериментальное подтверждение результатов и т.д.
                                        </li>
                                        <li>0 баллов – по тексту работы не понятно ее содержание, иллюстративный
                                            материал полностью отсутствует.
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="representationModal" tabindex="-1" role="dialog"
                         aria-labelledby="representationModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="representationModalTitle">Представление доклада</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <p>При определении оценки по данному критерию учитывается «ораторское мастерство»
                                        докладчика:</p>
                                    <ul>
                                        <li>5 баллов – работа доложена уверенно, без запинок, заданные вопросы не
                                            вызвали затруднений, были даны полные уверенные ответы.
                                        </li>
                                        <li>3-4 балла – работа была доложена уверенно, однако было допущено небольшое
                                            количество запинок, заданные вопросы не вызвали запинок и затруднений с
                                            ответом.
                                        </li>
                                        <li>1-2 балла – работа была доложена неуверенно, с запинками, заданные вопросы
                                            вызвали затруднения.
                                        </li>
                                        <li>0 баллов – очевидна скованность докладчика перед аудиторией, доклад не
                                            внятен, сделан с постоянными запинками, докладчик не смог ответить на
                                            вопросы.
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="worthModal" tabindex="-1" role="dialog"
                         aria-labelledby="worthModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="worthModalTitle">Практическая ценность и актуальность
                                        работы</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <p>При определении оценки по данному критерию учитывается реализуемость
                                        разработки:</p>
                                    <ul>
                                        <li>5 баллов - работа уже реализована и актуальна.</li>
                                        <li>3-4 балла – работа актуальна, может быть внедрена в ближайшее время или
                                            после доработки.
                                        </li>
                                        <li>1-2 балла – работа может быть реализована через продолжительный интервал
                                            времени и после доработки.
                                        </li>
                                        <li>0 баллов – работа не реализуема либо внедрение разработки нецелесообразно.
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="efficiencyModal" tabindex="-1" role="dialog"
                         aria-labelledby="efficiencyModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="efficiencyModalTitle">Экономический эффект</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <ul>
                                        <li>5 баллов – работа экономически эффективна и есть доказательства.</li>
                                        <li>3-4 балла – работа может быть экономически эффективна после ее доработки.
                                        </li>
                                        <li>1-2 балла – работа малоэффективна, но возможна или экономически не
                                            эффективна в настоящее время.
                                        </li>
                                        <li>0 баллов – работа не реализуема в настоящее время и экономически не
                                            обоснована.
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        var arr = ['novelty', 'study', 'representation', 'worth', 'efficiency'];
                        for (i = 0; i < arr.length; i++) {
                            document.getElementsByName(arr[i]).forEach(function (element, index) {
                                !function (name, i) {
                                    document.getElementById(name + i).parentNode.addEventListener("click", function () {
                                        document.getElementsByName(name).forEach(function (el, ind) {
                                            if (ind !== index) {
                                                el.parentNode.classList.remove('active');
                                                el.parentNode.classList.remove('btn-success');
                                                el.parentNode.classList.add('btn-info');
                                            } else {
                                                el.parentNode.classList.add('active');
                                                el.parentNode.classList.add('btn-success');
                                                el.parentNode.classList.remove('btn-info');
                                            }
                                        });
                                    });
                                }(arr[i], index);
                            });
                        }
                    </script>
                @else
                    <p>&nbsp;</p>
                    <p>Ваша оценка:</p>
                    <form method="POST" action="{{ route('mark', $report->id) }}">
                        @csrf
                        <div class="form-group">
                            @for($i = 0; $i <= 5; $i++)
                                <div class="btn-group btn-group-lg btn-group-toggle" data-toggle="buttons">
                                    <label class="btn @if(old('mark') && old('mark') == $i) btn-success @else btn-info @endif">
                                        <input type="radio" name="mark" id="mark{{ $i }}" autocomplete="off"
                                               @if(old('mark') && old('mark') == $i) checked @endif
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
                    <script type="text/javascript">
                        document.getElementsByName('mark').forEach(function (element, index) {
                            document.getElementById("mark" + index).parentNode.addEventListener("click", function () {
                                document.getElementsByName('mark').forEach(function (el, ind) {
                                    if (ind !== index) {
                                        el.parentNode.classList.remove('active');
                                        el.parentNode.classList.remove('btn-success');
                                        el.parentNode.classList.add('btn-info');
                                    } else {
                                        el.parentNode.classList.add('active');
                                        el.parentNode.classList.add('btn-success');
                                        el.parentNode.classList.remove('btn-info');
                                    }
                                });
                            });
                        });
                    </script>
                @endif
            </div>
        @elseif($result)
            <div style="margin: 0 auto;">
                <h1>Спасибо за оценку!</h1>
                @if($resultMark)
                    <p>
                        @if($user->is_expert)
                            <b>Ваша средняя оценка</b>
                            : {{ number_format(($resultMark->novelty + $resultMark->study + $resultMark->worth + $resultMark->representation + $resultMark->efficiency) / 5, 1) }}
                        @else
                            <b>Ваша оценка</b>
                            : {{ $resultMark->mark }}
                        @endif
                    </p>
                @endif
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
