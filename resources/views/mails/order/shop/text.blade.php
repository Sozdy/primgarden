Заказ: #{{ $order->id }} от {{ $order->created_at->format("d.m.y H:i") }}
@if ($user)
  Организация: {{ $user->organization }}
  Юридический адрес: {{ $user->legal_address }}
@else
  Розничный покупатель
@endif
ФИО: {{ $order->contact_person ?? ($order->last_name . " " . $order->first_name) }}
Телефон: {{ $order->phone }}
Email: {{ $order->email }}
Способ выдачи: {{ $order->delivery_type == "delivery" ? "доставка" : "самовывоз" }}
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
