<x-layout title="Job Details">
    <h1>Job Details</h1>

    <h2>{{ $job->title }}</h2>
    <p>ID: {{ $job->id }}</p>
    <p>Salary: {{ $job->salary }}</p>
</x-layout>