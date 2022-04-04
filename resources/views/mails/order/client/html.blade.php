Здравствуйте, <b>{{ $order->contact_person ?? ($order->last_name . " " . $order->first_name) }}</b>!
<br /><br />
Ваш заказ номер <b>{{ $order->id }}</b> от <b>{{ $order->created_at->format("d.m.y H:i") }}</b> успешно получен.
<br /><br />
{{--В ближайшее время с вами свяжется менеджер по указанному вами номеру телефона <b>{{ $order->phone }}</b> ({{ $order->email }})--}}
{{--<br /><br />--}}
Способ выдачи Вашего заказа: <b>{{ $order->delivery_type == "delivery" ? "доставка" : "самовывоз" }}</b>
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
<br />
Общая сумма заказа: <b>{{ $order->sum }}</b> рублей
