<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約情報入力</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto my-8 p-6 bg-white rounded-lg shadow-xl max-w-2xl">
        <h1 class="text-3xl font-bold mb-4 text-center text-teal-700">予約情報入力</h1>
        
        <div class="bg-gray-200 p-4 rounded-md mb-6 text-center">
            <p class="text-lg">予約日時</p>
            <p class="text-2xl font-bold text-teal-800">
                {{ \Carbon\Carbon::parse($time_slot->date)->isoFormat('YYYY年M月D日(ddd)') }}
                {{ \Carbon\Carbon::parse($time_slot->start_time)->format('H:i') }}
            </p>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow" role="alert">
                <p class="font-bold">エラー</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="time_slot_id" value="{{ $time_slot->id }}">
            
            <div class="mb-4">
                <label for="patient_name" class="block text-gray-700 text-sm font-bold mb-2">お名前 <span class="text-red-500">*</span></label>
                <input type="text" id="patient_name" name="patient_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="医療　太郎">
            </div>
            
            <div class="mb-4">
                <label for="patient_tel" class="block text-gray-700 text-sm font-bold mb-2">電話番号 <span class="text-red-500">*</span></label>
                <input type="tel" id="patient_tel" name="patient_tel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="080-1234-5678">
            </div>

            <div class="mb-6">
                <label for="symptoms" class="block text-gray-700 text-sm font-bold mb-2">症状など (任意)</label>
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
</body>
</html>
