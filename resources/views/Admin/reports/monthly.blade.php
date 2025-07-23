<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report - {{ $month }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header { 
            text-align: center;
            margin-bottom: 30px;
        }
        table { 
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td { 
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th { 
            background-color: #f5f5f5;
        }
        .summary-box {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Monthly Report - {{ $month }}</h1>
    </div>
    
    <div class="summary-box">
        <h2>Monthly Summary</h2>
        <p>Total Guides: {{ $guides->count() }}</p>
        <p>Total Visits: {{ $visits->count() }}</p>
        <p>Total Tourists: {{ $totalTourists }}</p>
    </div>
    
    <h2>Visit Details</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Guide Name</th>
                <th>Tourist Count</th>
            </tr>
        </thead>
        <tbody id="reportTableBody">
            @foreach($visits as $visit)
            <tr>
                <td>{{ $visit->created_at->format('Y-m-d') }}</td>
                <td>{{ $visit->guide->full_name }}</td>
                <td>{{ $visit->pax_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="reportPagination" class="flex justify-center items-center space-x-1 p-4"></div>

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #666;">
        Generated on {{ now()->format('Y-m-d H:i:s') }}
        <br>
        © {{ date('Y') }} Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd.
    </div>
    <script>
        function applyPagination(tbodyId, paginationId, rowsPerPage = 10) {
            const tbody = document.getElementById(tbodyId);
            const pagination = document.getElementById(paginationId);
            if (!tbody || !pagination) return;
            const rows = Array.from(tbody.querySelectorAll('tr'));
            let currentPage = 1;
            const pageCount = Math.ceil(rows.length / rowsPerPage);

            function render() {
                pagination.innerHTML = '';
                if (pageCount <= 1) return;
                for (let i = 1; i <= pageCount; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;

                    btn.className =
                        'px-3 py-1 mx-1 rounded-md border ' +
                        (i === currentPage ? 'bg-blue-600 text-white' : 'bg-white text-blue-600');

                    btn.addEventListener('click', () => showPage(i));
                    pagination.appendChild(btn);
                }
            }

            function showPage(page) {
                currentPage = page;
                rows.forEach((row, idx) => {
                    row.style.display = idx >= (page - 1) * rowsPerPage && idx < page * rowsPerPage ? '' : 'none';
                });
                render();
            }

            showPage(1);
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyPagination('reportTableBody', 'reportPagination', 10);
        });
    </script>
</body>
</html>