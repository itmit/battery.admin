@extends('layouts.adminApp')

@section('content')
    <h1>Создание продавца</h1>
    <div class="col-sm-12">
        <form class="form-horizontal" method="POST" action="{{ route('auth.storeSeller') }}">
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

            <div class="form-group{{ $errors->has('dealer') ? ' has-error' : '' }}">
                    <label for="login" class="col-md-4 control-label">Дилер</label>
    
                    <div class="col-md-6">

                        <select name="dealer" id="dealer">

                            @foreach($dealers as $dealer)
                                <option value="{{ $dealer->id }}">{{ $dealer->login }}</option>
                            @endforeach

                        </select>
    
                        @if ($errors->has('dealer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dealer') }}</strong>
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