@extends('layouts.layout')

@section('content')
    <form
        action="{{route('admin.categories.store')}}"
        method="post"
        class="flex flex-col gap-4 max-w-xl mx-auto"
    >
        @csrf
        <h1 class="text-3xl text-white">Добавление категории</h1>

        <x-forms.input-bx
            type="text"
            name="name"
            label="Название"
            value="{{old('name')}}"
            required
        />

        <x-forms.input-bx
            type="text"
            name="description"
            label="Описание"
            value="{{old('description')}}"
            required
        />

        <x-button>Добавить</x-button>
    </form>
@endsection
