@extends('layouts.app')

@section('header_title', 'Create Role')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('roles.index') }}"
                class="text-sm font-medium text-slate-500 hover:text-green-600 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Roles
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-lg font-bold text-slate-800">New Role Details</h2>
                <p class="text-sm text-slate-500 mt-1">Define the role name and select the permissions it should have.</p>
            </div>

            <form action="{{ route('roles.store') }}" method="POST" class="p-8">
                @csrf

                <div class="mb-8">
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Role Name <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" required
                        class="w-full max-w-md px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all @error('name') border-rose-300 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                        placeholder="e.g. Moderator, Manager" value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-slate-700 mb-4">Assign Permissions <span
                            class="text-rose-500">*</span></label>

                    @error('permissions')
                        <p class="mb-4 text-sm text-rose-500">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($permissions as $permission)
                            <label
                                class="relative flex items-start gap-3 p-4 cursor-pointer rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50/50 group">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                        class="w-4 h-4 text-green-600 bg-white border-slate-300 rounded focus:ring-green-600 focus:ring-2"
                                        {{ (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                </div>
                                <div class="text-sm">
                                    <span
                                        class="font-medium text-slate-700 group-has-[:checked]:text-green-800 capitalize">{{ str_replace('-', ' ', $permission->name) }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('roles.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm shadow-green-200">
                        Save Role
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection