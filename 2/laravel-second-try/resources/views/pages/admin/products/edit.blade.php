@extends('layouts.layout')

@section('content')
    @if(session('success'))
        <div class="text-black bg-lime-200 p-4">{{session('message')}}</div>
    @elseif(session('success') === false)
        <div class="text-red-500 bg-red-200 p-4">{{session('message')}}</div>
    @endif

    <form
        class="flex flex-col gap-4 max-w-xl mx-auto"
        action="{{route('admin.products.update', ['product' => $product])}}"
        enctype="multipart/form-data"
        method="post"
    >
        @csrf @method('put')
        <h1 class="text-3xl font-bold text-white">Редактирование товара "{{$product->name}}"</h1>

        <x-forms.inputBx
            name="name"
            type="text"
            label="Название"
            value="{{$product->name}}"
        />

        <x-forms.inputBx
            name="description"
            type="text"
            label="Описание"
            value="{{$product->description}}"
        />

        <x-forms.inputBx
            name="price"
            type="text"
            label="Цена"
            value="{{$product->price}}"
        />

        <x-forms.inputBx
            name="category_id"
            type="select"
            :options="$categories"
            label="Категория"
            value="{{$product->category_id}}"
        />

        <x-forms.inputBx
            name="image"
            type="file"
            label="Фото"
            value="{{$product->image}}"
        />

        <x-button>Изменить</x-button>
    </form>
@endsection
