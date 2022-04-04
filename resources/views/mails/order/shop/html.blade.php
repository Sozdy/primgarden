Заказ: <b>#{{ $order->id }}</b> от <b>{{ $order->created_at->format("d.m.y H:i") }}</b>
<br />
@if (isset($user))
  Организация: <b>{{ $user->organization }}</b>
  <br />
  Юридический адрес: <b>{{ $user->legal_address }}</b>
  <br />
@else
  <b>Розничный покупатель</b>
  <br />
@endif
ФИО: <b>{{ $order->contact_person ?? ($order->last_name . " " . $order->first_name) }}</b>
<br />
Телефон: <b>{{ $order->phone }}</b>
<br />
Email: <b>{{ $order->email }}</b>
<br />
Способ выдачи: <b>{{ $order->delivery_type == "delivery" ? "доставка" : "самовывоз" }}</b>
<br />
@if ($order->delivery_address)
  Адрес доставки: <b>{{ $order->delivery_address }}</b>
  <br />
@endif

@if ($order->delivery_comment)
  Комментарий к доставке: <b>{{ $order->delivery_comment }}</b>
  <br />
@endif

@if ($order->comment)
  Комментарий к заказу: <b>{{ $order->comment }}</b>
  <br />
@endif

Общая сумма заказа: <b>{{ $order->sum }}</b> рублей
