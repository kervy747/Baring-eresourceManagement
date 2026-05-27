<div class="bg-white rounded-md shadow-sm px-4 py-4 h-full">
  <p class="font-semibold text-lg mb-4">Books Uploaded per Month</p>
  <div class="relative h-80">  {{-- controls the height --}}
    <canvas id="booksChart"></canvas>
  </div>
</div>

<script>
  const ctx = document.getElementById('booksChart').getContext('2d');
  
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($booksByMonth->pluck('month')) !!},
      datasets: [{
        label: 'Books Uploaded',
        data: {!! json_encode($booksByMonth->pluck('count')) !!},
        backgroundColor: '#A78BFA',
        borderColor: '#6B49FF',
        borderWidth: 1,
        borderRadius: 5,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,  
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });
</script>