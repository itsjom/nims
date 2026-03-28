@extends('layouts.app')

@section('header_title', 'CI Monitoring')

@section('content')
<div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm flex flex-col items-center justify-center text-center">
    <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500 mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <h2 class="text-xl font-bold text-slate-800 mb-2">CI Monitoring Dashboard</h2>
    <p class="text-slate-500 max-w-md">This is a placeholder for the Clinical Instructor Monitoring module. Let me know what data tables or features you want to build here!</p>
</div>
@endsection
