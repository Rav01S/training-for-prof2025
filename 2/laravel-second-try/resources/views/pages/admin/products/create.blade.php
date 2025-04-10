@extends('layouts.layout')

@section('content')
    @if(session('success'))
        <div class="text-black bg-lime-200 p-4">{{session('message')}}</div>
    @elseif(session('success') === false)
        <div class="text-red-500 bg-red-200 p-4">{{session('message')}}</div>
    @endif

    <form
        class="flex flex-col gap-4 max-w-xl mx-auto"
        action="{{route('admin.products.store')}}"
        enctype="multipart/form-data"
        method="post"
    >
        @csrf
        <h1 class="text-3xl font-bold text-white">Добавление товара</h1>

        <x-forms.inputBx
            name="name"
            type="text"
            label="Название"
            value="{{old('name')}}"
            required
        />

        <x-forms.inputBx
            name="description"
            type="text"
            label="Описание"
            value="{{old('description')}}"
            required
        />

        <x-forms.inputBx
            name="price"
            type="text"
            label="Цена"
            value="{{old('price')}}"
            required
        />

        <x-forms.inputBx
            name="category_id"
            type="select"
            :options="$categories"
            label="Категория"
            value="{{old('category_id')}}"
            required
        />

        <x-forms.inputBx
            name="image"
            type="file"
            label="Фото"
            value="{{old('image')}}"
            required
        />

        <x-button>Добавить</x-button>
    </form>
@endsection
