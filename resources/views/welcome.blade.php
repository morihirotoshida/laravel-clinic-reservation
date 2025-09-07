<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>発熱外来 予約</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto my-8 p-6 bg-white rounded-lg shadow-xl max-w-4xl">
        <h1 class="text-3xl font-bold mb-6 text-center text-teal-700">発熱外来 予約</h1>

        <div class="p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 mb-8 rounded-md shadow">
            <p class="font-bold">お知らせ</p>
            <p>ご希望の予約日時を選択してください。「予約する」ボタンが表示されている時間帯が予約可能です。</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left font-semibold">日付</th>
                        <th class="py-3 px-4 text-left font-semibold">時間</th>
                        <th class="py-3 px-4 text-center font-semibold">予約</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($timeSlots as $slot)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-4 px-4">{{ \Carbon\Carbon::parse($slot->date)->isoFormat('YYYY年M月D日(ddd)') }}</td>
                            <td class="py-4 px-4 font-mono">{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</td>
                            <td class="py-4 px-4 text-center">
                                <a href="{{ route('reservations.create', $slot) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                                    予約する
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-10 text-gray-500">現在予約可能な時間枠はありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

