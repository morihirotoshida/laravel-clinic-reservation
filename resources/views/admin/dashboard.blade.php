<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約管理システム</title>
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

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">予約日時</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">氏名</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">電話番号</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">症状</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">操作</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($reservations as $reservation)
                    <tr>
                        <td class="text-left py-3 px-4">{{ $reservation->timeSlot->slot_datetime->isoFormat('YYYY/MM/DD(ddd) HH:mm') }}</td>
                        <td class="text-left py-3 px-4">{{ $reservation->patient_name }}</td>
                        <td class="text-left py-3 px-4">{{ $reservation->patient_tel }}</td>
                        <td class="text-left py-3 px-4">{{ $reservation->symptoms }}</td>
                        <td class="text-left py-3 px-4">
                            {{-- 削除ボタンと、削除を実行するための隠しフォーム --}}
                            <form id="delete-form-{{ $reservation->id }}" action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button onclick="confirmDelete('{{ $reservation->id }}')" class="text-red-500 hover:text-red-700 text-sm font-bold">削除</button>
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

    {{-- ページネーションリンク --}}
    <div class="mt-4">
        {{ $reservations->links() }}
    </div>
</main>

{{-- 暗証番号を確認するためのJavaScript --}}
<script>
function confirmDelete(reservationId) {
    // ★★★ 暗証番号はここで設定します（例: 1234）★★★
    const correctPin = "1234";

    const pin = prompt("予約を削除するには4桁の暗証番号を入力してください:");

    if (pin === null) {
        // キャンセルされた場合
        return;
    }

    if (pin === correctPin) {
        // 暗証番号が正しい場合
        if (confirm("本当によろしいですか？この操作は元に戻せません。")) {
            document.getElementById('delete-form-' + reservationId).submit();
        }
    } else {
        // 暗証番号が間違っている場合
        alert("暗証番号が違います。");
    }
}
</script>

</body>
</html>

