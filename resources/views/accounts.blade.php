@extends('layouts.app')

@section('content')
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <form method="GET" action="/accounts/login">
            <input type="text" name="username" placeholder="username">
            <input type="password" name="password" placeholder="password">
            <button type="submit" class="bg-white hover:bg-white text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            Login
            </button>
        </form>
        <form method="GET" action="/accounts/lists">
            <input type="text" name="search" value="{{ $search }}" placeholder="search">
            <button type="submit" class="bg-white hover:bg-white text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            search
            </button>
        </form>
        <div class="not-prose p-6 relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25"><div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div><div class="relative rounded-xl overflow-auto"><div class="shadow-sm overflow-hidden my-8">
            <table class="border-collapse table-fixed w-full text-sm">
                <thead>
                <tr>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-white text-left">Name</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-white text-left">Username</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-white text-left">Company</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-white text-left">Phone</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-white text-left">Email</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($data as $list)
                    <tr>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:slate-400">{{ $list->name }}</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:slate-400">{{ $list->username }}</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:slate-400">{{ $list->company }}</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:slate-400">{{ $list->phone }}</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:slate-400">{{ $list->email }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:slate-400">No item spawned</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection