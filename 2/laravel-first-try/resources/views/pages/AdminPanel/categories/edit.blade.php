@extends('layouts.layout')

@section('content')
    <form
        action="{{route('admin.categories.update', ['category' => $category])}}"
        method="post"
        class="flex flex-col gap-4 max-w-xl mx-auto"
    >
        @csrf @method('put')
        <h1 class="text-3xl text-white">Редактирование категории</h1>

        <x-forms.input-bx
            type="text"
            name="name"
            label="Название"
            value="{{$category->name}}"
            required
        />

        <x-forms.input-bx
            type="text"
            name="description"
            label="Описание"
            value="{{$category->description}}"
            required
        />

        <x-button>Изменить</x-button>
    </form>
@endsection
