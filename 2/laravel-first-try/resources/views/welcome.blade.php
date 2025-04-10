@extends('layouts.layout')

@section('content')
    <h1 class="text-3xl text-white mb-4">Это главная страница</h1>
    <x-button isLink="true" link="{{route('admin.login.index')}}">Войти в админ панель</x-button>
@endsection
