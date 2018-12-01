@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <h1>Доклады</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Название</th>
                            <th>ФИО докладчика</th>
                            <th>Должность</th>
                            <th>Филиал</th>
                            <th>С</th>
                            <th>До</th>
                            <th class="text-center" width="80">
                                <a class="btn btn-sm btn-success" href="{{ route('admin.report.create') }}"
                                   role="button"><span class="oi oi-plus" title="Create report"
                                                       aria-hidden="true"></span></a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->reporter }}</td>
                                <td>{{ $report->position }}</td>
                                <td>{{ $report->filial }}</td>
                                <td>{{ $report->from->format('H:i d.m.Y') }}</td>
                                <td>{{ $report->to->format('H:i d.m.Y') }}</td>
                                <td class="justify-content-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.report.show', ['id' => $report->id]) }}"
                                           class="btn btn-success" role="button" target="_blank">
                                            <span class="oi oi-eye" title="Show report" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('admin.report.toggle', ['id' => $report->id]) }}"
                                           class="btn {{ $report->active ? 'btn-success' : 'btn-danger' }}"
                                           role="button">
                                        <span class="oi {{ $report->active ? 'oi-check' : 'oi-x' }}"
                                              title="{{ $report->active ? 'Disable' : 'Enable' }} report"
                                              aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('admin.report.edit', ['id' => $report->id]) }}"
                                           class="btn btn-warning" role="button">
                                            <span class="oi oi-pencil" title="Edit report" aria-hidden="true"></span>
                                        </a>
                                        <a class="for-modal btn btn-danger" data-toggle="modal" role="button" href="#"
                                           data-target="#reportModal{{$report->id}}">
                                            <span class="oi oi-trash" title="Delete report" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                    <div class="modal fade" id="reportModal{{$report->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="reportModal{{$report->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reportModal{{$report->id}}Label">
                                                        Удаление</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Удалить доклад "{{ $report->name }}"?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                        Отмена
                                                    </button>
                                                    <a href="{{ route('admin.report.delete', ['id' => $report->id]) }}"
                                                       class="btn btn-primary">Удалить</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Не создано ни одного доклада</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
