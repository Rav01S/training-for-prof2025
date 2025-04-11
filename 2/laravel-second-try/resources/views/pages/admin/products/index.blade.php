@extends("layouts.layout")

@section("content")
    <h1 class="text-3xl font-bold text-white">Товары</h1>

    <x-button
        class="my-4"
        
        link="{{route('admin.products.create')}}"
    >
        Добавить
    </x-button>

    @if(session('success'))
        <div class="text-black bg-lime-200 p-4">{{session('message')}}</div>
    @elseif(session('success') === false)
        <div class="text-red-500 bg-red-200 p-4">{{session('message')}}</div>
    @endif

    @if(count($products) === 0)
        <p>Здесь пока ещё нет товаров</p>
    @else
        <div class="overflow-x-scroll">
            <table class="w-full">
                <thead>
                <tr>
                    <th class="border-2 border-white px-4 py-2 text-white">ID</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Название</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Описание</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Цена</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Категория</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Фото</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Действия</th>
                </tr>
                </thead>
                <tbody>

                {{-- Пустая строка --}}
                <tr>
                    <td class="h-4"></td>
                </tr>
                {{-- Пустая строка --}}

                @foreach($products as $product)
                    <tr>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$product->id}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$product->name}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$product->description}}</td>
                        <th class="border-2 border-white px-4 py-2 text-white">{{$product->price}}</th>
                        <th class="border-2 border-white px-4 py-2 text-white">{{$product->category()->name}}</th>
                        <th class="border-2 border-white px-4 py-2 text-white">
                            <img class="max-w-40 w-full object-cover max-h-40 h-full" src="{{url($product->image_url)}}" alt="image of product"/>
                        </th>
                        <td class="border-2 border-white px-4 py-2 text-white">
                            <x-form-delete-btn
                                action="{{route('admin.products.destroy', ['product' => $product])}}"/>

                            <x-button 
                                      link="{{route('admin.products.edit', ['product' => $product])}}">Изменить
                            </x-button>
                            <x-button 
                                      link="{{route('admin.products.show', ['product' => $product])}}">Посмотреть
                            </x-button>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    @endif

@endsection
