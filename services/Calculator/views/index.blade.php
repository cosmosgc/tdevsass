<x-app-layout>
    <div class="container">
        <h1>Calculator Service</h1>
        <form id="calculator-form">
            <input type="number" name="num1" placeholder="Number 1" required>
            <select name="operation">
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
            </select>
            <input type="number" name="num2" placeholder="Number 2" required>
            <button type="submit">Calculate</button>
        </form>
        <p>Result: <span id="result"></span></p>
    </div>

    <script>
        document.getElementById('calculator-form').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('/calculator/calculate', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    num1: document.querySelector('[name="num1"]').value,
                    num2: document.querySelector('[name="num2"]').value,
                    operation: document.querySelector('[name="operation"]').value
                })
            })
            .then(response => response.json())
            .then(data => document.getElementById('result').innerText = data.result);
        });
    </script>
</x-app-layout>
