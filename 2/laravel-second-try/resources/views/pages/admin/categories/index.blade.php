@extends("layouts.layout")

@section("content")
    <h1 class="text-3xl font-bold text-white">Категории</h1>

    <x-button
            class="my-4"
            
            link="{{route('admin.categories.create')}}"
    >
        Добавить
    </x-button>

    @if(session('success'))
        <div class="text-black bg-lime-200 p-4">{{session('message')}}</div>
    @elseif(session('success') === false)
        <div class="text-red-500 bg-red-200 p-4">{{session('message')}}</div>
    @endif

    @if(count($categories->get()) === 0)
        <p>Здесь пока ещё нет категорий</p>
    @else
        <div class="overflow-x-scroll">
            <table class="w-full">
                <thead>
                <tr>
                    <th class="border-2 border-white px-4 py-2 text-white">ID</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Название</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Описание</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Действия</th>
                </tr>
                </thead>
                <tbody>

                {{-- Пустая строка --}}
                <tr>
                    <td class="h-4"></td>
                </tr>
                {{-- Пустая строка --}}

                @foreach($categories->get() as $category)
                    <tr>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$category->id}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$category->name}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$category->description}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">
                            @if(!$category->products()->exists())
                                <x-form-delete-btn
                                        action="{{route('admin.categories.destroy', ['category' => $category])}}"/>
                            @endif

                            <x-button 
                                      link="{{route('admin.categories.edit', ['category' => $category])}}">Изменить
                            </x-button>
                            <x-button 
                                      link="{{route('admin.categories.show', ['category' => $category])}}">Посмотреть
                            </x-button>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        {{$categories->paginate(5)}}
    @endif

@endsection
