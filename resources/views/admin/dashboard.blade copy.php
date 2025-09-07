<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ダッシュボード</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 font-sans">
    <!-- 管理者用ナビゲーションバー -->
    <nav class="bg-gray-800 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl">予約管理システム</a>
            <div>
                <a href="{{ route('admin.timeslots.index') }}" class="px-4 hover:text-gray-300">時間枠管理</a>
                <!-- ログアウトフォーム -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 hover:text-gray-300">ログアウト</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto my-8 p-6 bg-white rounded-lg shadow-xl max-w-5xl">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">予約一覧</h1>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">予約日時</th>
                        <th class="py-3 px-4 text-left">氏名</th>
                        <th class="py-3 px-4 text-left">電話番号</th>
                        <th class="py-3 px-4 text-left">症状</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($reservations as $reservation)
                        <tr class="hover:bg-gray-100">
                            <td class="py-4 px-4 font-semibold">{{ \Carbon\Carbon::parse($reservation->timeSlot->date)->isoFormat('M/D(ddd)') }} {{ \Carbon\Carbon::parse($reservation->timeSlot->start_time)->format('H:i') }}</td>
                            <td class="py-4 px-4">{{ $reservation->patient_name }}</td>
                            <td class="py-4 px-4">{{ $reservation->patient_tel }}</td>
                            <td class="py-4 px-4">{{ $reservation->symptoms ?? '記載なし' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-500">現在、予約はありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

