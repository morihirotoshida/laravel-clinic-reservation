<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>時間枠管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 font-sans">
    <!-- 管理者用ナビゲーションバー -->
    <nav class="bg-gray-800 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl">予約管理システム</a>
            <div>
                <a href="{{ route('admin.timeslots.index') }}" class="px-4 hover:text-gray-300">時間枠管理</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 hover:text-gray-300">ログアウト</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto my-8 p-6 bg-white rounded-lg shadow-xl max-w-5xl">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">時間枠管理</h1>

        <!-- メッセージ表示 -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- 時間枠登録フォーム -->
        <div class="bg-gray-100 p-6 rounded-lg mb-8">
            <h2 class="text-xl font-semibold mb-4">新しい時間枠を登録</h2>
            <form action="{{ route('admin.timeslots.store') }}" method="POST" class="flex flex-wrap items-end gap-4">
                @csrf
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">日付</label>
                    <input type="date" id="date" name="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">開始時間</label>
                    <input type="time" id="start_time" name="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" step="1800" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow">登録</button>
            </form>
        </div>

        <!-- 時間枠一覧 -->
        <div>
            <h2 class="text-xl font-semibold mb-4">登録済み時間枠一覧</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg">
                    <thead class="bg-gray-700 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">日時</th>
                            <th class="py-3 px-4 text-left">予約状況</th>
                            <th class="py-3 px-4 text-center">操作</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($timeSlots as $slot)
                            <tr class="hover:bg-gray-100 {{ $slot->is_booked ? 'bg-orange-50' : '' }}">
                                <td class="py-4 px-4">{{ \Carbon\Carbon::parse($slot->date)->isoFormat('YYYY/M/D(ddd)') }} {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</td>
                                <td class="py-4 px-4">
                                    @if ($slot->is_booked)
                                        <span class="bg-orange-500 text-white text-xs font-bold mr-2 px-2.5 py-0.5 rounded-full">予約済み</span>
                                        <span>{{ $slot->reservation->patient_name ?? '' }} 様</span>
                                    @else
                                        <span class="bg-green-500 text-white text-xs font-bold mr-2 px-2.5 py-0.5 rounded-full">空き</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if (!$slot->is_booked)
                                    <form action="{{ route('admin.timeslots.destroy', $slot) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded-md text-sm">削除</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-10 text-gray-500">登録されている時間枠はありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
