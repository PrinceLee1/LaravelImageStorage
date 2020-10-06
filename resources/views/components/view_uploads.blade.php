@extends('components.master')
@include('components.nav')

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="cs-p-1">Name</th>
                <th class="cs-p-1">IMAGE</th>
                <th class="cs-p-1">DELETE</th>

            </tr>
        </thead>

        @forelse($images as $image)
            <tr>
                <td class="cs-p-1">{{ $image->name }}</td>
                <td class="cs-p-1"><a href="{{$image->url}}"><img src="{{$image->url}}" width="100px" height="100px" style="border-radius:8px" alt="uploaded_img"></a></td>
                <td class="cs-p-1"><a href="/delete/{{ $image->id }}">Delete</a></td>

            </tr>
            @empty
            <p>No Images at the moment</p>
        @endforelse
    </table>
</div>