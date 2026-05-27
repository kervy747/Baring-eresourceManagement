<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activity Report</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 11px;
      color: #000;
      background: #fff;
      padding: 30px 40px;
    }

    /* ── Header ── */
    .report-header {
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .report-header h1 {
      font-size: 20px;
      font-weight: bold;
      letter-spacing: 0.5px;
    }
    .report-header p {
      font-size: 10px;
      color: #444;
      margin-top: 3px;
    }

    /* ── Section titles ── */
    h2 {
      font-size: 13px;
      font-weight: bold;
      border-bottom: 1px solid #000;
      padding-bottom: 4px;
      margin-bottom: 10px;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }

    section { margin-bottom: 24px; }

    /* ── Summary grid ── */
    .summary-grid {
      width: 100%;
      border-collapse: collapse;
    }
    .summary-grid td {
      width: 25%;
      border: 1px solid #aaa;
      padding: 10px 12px;
      vertical-align: top;
    }
    .summary-grid .label {
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #555;
    }
    .summary-grid .value {
      font-size: 22px;
      font-weight: bold;
      line-height: 1.2;
      margin-top: 2px;
    }

    /* ── Monthly activity ── */
    .monthly-table {
      width: 100%;
      border-collapse: collapse;
    }
    .monthly-table th,
    .monthly-table td {
      border: 1px solid #aaa;
      padding: 6px 10px;
      text-align: left;
    }
    .monthly-table th {
      background: #eee;
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }
    .monthly-table .bar-cell {
      width: 55%;
    }
    .bar-outer {
      background: #ddd;
      height: 12px;
      border-radius: 2px;
      width: 100%;
    }
    .bar-inner {
      background: #333;
      height: 12px;
      border-radius: 2px;
    }

    /* ── Action breakdown ── */
    .breakdown-table {
      width: 60%;
      border-collapse: collapse;
    }
    .breakdown-table th,
    .breakdown-table td {
      border: 1px solid #aaa;
      padding: 6px 10px;
      text-align: left;
    }
    .breakdown-table th {
      background: #eee;
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    /* ── Activity log table ── */
    .log-table {
      width: 100%;
      border-collapse: collapse;
    }
    .log-table th,
    .log-table td {
      border: 1px solid #aaa;
      padding: 5px 8px;
      text-align: left;
      vertical-align: top;
    }
    .log-table th {
      background: #eee;
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      white-space: nowrap;
    }
    .log-table td {
      font-size: 10px;
    }
    .log-table tr:nth-child(even) td {
      background: #f8f8f8;
    }

    /* ── Footer ── */
    .report-footer {
      border-top: 1px solid #aaa;
      padding-top: 8px;
      margin-top: 30px;
      font-size: 9px;
      color: #666;
      text-align: center;
    }
  </style>
</head>
<body>

  {{-- ── Header ── --}}
  <div class="report-header">
    <h1>Activity Log Report</h1>
    <p>Generated on: {{ $now->format('F d, Y \a\t h:i A') }}</p>
  </div>

  {{-- ── 1. Summary Stats ── --}}
  <section>
    <h2>Summary</h2>
    <table class="summary-grid">
      <tr>
        <td>
          <div class="label">Total Books</div>
          <div class="value">{{ number_format($totalBooks) }}</div>
        </td>
        <td>
          <div class="label">Total Users</div>
          <div class="value">{{ number_format($totalUsers) }}</div>
        </td>
        <td>
          <div class="label">Total Categories</div>
          <div class="value">{{ number_format($totalCategories) }}</div>
        </td>
        <td>
          <div class="label">Total Activity Logs</div>
          <div class="value">{{ number_format($totalDownloads) }}</div>
        </td>
      </tr>
    </table>
  </section>

  {{-- ── 2. Monthly Activity ── --}}
  <section>
    <h2>Monthly Activity (Last 6 Months)</h2>
    @php $maxCount = $monthlyActivity->max('count') ?: 1; @endphp
    <table class="monthly-table">
      <thead>
        <tr>
          <th style="width:20%">Month</th>
          <th style="width:55%">Activity</th>
          <th style="width:25%; text-align:right">Count</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($monthlyActivity as $row)
          <tr>
            <td>{{ $row['month'] }}</td>
            <td class="bar-cell">
              <div class="bar-outer">
                <div class="bar-inner" style="width: {{ ($row['count'] / $maxCount) * 100 }}%"></div>
              </div>
            </td>
            <td style="text-align:right; font-weight:bold">{{ $row['count'] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>

  {{-- ── 3. Action Breakdown ── --}}
  <section>
    <h2>Action Breakdown</h2>
    @php $grandTotal = $actionBreakdown->sum('count') ?: 1; @endphp
    <table class="breakdown-table">
      <thead>
        <tr>
          <th>Action</th>
          <th style="text-align:right">Count</th>
          <th style="text-align:right">Percentage</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($actionBreakdown as $row)
          <tr>
            <td>{{ ucfirst($row->action) }}</td>
            <td style="text-align:right; font-weight:bold">{{ $row->count }}</td>
            <td style="text-align:right">{{ number_format(($row->count / $grandTotal) * 100, 1) }}%</td>
          </tr>
        @endforeach
        <tr>
          <td><strong>Total</strong></td>
          <td style="text-align:right"><strong>{{ $grandTotal }}</strong></td>
          <td style="text-align:right"><strong>100%</strong></td>
        </tr>
      </tbody>
    </table>
  </section>

  {{-- ── 4. Full Activity Log ── --}}
  <section>
    <h2>Activity Log ({{ $allLogs->count() }} {{ Str::plural('entry', $allLogs->count()) }})</h2>
    <table class="log-table">
      <thead>
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Book</th>
          <th>Action</th>
          <th>Description</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($allLogs as $i => $log)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>
              @if ($log->user)
                {{ $log->user->fname }} {{ $log->user->lname }}
              @else
                <em>Deleted user</em>
              @endif
            </td>
            <td>
              @if ($log->book)
                {{ Str::limit($log->book->title, 35) }}
              @else
                <em>Deleted book</em>
              @endif
            </td>
            <td>{{ ucfirst($log->action) }}</td>
            <td>{{ $log->description ?? '—' }}</td>
            <td style="white-space:nowrap">
              {{ $log->created_at->format('M d, Y') }}<br>
              <span style="color:#666">{{ $log->created_at->format('h:i A') }}</span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center; color:#666; padding:16px">No activity recorded.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </section>

  {{-- ── Footer ── --}}
  <div class="report-footer">
    This report was automatically generated &mdash; {{ config('app.name') }} &mdash; {{ $now->format('Y') }}
  </div>

</body>
</html>