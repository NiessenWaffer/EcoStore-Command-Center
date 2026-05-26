<x-mail::message>
# Order Confirmed!

Thank you for your purchase. Your order #{{ $order->id }} is being prepared.

By choosing our sustainable apparel, you've made a real difference:

<x-mail::panel>
**Your Environmental Impact:**
- **Water Saved:** {{ $order->total_water_saved }} Liters
- **Carbon Reduced:** {{ $order->total_carbon_reduced }} kg
</x-mail::panel>

We are committed to 100% carbon neutral shipping for every order.

<x-mail::button :url="config('app.url')">
View Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
