@extends('layouts.layout')

@section('content')
    <form
        class="flex flex-col gap-4 max-w-xl mx-auto"
        action="{{route('admin.login.store')}}"
        method="post"
    >
        @csrf
        <h1 class="text-3xl font-bold text-white">Вход</h1>

        <x-forms.inputBx
            name="email"
            type="email"
            label="Email"
            required
        />

        <x-forms.inputBx
            name="password"
            type="password"
            label="Пароль"
            required
        />

        <x-button>Войти</x-button>
    </form>
@endsection
