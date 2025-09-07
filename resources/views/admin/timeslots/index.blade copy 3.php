<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>時間枠管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-teal-700">発熱外来 予約管理</a>
            </div>
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">予約一覧</a>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">ログアウト</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main class="container mx-auto mt-10 p-4">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">時間枠管理</h1>

        <form action="{{ route('admin.timeslots.store') }}" method="POST" class="mb-10">
            @csrf
            <h2 class="text-xl font-semibold mb-4">新しい時間枠を登録</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">日付</label>
                    <input type="date" id="date" name="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">開始時間</label>
                    <select id="start_time" name="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @php
                            $start = \Carbon\Carbon::createFromTimeString('09:00');
                            $end = \Carbon\Carbon::createFromTimeString('18:00');
                        @endphp
                        @while($start->lte($end))
                            <option value="{{ $start->format('H:i') }}">{{ $start->format('H:i') }}</option>
                            @php
                                $start->addMinutes(15);
                            @endphp
                        @endwhile
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow">登録</button>
                </div>
            </div>
        </form>

        <h2 class="text-xl font-semibold mb-4">登録済み時間枠</h2>
        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">日時</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">状態</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">操作</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($timeSlots as $slot)
                        {{-- ↓↓↓ 過去の未予約枠を非表示にするための条件を追加しました ↓↓↓ --}}
                        @if(\Carbon\Carbon::parse($slot->date . ' ' . $slot->start_time)->isFuture() || $slot->is_booked)
                        <tr>
                            <td class="text-left py-3 px-4">
                                {{ \Carbon\Carbon::parse($slot->date)->Format('M/D(ddd)') }}
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                            </td>
                            <td class="text-left py-3 px-4">
                                @if($slot->is_booked)
                                    <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs">予約済み</span>
                                @else
                                    <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">空き</span>
                                @endif
                            </td>
                            <td class="text-left py-3 px-4">
                                <form action="{{ route('admin.timeslots.destroy', $slot) }}" method="POST" onsubmit="return confirm('この時間枠を削除してもよろしいですか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">削除</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">登録済みの時間枠はありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>

