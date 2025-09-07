<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約情報入力</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto mt-10 p-4">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">
        {{-- ↓↓↓ タイムゾーン 'Asia/Tokyo' を指定して、9時間のズレを修正しました ↓↓↓ --}}
        <h2 class="text-xl font-semibold mb-4">予約日時： {{ \Carbon\Carbon::parse($time_slot->date . ' ' . $time_slot->start_time, 'Asia/Tokyo')->isoFormat('YYYY年MM月DD日(ddd) HH:mm') }}</h2>
        <p class="text-gray-600 mb-6">以下の情報を入力してください。</p>

        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="time_slot_id" value="{{ $time_slot->id }}">

            <div class="mb-4">
                <label for="patient_name" class="block text-sm font-medium text-gray-700">お名前 <span class="text-red-500">*</span></label>
                <input type="text" id="patient_name" name="patient_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="医療　太郎">
            </div>

            <div class="mb-4">
                <label for="patient_tel" class="block text-sm font-medium text-gray-700">電話番号 <span class="text-red-500">*</span></label>
                <input type="tel" id="patient_tel" name="patient_tel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="080-1234-5678">
            </div>

            <div class="mb-6">
                <label for="symptoms" class="block text-sm font-medium text-gray-700">主な症状（任意）</label>
                <textarea id="symptoms" name="symptoms" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="できるだけ詳しくお願いします"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 font-bold">&laquo; 時間選択に戻る</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                    予約を確定する
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

