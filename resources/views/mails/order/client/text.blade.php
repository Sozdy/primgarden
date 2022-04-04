Здравствуйте, {{ $order->contact_person ?? ($order->last_name . " " . $order->first_name) }}!

Ваш заказ номер {{ $order->id }} от {{ $order->created_at->format("d.m.y H:i") }} успешно получен.
{{--
В ближайшее время с вами свяжется менеджер по указанному вами номеру телефона {{ $order->phone }} ({{ $order->email }})--}}

Способ выдачи Вашего заказа: {{ $order->delivery_type == "delivery" ? "доставка" : "самовывоз" }}

@if ($order->delivery_address)
  Адрес доставки: {{ $order->delivery_address }}
@endif

@if ($order->delivery_comment)
  Комментарий к доставке: {{ $order->delivery_comment }}
@endif

@if ($order->comment)
  Комментарий к заказу: {{ $order->comment }}
@endif

Общая сумма заказа: {{ $order->sum }} рублей
