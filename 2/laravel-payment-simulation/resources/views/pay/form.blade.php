<!DOCTYPE html>
<html>
<head><title>Оплата</title></head>
<body>
<h1>Введите данные карты</h1>
<form method="POST" action="{{ route('payment.submit', ['orderId' => $orderId]) }}">
    @csrf
    <input type="text" name="card_number" placeholder="Номер карты" required>
    <button type="submit">Оплатить</button>
</form>
</body>
</html>
