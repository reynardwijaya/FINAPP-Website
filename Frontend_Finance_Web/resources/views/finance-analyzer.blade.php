<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Analyzer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .analysis-result {
            margin-top: 20px;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 4px;
            border: 1px solid #ced4da;
            white-space: pre-wrap; /* Preserve whitespace and line breaks */
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>UMKM Financial Analysis</h1>
        <form id="analysisForm">
            @csrf
            <label for="income">Income (Rp):</label>
            <input type="number" id="income" name="income" step="0.01" required>

            <label for="expense">Expense (Rp):</label>
            <input type="number" id="expense" name="expense" step="0.01" required>

            <button type="submit">Get Analysis</button>
        </form>

        <div id="analysisResult" class="analysis-result" style="display: none;"></div>
        <div id="errorMessage" class="error-message" style="display: none;"></div>
    </div>

    <script>
        document.getElementById('analysisForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const income = document.getElementById('income').value;
            const expense = document.getElementById('expense').value;
            const analysisResultDiv = document.getElementById('analysisResult');
            const errorMessageDiv = document.getElementById('errorMessage');

            analysisResultDiv.style.display = 'none';
            errorMessageDiv.style.display = 'none';
            analysisResultDiv.innerHTML = '';
            errorMessageDiv.innerHTML = '';

            try {
                const response = await fetch('/finance/analyze', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : ''
                    },
                    body: JSON.stringify({ income: parseFloat(income), expense: parseFloat(expense) })
                });

                const data = await response.json();

                if (response.ok) {
                    analysisResultDiv.innerHTML = data.analysis;
                    analysisResultDiv.style.display = 'block';
                } else {
                    errorMessageDiv.innerHTML = `Error: ${data.error || 'Something went wrong.'} ${data.backend_message ? 'Backend: ' + data.backend_message : ''}`;
                    errorMessageDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Fetch error:', error);
                errorMessageDiv.innerHTML = 'An unexpected error occurred. Please check console for more details.';
                errorMessageDiv.style.display = 'block';
            }
        });
    </script>
    @if (session('status'))
        <script>
            // Optional: You can handle success messages from Laravel here if needed
            console.log("{{ session('status') }}");
        </script>
    @endif
</body>
</html> 