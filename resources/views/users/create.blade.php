@extends('layouts.app')

@section('header_title', 'Add New User')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('users.index') }}"
                class="text-sm font-medium text-slate-500 hover:text-green-600 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Users
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Create Account</h2>
                    <p class="text-sm text-slate-500">Add a new user and assign their roles</p>
                </div>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Full Name <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-colors"
                            placeholder="John Doe">
                        @error('name')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email Address <span
                                class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-colors"
                            placeholder="john@example.com">
                        @error('email')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password <span
                                class="text-rose-500">*</span></label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-colors"
                            placeholder="Min. 8 characters">
                        @error('password')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Confirm Password <span
                                class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-colors"
                            placeholder="Repeat password">
                    </div>
                </div>

                <div class="mb-8 border-t border-slate-100 pt-8">
                    <label class="block text-sm font-medium text-slate-700 mb-4">Assign Roles</label>

                    @error('roles')
                        <p class="mb-4 text-sm text-rose-500">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($roles as $role)
                            <label
                                class="relative flex items-start gap-3 p-4 cursor-pointer rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50/50 group">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                        class="w-4 h-4 text-green-600 bg-white border-slate-300 rounded focus:ring-green-600 focus:ring-2"
                                        {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                </div>
                                <div class="text-sm">
                                    <span
                                        class="font-bold text-slate-700 group-has-[:checked]:text-green-800 capitalize">{{ $role->name }}</span>
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @if($role->name === 'System Admin')
                                            <span class="text-xs text-slate-400">Has all permissions</span>
                                        @else
                                            <span
                                                class="text-[10px] text-slate-400 uppercase tracking-wider">{{ $role->permissions->count() }}
                                                permissions</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('users.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm shadow-green-200">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection