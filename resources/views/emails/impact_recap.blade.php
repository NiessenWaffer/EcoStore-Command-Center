<x-mail::message>
# Your Impact in the Last 24 Hours

It's been 24 hours since your purchase, and we wanted to show you the real difference you've made.

<div style="text-align: center; margin-bottom: 20px;">
    {!! $waterSvg !!}
    {!! $carbonSvg !!}
</div>

## Don't Lose Your Progress!

You've already saved **{{ $order->total_water_saved }}L** of water and reduced **{{ $order->total_carbon_reduced }}kg** of CO2. By registering, you can save this impact to your permanent profile and start earning ambassador rewards.

<x-mail::button :url="route('register', ['token' => $token])">
Save My Impact Permanently
</x-mail::button>

Every small choice counts towards a bigger collective mission.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
