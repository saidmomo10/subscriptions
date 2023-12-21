@foreach($subscriptions as $key)
    <a href="{{ route('showSubscription', ['id' => $key->id]) }}">{{ $key->name }}</a><br>
@endforeach
