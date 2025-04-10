@extends('layouts.layout')

@section('content')
    <form
        action="{{route('admin.products.store')}}"
        enctype="multipart/form-data"
        method="post"
        class="flex flex-col gap-4 max-w-xl mx-auto"
    >
        @csrf
        <h1 class="text-3xl text-white">Добавление товара</h1>

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

        <x-forms.input-bx
            type="number"
            name="price"
            label="Цена"
            value="{{old('price')}}"
            required
        />

        <x-forms.input-bx
            type="select"
            :options="$categories"
            name="category_id"
            label="Категория"
            value="{{old('category_id')}}"
            required
        />

        <x-forms.input-bx
            type="file"
            name="image"
            label="Изображение"
            value="{{old('image')}}"
            required
        />

        <x-button>Добавить</x-button>
    </form>
@endsection
