@extends('layouts.layout')

@section('content')
    <h1 class="text-white text-3xl mb-4">Просмотр категории "{{$category->name}}"</h1>

    <div class="overflow-x-scroll">
        @if(count($category->products()->get()) === 0)
            <p>Нет товаров с этой категорией</p>
        @else
            <table class="w-full">
                <thead>
                <tr>
                    <th class="border-2 border-white p-2 text-white">ID</th>
                    <th class="border-2 border-white p-2 text-white">Название</th>
                    <th class="border-2 border-white p-2 text-white">Цена</th>
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
                </tr>
                {{-- Пустая строка --}}
                @foreach($category->products()->get() as $product)
                    <tr>
                        <td class="border-2 border-white p-2 text-white">{{$product->id}}</td>
                        <td class="border-2 border-white p-2 text-white">{{$product->name}}</td>
                        <td class="border-2 border-white p-2 text-white">{{$product->description}}</td>
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
        @endif
    </div>
@endsection
