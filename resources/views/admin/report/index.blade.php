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
                            <th>ФИО докладчика, наименование работы</th>
                            <th>Средняя оценка конкурсной комиссии</th>
                            <th>Место</th>
                            <th class="text-center" width="80">
                                <a class="btn btn-sm btn-success" href="{{ route('admin.report.create') }}"
                                   role="button"><span class="oi oi-plus" title="Create report"
                                                       aria-hidden="true"></span></a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reports as $i => $report)
                            <tr>
                                <td>{{ $report['id'] }}</td>
                                <td>{{ $report['name'] }}<br><b>{{ $report['reporter'] }}</b></td>
                                <td>{{ $report['avg_count'] }}</td>
                                <td>{{ $i + 1 }}</td>
                                <td class="justify-content-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.report.show', ['id' => $report['id']]) }}"
                                           class="btn btn-success" role="button" target="_blank">
                                            <span class="oi oi-eye" title="Show report" aria-hidden="true"></span>
                                        </a>

                                        <div class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button" style="border-radius: 0"
                                                    id="statusMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Статус
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="statusMenuButton">
                                                <a class="dropdown-item{{ $report['status'] == -1 ? ' active' : '' }}" data-status="1"
                                                   href="#" @click.prevent="setStatus($event, {{ $report['id'] }}, -1)">Не активен</a>
                                                <a class="dropdown-item{{ $report['status'] == 1 ? ' active' : '' }}" data-status="1"
                                                   href="#" @click.prevent="setStatus($event, {{ $report['id'] }}, 1)">Выступление</a>
                                                <a class="dropdown-item{{ $report['status'] == 2 ? ' active' : '' }}" data-status="2"
                                                   href="#" @click.prevent="setStatus($event, {{ $report['id'] }}, 2)">Голосование</a>
                                                <a class="dropdown-item{{ $report['status'] == 3 ? ' active' : '' }}" data-status="3"
                                                   href="#" @click.prevent="setStatus($event, {{ $report['id'] }}, 3)">Результаты голосования</a>
                                            </div>
                                        </div>

                                        <a href="{{ route('admin.report.edit', ['id' => $report['id']]) }}"
                                           class="btn btn-warning" role="button">
                                            <span class="oi oi-pencil" title="Edit report" aria-hidden="true"></span>
                                        </a>
                                        <a class="for-modal btn btn-danger" data-toggle="modal" role="button" href="#"
                                           data-target="#reportModal{{$report['id']}}">
                                            <span class="oi oi-trash" title="Delete report" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                    <div class="modal fade" id="reportModal{{$report['id']}}" tabindex="-1" role="dialog"
                                         aria-labelledby="reportModal{{$report['id']}}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reportModal{{$report['id']}}Label">
                                                        Удаление</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Удалить доклад "{{ $report['name'] }}"?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                        Отмена
                                                    </button>
                                                    <a href="{{ route('admin.report.delete', ['id' => $report['id']]) }}"
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
                    <vue-loading :is-full-page="loadingFullPage" :active.sync="loading" background-color="rgba(0, 0, 0, 0.1)" color="#dcdcdc"></vue-loading>
                </div>
            </div>
        </div>
    </div>
@endsection
