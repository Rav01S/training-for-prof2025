@extends("layouts.layout")

@section("content")
    <h1 class="text-3xl font-bold text-white">Товары категории "{{$category->name}}"</h1>

    @if(!$category->products()->exists())
        <p>Здесь пока ещё нет товаров</p>
    @else
        <div class="overflow-x-scroll">
            <table class="w-full">
                <thead>
                <tr>
                    <th class="border-2 border-white px-4 py-2 text-white">ID</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Название</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Цена</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Действия</th>
                </tr>
                </thead>
                <tbody>

                {{-- Пустая строка --}}
                <tr>
                    <td class="h-4"></td>
                </tr>
                {{-- Пустая строка --}}

                @foreach($category->products()->get() as $product)
                    <tr>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$product->id}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$product->name}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$product->price}}</td>
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
