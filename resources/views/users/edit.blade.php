@extends('layouts.app')

@section('header_title', 'Assign Roles')

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
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=16a34a&color=fff"
                    alt="User Avatar" class="w-12 h-12 rounded-full border-2 border-white shadow-sm">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="mb-8">
                    <label class="block text-sm font-medium text-slate-700 mb-4">Assign Roles <span
                            class="text-rose-500">*</span></label>

                    @error('roles')
                        <p class="mb-4 text-sm text-rose-500">{{ $message }}</p>
                    @enderror

                    @if($user->email === 'systemadmin@nims.com')
                        <div
                            class="mb-4 p-4 bg-blue-50 text-blue-700 rounded-xl text-sm font-medium border border-blue-100 flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>This is the system administrator account. The <strong>System Admin</strong> role cannot be
                                removed.</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($roles as $role)
                            <label
                                class="relative flex items-start gap-3 p-4 cursor-pointer rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50/50 group">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                        class="w-4 h-4 text-green-600 bg-white border-slate-300 rounded focus:ring-green-600 focus:ring-2"
                                        {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }} {{ ($user->email
                                    === 'systemadmin@nims.com' && $role->name === 'System Admin') ? 'disabled' : '' }}>

                                    @if($user->email === 'systemadmin@nims.com' && $role->name === 'System Admin')
                                        <input type="hidden" name="roles[]" value="System Admin">
                                    @endif
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
                        Save Roles
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection