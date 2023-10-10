@props(['value' => ''])

<textarea {!! $attributes->merge(['class' => 'block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!} >{{ $value }}</textarea>
@error($attributes['name'])
{{ $message }}
@enderror
