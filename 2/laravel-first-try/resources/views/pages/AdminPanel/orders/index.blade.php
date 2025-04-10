@extends('layouts.layout')

@section('content')
    <h1 class="text-white text-3xl mb-4">Заказы</h1>

    <div class="overflow-x-scroll">
        @if(count($orders) === 0)
            <p>Нет заказов</p>
        @else
            <table class="w-full">
                <thead>
                <tr>
                    <th class="border-2 border-white p-2 text-white">ID</th>
                    <th class="border-2 border-white p-2 text-white">Email</th>
                    <th class="border-2 border-white p-2 text-white">Цена товара</th>
                    <th class="border-2 border-white p-2 text-white">Статус</th>
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
                @foreach($orders as $order)
                    <tr>
                        <td class="border-2 border-white p-2 text-white">{{$order->id}}</td>
                        <td class="border-2 border-white p-2 text-white">{{$order->email()}}</td>
                        <td class="border-2 border-white p-2 text-white">{{$order->price()}}</td>
                        <td class="border-2 border-white p-2 text-white">
                            {{
                                $order->status === "pending" ?
                                 "В процессе" : ($order->status === "success"
                                 ? "Оплачен" : "Ошибка оплаты")
                            }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
