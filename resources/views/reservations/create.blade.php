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

        {{-- ↓↓↓ エラーメッセージ表示機能を追加しました ↓↓↓ --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">入力内容にエラーがあります。</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="time_slot_id" value="{{ $time_slot->id }}">

            <div class="mb-4">
                <label for="patient_name" class="block text-sm font-medium text-gray-700">お名前 <span class="text-red-500">*</span></label>
                {{-- valueと@errorを追加 --}}
                <input type="text" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('patient_name') border-red-500 @enderror" required placeholder="医療　太郎">
            </div>

            <div class="mb-4">
                <label for="patient_tel" class="block text-sm font-medium text-gray-700">電話番号 <span class="text-red-500">*</span></label>
                {{-- valueと@errorを追加 --}}
                <input type="tel" id="patient_tel" name="patient_tel" value="{{ old('patient_tel') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('patient_tel') border-red-500 @enderror" required placeholder="080-1234-5678">
            </div>

            <div class="mb-6">
                <label for="symptoms" class="block text-sm font-medium text-gray-700">主な症状（任意）</label>
                {{-- old()に対応 --}}
                <textarea id="symptoms" name="symptoms" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="できるだけ詳しくお願いします">{{ old('symptoms') }}</textarea>
            </div>

            <div class="flex items-center justify-center">
                <button type="submit" class="w-full bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md shadow">予約を確定する</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

