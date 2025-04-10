@extends('layouts.layout')

@section('content')
    <h1 class="text-white text-3xl mb-4">Товары</h1>
    <x-button class="mb-4" isLink="true" link="{{route('admin.products.create')}}">Добавить</x-button>

    @if(session('success'))
        <div class="bg-lime-200 text-black p-4">{{session('message')}}</div>
    @elseif(session('success') === false)
        <div class="bg-red-200 text-white p-4">{{session('message')}}</div>
    @endif

    <div class="overflow-x-scroll">
        <table class="w-full">
            <thead>
            <tr>
                <th class="border-2 border-white p-2 text-white">ID</th>
                <th class="border-2 border-white p-2 text-white">Название</th>
                <th class="border-2 border-white p-2 text-white">Описание</th>
                <th class="border-2 border-white p-2 text-white">Категория</th>
                <th class="border-2 border-white p-2 text-white">Цена</th>
                <th class="border-2 border-white p-2 text-white">Изображение</th>
                <th class="border-2 border-white p-2 text-white">Действия</th>
            </tr>
            </thead>
            <tbody>
            {{-- Пустая строка --}}
            <tr>
                <td class="h-3"></td>
                <td class="h-3"></td>
                <td class="h-3"></td>
                <td class="h-3"></td>
                <td class="h-3"></td>
                <td class="h-3"></td>
                <td class="h-3"></td>
            </tr>
            {{-- Пустая строка --}}
            @foreach($products as $product)
                <tr>
                    <td class="border-2 border-white p-2 text-white">{{$product->id}}</td>
                    <td class="border-2 border-white p-2 text-white">{{$product->name}}</td>
                    <td class="border-2 border-white p-2 text-white">{{$product->description}}</td>
                    <td class="border-2 border-white p-2 text-white">{{$product->category()->first()->name}}</td>
                    <td class="border-2 border-white p-2 text-white">{{$product->price}}</td>
                    <td class="border-2 border-white p-2 text-white">
                        <a href="{{url($product->image_url)}}">{{url($product->image_url)}}</a>
                    </td>
                    <td class="border-2 border-white p-2 text-white">
                        <x-delete-form-btn
                            class="m-1 inline-block"
                            action="{{route('admin.products.destroy', ['product' => $product])}}"
                        />
                        <x-button
                            class="m-1 inline-block"
                            isLink="true"
                            link="{{route('admin.products.edit', ['product' => $product->id])}}"
                        >
                            Редактировать
                        </x-button>
                        <x-button
                            class="m-1 inline-block"
                            class="bg-lime-200 !text-black"
                            isLink="true"
                            link="{{route('admin.products.show', ['product' => $product->id])}}"
                        >
                            Посмотреть
                        </x-button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
