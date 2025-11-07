<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #999;
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f2f2f2;
        }
        .status-approved { color: #198754; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-rejected { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <h2>
        🧾 Onboarding Report
        ({{ $year ?? 'All Years' }}{{ $month ? '/'.sprintf('%02d', $month) : '' }})
        @if(!empty($status)) — {{ ucfirst($status) }} @endif
    </h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Refer Code</th>
                <th>Teller ID</th>
                <th>Branch</th>
                <th>Store Name</th>
                <th>Address</th>
                <th>Business Type</th>
                <th>POS Serial</th>
                <th>Bank Account</th>
                <th>Install Date</th>
                <th>Store Status</th>
                <th>Approval</th>
                <th>Admin Remark</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $r)
            <tr>
                <td>{{ $r->id }}</td>
                <td>{{ $r->refer_code }}</td>
                <td>{{ $r->teller_id }}</td>
                <td>{{ $r->branch_id }}</td>
                <td>{{ $r->store_name }}</td>
                <td>{{ $r->store_address }}</td>
                <td>{{ $r->business_type }}</td>
                <td>{{ $r->pos_serial }}</td>
                <td>{{ $r->bank_account }}</td>
                <td>{{ $r->installation_date }}</td>
                <td>{{ $r->store_status }}</td>
                <td>
                    <span class="status-{{ strtolower($r->approval_status) }}">
                        {{ ucfirst($r->approval_status) }}
                    </span>
                </td>
                <td>{{ $r->admin_remark ?? '-' }}</td>
                <td>{{ $r->created_at }}</td>
            </tr>
            @empty
            <tr><td colspan="14" style="text-align:center;">No records found</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
