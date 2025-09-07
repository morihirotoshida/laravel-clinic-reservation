<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ダッシュボード</title>
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
                <a href="{{ route('admin.timeslots.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">時間枠管理</a>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">ログアウト</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main class="container mx-auto mt-10 p-4">
    <h1 class="text-2xl font-bold mb-6">予約一覧</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md shadow" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">予約日時</th>
                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">氏名</th>
                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">電話番号</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">症状</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">操作</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($reservations as $reservation)
                    <tr class="border-b">
                        <td class="text-left py-3 px-4">
                            {{ \Carbon\Carbon::parse($reservation->timeSlot->date)->isoFormat('M/D(ddd)') }}
                            {{ \Carbon\Carbon::parse($reservation->timeSlot->start_time)->format('H:i') }}
                        </td>
                        <td class="text-left py-3 px-4">{{ $reservation->patient_name }}</td>
                        <td class="text-left py-3 px-4">{{ $reservation->patient_tel }}</td>
                        <td class="text-left py-3 px-4">{{ $reservation->symptoms }}</td>
                        <td class="text-left py-3 px-4">
                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded-full">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">現在、予約はありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<script>
    function confirmDelete() {
        const pin = prompt("予約を削除するには、暗証番号「1234」を入力してください。");
        if (pin === "1234") {
            return confirm("本当によろしいですか？この操作は元に戻せません。");
        } else if (pin !== null) { // キャンセルボタン以外が押された場合
            alert("暗証番号が違います。");
        }
        return false; // formの送信を中止
    }
</script>

</body>
</html>

