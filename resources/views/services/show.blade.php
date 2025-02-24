<x-app-layout>
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-3xl font-bold mb-6 text-center">{{ $service->name }}</h1>
        <p class="text-gray-300 text-center mb-6">{{ $service->description }}</p>

        <div class="max-w-md mx-auto bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-center">Calculator</h2>
            <input type="number" id="num1" placeholder="Enter first number" class="w-full p-2 mb-2 bg-gray-700 rounded text-black">
            <input type="number" id="num2" placeholder="Enter second number" class="w-full p-2 mb-4 bg-gray-700 rounded text-black">

            <div class="grid grid-cols-4 gap-2">
                <button class="calc-btn" data-op="+">+</button>
                <button class="calc-btn" data-op="-">-</button>
                <button class="calc-btn" data-op="*">×</button>
                <button class="calc-btn" data-op="/">÷</button>
            </div>

            <p class="text-lg mt-4 text-center font-semibold">Result: <span id="result" class="text-green-400">0</span></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.calc-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let num1 = parseFloat(document.getElementById('num1').value) || 0;
                    let num2 = parseFloat(document.getElementById('num2').value) || 0;
                    let op = this.getAttribute('data-op');
                    let result = 0;

                    switch (op) {
                        case '+': result = num1 + num2; break;
                        case '-': result = num1 - num2; break;
                        case '*': result = num1 * num2; break;
                        case '/': result = num2 !== 0 ? num1 / num2 : '∞'; break;
                    }

                    document.getElementById('result').textContent = result;
                });
            });
        });
    </script>

    <style>
        .calc-btn {
            background: #2563eb;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background 0.2s;
        }

        .calc-btn:hover {
            background: #1e40af;
        }
    </style>
</x-app-layout>
