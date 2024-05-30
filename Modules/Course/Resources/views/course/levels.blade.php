<option value="0">Choose One</option>
@foreach ($levels as $level)
    <option value="{{ $level['id'] }}">{{ $level['name'] }}</option>
@endforeach
