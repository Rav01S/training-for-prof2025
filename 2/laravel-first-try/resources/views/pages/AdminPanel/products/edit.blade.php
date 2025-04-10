@extends('layouts.layout')

@section('content')
    <form
        action="{{route('admin.products.update', ['product' => $product])}}"
        enctype="multipart/form-data"
        method="post"
        class="flex flex-col gap-4 max-w-xl mx-auto"
    >
        @csrf @method('put')
        <h1 class="text-3xl text-white">Редактирование товара</h1>

        <x-forms.input-bx
            type="text"
            name="name"
            label="Название"
            value="{{$product->name}}"
        />

        <x-forms.input-bx
            type="text"
            name="description"
            label="Описание"
            value="{{$product->description}}"
        />

        <x-forms.input-bx
            type="number"
            name="price"
            label="Цена"
            value="{{$product->price}}"
        />

        <x-forms.input-bx
            type="select"
            :options="$categories"
            name="category_id"
            label="Категория"
            value="{{$product->category_id}}"
        />

        <x-forms.input-bx
            type="file"
            name="image"
            label="Изображение"
        />

        <x-button>Изменить</x-button>
    </form>
@endsection
