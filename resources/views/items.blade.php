@extends('layouts.app')

@section('content')
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <form method="POST" action="/items/random">
        @csrf
            <button type="submit" class="p-6 bg-white hover:bg-white text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            click Spawn 100 times
            </button>
        </form>
        <div class="not-prose p-6 relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25"><div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div><div class="relative rounded-xl overflow-auto"><div class="shadow-sm overflow-hidden my-8">
            <table class="border-collapse table-fixed w-full text-sm">
                <thead>
                <tr>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-white text-left">Item spawned</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-white text-left">Amount</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-white text-left">Created at</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @forelse($item_lists as $item_list)
                    <tr>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:slate-400">{{ $item_list['item_name'] }}</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:slate-400">{{ $item_list['amount_spawned'] }}</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:slate-400">{{ $item_list['latest_spawn'] }}</td>
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
    <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div>
@endsection