<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('enlist-file') }}" method="post">
            @csrf
            <input type="text" name="url" value="{{ old('url') }}">
            <input type="submit">
        </form>

        <ul>
        @foreach ($files as $file)
            <li>
                {{ $file->url }} | {{ $file->status }}
                @if ($file->filename)
                    | <a href="{{ $file->getDownloadLink() }}">{{ $file->filename }}</a>
                @endif
            </li>
        @endforeach
        </ul>
    </body>
</html>
