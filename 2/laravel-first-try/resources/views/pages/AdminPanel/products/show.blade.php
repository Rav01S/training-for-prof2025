@extends('layouts.layout')

@section('content')
    <form
        enctype="multipart/form-data"
        class="flex flex-col gap-4 max-w-xl mx-auto"
    >
        <h1 class="text-3xl text-white">Товар {{$product->name}}</h1>

        <x-forms.input-bx
            type="text"
            name="name"
            label="Название"
            value="{{$product->name}}"
            disabled
        />

        <x-forms.input-bx
            type="text"
            name="description"
            label="Описание"
            value="{{$product->description}}"
            disabled
        />

        <x-forms.input-bx
            type="number"
            name="price"
            label="Цена"
            value="{{$product->price}}"
            disabled
        />

        <x-forms.input-bx
            type="select"
            :options="$categories"
            name="category_id"
            label="Категория"
            value="{{$product->category_id}}"
            disabled
        />

        <img src="{{url($product->image_url)}}" alt="product image">
    </form>
@endsection
