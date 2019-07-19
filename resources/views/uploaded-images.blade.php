@extends('main')

@section('js')
    <script src="{{ url('/js/jquery.js') }}"></script>
@endsection

@section('content')
    <div class="table-responsive-sm">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Filename</th>
            </tr>
            </thead>
            <tbody>
            @foreach($photos as $photo)
                <tr>
                    <td><img src="/upload/{{ $photo->filename }}" style="width: 250px; height: 100px;"></td>
                    <td>{{ $photo->filename }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection