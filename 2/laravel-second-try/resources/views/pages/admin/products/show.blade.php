@extends('layouts.layout')

@section('content')
    @if(session('success'))
        <div class="text-black bg-lime-200 p-4">{{session('message')}}</div>
    @elseif(session('success') === false)
        <div class="text-red-500 bg-red-200 p-4">{{session('message')}}</div>
    @endif

    <form
        class="flex flex-col gap-4 max-w-xl mx-auto"
    >
        <h1 class="text-3xl font-bold text-white">Товар "{{$product->name}}"</h1>

        <x-forms.inputBx
            name="name"
            type="text"
            label="Название"
            value="{{$product->name}}"
            disabled
        />

        <x-forms.inputBx
            name="description"
            type="text"
            label="Описание"
            value="{{$product->description}}"
            disabled
        />

        <x-forms.inputBx
            name="price"
            type="text"
            label="Цена"
            value="{{$product->price}}"
            disabled
        />

        <x-forms.inputBx
            name="category_id"
            type="select"
            :options="$categories"
            label="Категория"
            value="{{$product->category_id}}"
            disabled
        />

        <img src="{{url($product->image_url)}}" alt="image of product">
    </form>
@endsection
