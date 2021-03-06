@extends('layouts.adminApp')

@section('content')
    <h1>Создание клиента</h1>
    <div class="col-sm-12">
        <form class="form-horizontal" method="POST" action="{{ route('auth.client.store') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                <label for="login" class="col-md-4 control-label">Логин</label>

                <div class="col-md-6">
                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required
                           autofocus>

                    @if ($errors->has('login'))
                        <span class="help-block">
                            <strong>{{ $errors->first('login') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                <label for="role" class="col-md-4 control-label">Роль</label>

                <div class="col-md-6">

                    <select name="role" id="role">
                        <option value="stockman">Кладовщик</option>
                        <option value="dealer">Дилер</option>
                        <option value="seller">Продавец</option>
                    </select>

                    @if ($errors->has('role'))
                        <span class="help-block">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Пароль</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label">Повторите пароль</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Создать клиента
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection