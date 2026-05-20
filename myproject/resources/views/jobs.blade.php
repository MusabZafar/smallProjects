<x-layout title="Jobs">
    <h1>Jobs Page</h1>

    <ul>
        @foreach ($jobs as $job)
            <li>
                <a href="/jobs/{{ $job->id }}">
                    {{ $job->title }} - {{ $job->salary }}
                </a>
            </li>
        @endforeach
    </ul>
</x-layout>