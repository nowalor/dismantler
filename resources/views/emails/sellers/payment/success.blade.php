<div>
    <h2>Hey Marcus a part has been bought</h2>
    <hr />
    <p>A new part has been bought and you have recieved a payment for. {{ $order->part_price }}</p>
    <p>You should reserve the part as soon as possible</p>
    <div>
        <h3>Information on the part</h3>
        <p><span class="bold">Name: </span>{{ $order->carPart->name }}</p>
        <p><span class="bold">Condition: </span>{{ $order->carPart->condition }}</p>
        <p><span class="bold">Engine type: </span>{{ $order->carPart->engine_type }}</p>
    </div>
</div>

<style>
    .bold {
        font-weight: bold;
    }
</style>
