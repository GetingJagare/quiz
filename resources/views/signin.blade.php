@extends('layouts.web')

@section('content')
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('signup') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label text-md-right">ФИО</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text"
                                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   name="name" value="{{ old('name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="filial" class="col-md-4 col-form-label text-md-right">Филиал</label>

                                        <div class="col-md-6">
                                            <input id="filial" type="text"
                                                   class="form-control{{ $errors->has('filial') ? ' is-invalid' : '' }}"
                                                   name="filial" required>

                                            @if ($errors->has('filial'))
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('filial') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Войти
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
