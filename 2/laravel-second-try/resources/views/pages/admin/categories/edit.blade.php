@extends('layouts.layout')

@section('content')
    @if(session('success'))
        <div class="text-black bg-lime-200 p-4">{{session('message')}}</div>
    @elseif(session('success') === false)
        <div class="text-red-500 bg-red-200 p-4">{{session('message')}}</div>
    @endif

    <form
        class="flex flex-col gap-4 max-w-xl mx-auto"
        action="{{route('admin.categories.update', ['category' => $category])}}"
        method="post"
    >
        @csrf @method('put')
        <h1 class="text-3xl font-bold text-white">Редактирование категории "{{$category->name}}"</h1>

        <x-forms.inputBx
            name="name"
            type="text"
            label="Название"
            value="{{$category->name}}"
        />

        <x-forms.inputBx
            name="description"
            type="text"
            label="Описание"
            value="{{$category->description}}"
        />

        <x-button>Изменить</x-button>
    </form>
@endsection
