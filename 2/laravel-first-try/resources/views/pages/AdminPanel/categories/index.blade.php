@extends('layouts.layout')

@section('content')
    <h1 class="text-white text-3xl mb-4">Категории</h1>
    <x-button class="mb-4" isLink="true" link="{{route('admin.categories.create')}}">Добавить</x-button>

    @if(session('success'))
        <div class="bg-lime-200 text-black p-4">{{session('message')}}</div>
    @elseif(session('success') === false)
        <div class="bg-red-200 text-white p-4">{{session('message')}}</div>
    @endif

    <div class="overflow-x-scroll">
        @if(count($categories->get()) === 0)
            <p>Нет категорий</p>
        @else
            <table class="w-full">
                <thead>
                <tr>
                    <th class="border-2 border-white p-2 text-white">ID</th>
                    <th class="border-2 border-white p-2 text-white">Название</th>
                    <th class="border-2 border-white p-2 text-white">Описание</th>
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
                @foreach($categories->get() as $category)
                    <tr>
                        <td class="border-2 border-white p-2 text-white">{{$category->id}}</td>
                        <td class="border-2 border-white p-2 text-white">{{$category->name}}</td>
                        <td class="border-2 border-white p-2 text-white">{{$category->description}}</td>
                        <td class="border-2 border-white p-2 text-white">
                            @if(!$category->products()->exists())
                                <x-delete-form-btn
                                    class="m-1 inline-block"
                                    action="{{route('admin.categories.destroy', ['category' => $category])}}"
                                />
                            @endif
                            <x-button
                                class="m-1 inline-block"
                                isLink="true"
                                link="{{route('admin.categories.edit', ['category' => $category->id])}}"
                            >
                                Редактировать
                            </x-button>
                            <x-button
                                class="m-1 inline-block"
                                class="bg-lime-200 !text-black"
                                isLink="true"
                                link="{{route('admin.categories.show', ['category' => $category->id])}}"
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
    {{$categories->paginate(5)}}
@endsection
