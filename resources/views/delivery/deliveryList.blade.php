@extends('layouts.adminApp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Логин</th>
                    <th>Роль</th>
                    <th>Дата создания</th>
                </tr>
                </thead>
                <tbody>
                <!-- @foreach($clients as $client)
                    <tr>
                        <td><input type="checkbox" data-client-id="{{ $client->id }}" name="destoy-client-{{ $client->id }}" class="js-destroy"/></td>
                        <td><a href="client/{{ $client->id }}"> {{ $client->login }} </a></td>
                        <td>{{ $client->role }}</td>
                        <td>{{ $client->created_at->timezone('Europe/Moscow') }}</td>
                    </tr>
                @endforeach -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
