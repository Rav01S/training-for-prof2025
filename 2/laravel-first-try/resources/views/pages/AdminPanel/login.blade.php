@extends('layouts.layout')

@section('content')
    <form
        action="{{route('admin.login.store')}}"
        method="post"
        class="flex flex-col gap-4 max-w-xl mx-auto"
    >
        @csrf
        <h1 class="text-3xl text-white">Вход</h1>

        <x-forms.input-bx
            type="email"
            name="email"
            label="Email"
            required
            value="{{old('email')}}"
        />
        <x-forms.input-bx
            type="password"
            name="password"
            label="Пароль"
            required
        />

        <x-button>Войти</x-button>
    </form>
@endsection
