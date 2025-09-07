<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約完了</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md text-center">
        <svg class="w-16 h-16 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">予約が完了しました</h1>
        <p class="text-gray-600 mb-6">ご指定の日時にご来院ください。</p>
        <div>
            {{-- ↓↓↓ ここのルート名を'home'から'welcome'に修正しました ↓↓↓ --}}
            <a href="{{ route('welcome') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-md">トップページに戻る</a>
        </div>
    </div>
</body>
</html>

