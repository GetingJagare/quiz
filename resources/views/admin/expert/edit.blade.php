@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if($expert->id)
                            Редактирование члена жюри "{{ $expert->name }}"
                        @else
                            Создание члена жюри
                        @endif
                    </div>

                    <div class="card-body">
                        <form method="POST"
                              action="@if($expert->id){{ route('admin.expert.edit', $expert->id) }}@else{{ route('admin.expert.store') }}@endif">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">ФИО</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ old('name') ?? $expert->name }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Филиал</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('filial') ? ' is-invalid' : '' }}"
                                           name="filial" value="{{ old('filial') ?? $expert->filial }}">
                                    @if ($errors->has('filial'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('filial') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="expert_type" class="col-md-4 col-form-label text-md-right">
                                    Тип голосующего
                                </label>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="expert_type"
                                               id="expert_type0"
                                               value="0" {{ $expert->expert_type == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="expert_type0">
                                            Конкурсная комиссия
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="expert_type"
                                               id="expert_type1" {{ $expert->expert_type == 1 ? 'checked' : '' }}
                                               value="1">
                                        <label class="form-check-label" for="expert_type1">
                                            Эксперты
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="expert_type"
                                               id="expert_type2" {{ $expert->expert_type == 2 ? 'checked' : '' }}
                                               value="2">
                                        <label class="form-check-label" for="expert_type1">
                                            Зрители
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @if($expert->id)
                                            Сохранить
                                        @else
                                            Создать
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
