<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

  {{-- Bar Chart --}}
  <div class="bg-white rounded-md shadow-sm border border-gray-100 p-5 lg:col-span-2">
    <h2 class="text-base font-semibold text-gray-700 mb-4">Monthly Activity <span class="text-xs text-gray-400 font-normal">(last 6 months)</span></h2>
    <div class="relative h-56">
      <canvas id="barChart"></canvas>
    </div>
  </div>

  {{-- Pie Chart--}}
  <div class="bg-white rounded-md shadow-sm border border-gray-100 p-5">
    <h2 class="text-base font-semibold text-gray-700 mb-4">Action Breakdown</h2>
    <div class="relative h-44">
      <canvas id="pieChart"></canvas>
    </div>
    {{-- Legend --}}
    <div class="mt-4 space-y-1" id="pieLegend"></div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── Data from Laravel (JSON-encoded safely) ──────────────────────────
  const monthlyData   = @json($monthlyActivity);  
  const breakdownData = @json($actionBreakdown);  

  // ── Palette ───────────────────────────────────────────────────────────
  const purple  = '#6C3EEF';
  const purpleLight = 'rgba(108,62,239,0.15)';
  const pieColors = ['#6C3EEF', '#38BDF8', '#FB923C', '#4ADE80', '#F472B6'];

  // ── Bar Chart ─────────────────────────────────────────────────────────
  const barCtx = document.getElementById('barChart').getContext('2d');

  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: monthlyData.map(d => d.month),
      datasets: [{
        label: 'Activities',
        data: monthlyData.map(d => d.count),
        backgroundColor: purpleLight,
        borderColor: purple,
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1e1b4b',
          titleColor: '#e0d9ff',
          bodyColor: '#c4b5fd',
          cornerRadius: 8,
          padding: 10,
          callbacks: {
            label: ctx => ` ${ctx.parsed.y} activities`
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { color: '#9ca3af', font: { size: 12 } }
        },
        y: {
          beginAtZero: true,
          grid: { color: '#f3f4f6' },
          ticks: {
            color: '#9ca3af',
            font: { size: 12 },
            // Only whole numbers
            stepSize: 1,
            callback: val => Number.isInteger(val) ? val : null
          }
        }
      }
    }
  });

  // ── Pie Chart ─────────────────────────────────────────────────────────
  const pieCtx = document.getElementById('pieChart').getContext('2d');

  const pieLabels = breakdownData.map(d => d.action.charAt(0).toUpperCase() + d.action.slice(1));
  const pieCounts = breakdownData.map(d => d.count);

  new Chart(pieCtx, {
    type: 'doughnut',
    data: {
      labels: pieLabels,
      datasets: [{
        data: pieCounts,
        backgroundColor: pieColors.slice(0, breakdownData.length),
        borderWidth: 2,
        borderColor: '#ffffff',
        hoverOffset: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1e1b4b',
          titleColor: '#e0d9ff',
          bodyColor: '#c4b5fd',
          cornerRadius: 8,
          padding: 10,
          callbacks: {
            label: ctx => ` ${ctx.parsed} (${((ctx.parsed / pieCounts.reduce((a,b)=>a+b,0))*100).toFixed(1)}%)`
          }
        }
      }
    }
  });

  const legendEl = document.getElementById('pieLegend');
  pieLabels.forEach((label, i) => {
    const total = pieCounts.reduce((a, b) => a + b, 0);
    const pct   = total > 0 ? ((pieCounts[i] / total) * 100).toFixed(1) : 0;
    legendEl.innerHTML += `
      <div class="flex items-center justify-between text-sm">
        <div class="flex items-center gap-2">
          <span class="inline-block w-3 h-3 rounded-full" style="background:${pieColors[i]}"></span>
          <span class="text-gray-600">${label}</span>
        </div>
        <span class="text-gray-400 font-medium">${pct}%</span>
      </div>`;
  });

});
</script>