@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <h1>Члены жюри</h1>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th>ФИО</th>
                        <th>Ссылка</th>
                        <th class="text-center" width="80">
                            <a class="btn btn-sm btn-success" href="{{ route('admin.expert.create') }}"
                               role="button"><span class="oi oi-plus" title="Create expert"
                                                   aria-hidden="true"></span></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($experts as $expert)
                        <tr>
                            <td>{{ $expert->id }}</td>
                            <td>{{ $expert->name }}</td>
                            <td>{{ route('signin.byToken', $expert->token) }}</td>
                            <td class="justify-content-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.expert.edit', ['id' => $expert->id]) }}"
                                       class="btn btn-warning" role="button">
                                        <span class="oi oi-pencil" title="Edit expert" aria-hidden="true"></span>
                                    </a>
                                    <a class="for-modal btn btn-danger" data-toggle="modal" role="button" href="#"
                                       data-target="#expertModal{{$expert->id}}">
                                        <span class="oi oi-trash" title="Delete expert" aria-hidden="true"></span>
                                    </a>
                                </div>
                                <div class="modal fade" id="expertModal{{$expert->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="expertModal{{$expert->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="expertModal{{$expert->id}}Label">
                                                    Удаление</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Удалить члена жюри "{{ $expert->name }}"?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Отмена
                                                </button>
                                                <a href="{{ route('admin.expert.delete', ['id' => $expert->id]) }}"
                                                   class="btn btn-primary">Удалить</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Не создано ни одного члена жюри</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
