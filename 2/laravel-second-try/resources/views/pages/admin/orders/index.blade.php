@extends("layouts.layout")

@section("content")
    <h1 class="text-3xl font-bold text-white">Заказы</h1>

    @if(count($orders) === 0)
        <p>Здесь пока ещё нет заказов</p>
    @else
        <div class="overflow-x-scroll">
            <table class="w-full">
                <thead>
                <tr>
                    <th class="border-2 border-white px-4 py-2 text-white">Название товара</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Email пользователя</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Цена товара</th>
                    <th class="border-2 border-white px-4 py-2 text-white">Статус</th>
                </tr>
                </thead>
                <tbody>

                {{-- Пустая строка --}}
                <tr>
                    <td class="h-4"></td>
                </tr>
                {{-- Пустая строка --}}

                @foreach($orders as $order)
                    <tr>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$order->product()->name}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$order->user()->email}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">{{$order->product()->price}}</td>
                        <td class="border-2 border-white px-4 py-2 text-white">
                            {{$order->status === "success" ?
                                "Оплачено" : ($order->status === "failed" ?
                                 "Не оплачено" :
                                 "Обрабатывается")}}
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    @endif

@endsection
