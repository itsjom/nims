@extends('layouts.app')

@section('header_title', 'Roles & Permissions')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
            <h2 class="text-lg font-bold text-slate-800">System Roles</h2>
            <p class="text-sm text-slate-500 mt-1">Manage user roles and their associated permissions</p>
        </div>
        <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm shadow-green-200 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Role
        </a>
    </div>

    @if(session('success'))
        <div class="m-6 p-4 bg-green-50 text-green-700 rounded-xl text-sm font-medium border border-green-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="m-6 p-4 bg-rose-50 text-rose-700 rounded-xl text-sm font-medium border border-rose-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/4">Role Name</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Permissions</th>
                    <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($roles as $role)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="py-4 px-6 align-top">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-slate-100 text-slate-700 capitalize">
                            {{ $role->name }}
                        </span>
                    </td>
                    <td class="py-4 px-6 align-top">
                        <div class="flex flex-wrap gap-2">
                            @foreach($role->permissions as $permission)
                                <span class="px-2.5 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-md border border-green-100/50 capitalize">
                                    {{ $permission->name }}
                                </span>
                            @endforeach
                            @if($role->permissions->isEmpty())
                                <span class="text-sm text-slate-400 italic">No permissions assigned</span>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-6 align-top text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('roles.edit', $role) }}" class="p-2 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Edit Role">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            
                            @if($role->name !== 'System Admin')
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this role? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Role">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                
                @if($roles->isEmpty())
                <tr>
                    <td colspan="3" class="py-12 px-6 text-center text-slate-500">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                        <p class="text-sm font-medium">No roles found.</p>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
