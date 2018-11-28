@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if($report->id)
                            Редактирование доклада "{{ $report->name }}"
                        @else
                            Создание доклада
                        @endif
                    </div>

                    <div class="card-body">
                        <form method="POST"
                              action="@if($report->id){{ route('admin.report.update', $report->id) }}@else{{ route('admin.report.store') }}@endif">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Название</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ old('name') ?? $report->name }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reporter" class="col-md-4 col-form-label text-md-right">ФИО докладчика</label>
                                <div class="col-md-6">
                                    <input id="reporter" type="text"
                                           class="form-control{{ $errors->has('reporter') ? ' is-invalid' : '' }}"
                                           name="reporter" value="{{ old('reporter') ?? $report->reporter }}" required>
                                    @if ($errors->has('reporter'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('reporter') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position" class="col-md-4 col-form-label text-md-right">Должность докладчика</label>
                                <div class="col-md-6">
                                    <input id="position" type="text"
                                           class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                                           name="position" value="{{ old('position') ?? $report->position }}" required>
                                    @if ($errors->has('position'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="filial" class="col-md-4 col-form-label text-md-right">Филиал</label>
                                <div class="col-md-6">
                                    <input id="filial" type="text"
                                           class="form-control{{ $errors->has('filial') ? ' is-invalid' : '' }}"
                                           name="filial" value="{{ old('filial') ?? $report->filial }}" required>
                                    @if ($errors->has('filial'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('filial') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="from" class="col-md-4 col-form-label text-md-right">С</label>
                                <div class="col-md-6">
                                    <input id="from" type="time"
                                           class="form-control{{ $errors->has('from') ? ' is-invalid' : '' }}"
                                           name="from" value="{{ old('from') ?? $report->from }}" required>
                                    @if ($errors->has('from'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('from') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to" class="col-md-4 col-form-label text-md-right">До</label>
                                <div class="col-md-6">
                                    <input id="to" type="time"
                                           class="form-control{{ $errors->has('to') ? ' is-invalid' : '' }}"
                                           name="to" value="{{ old('to') ?? $report->to }}" required>
                                    @if ($errors->has('to'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('to') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @if($report->id)
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
