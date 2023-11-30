<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Panggil endpoint untuk mendapatkan data pengguna berdasarkan rolenya
        fetch('/user-role-count')
            .then(response => response.json())
            .then(userData => {
                // Gunakan data yang diperoleh untuk menggambar Pie Chart
                drawPieChart(userData);
            })
            .catch(error => {
                console.error('Error fetching user role count:', error);
            });

        // Fungsi untuk menggambar Pie Chart
        function drawPieChart(userData) {
            var ctx = document.getElementById('roleDistributionChart').getContext('2d');

            // Gambar Pie Chart
            var roleDistributionChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Admin', 'Guru', 'Siswa'],
                    datasets: [{
                        data: Object.values(userData),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(180, 180, 180, 0.8)'
                        ],
                        borderColor: [
                            'rgba(179, 255, 255, 0.8)',
                            'rgba(179, 255, 255, 0.8)',
                            'rgba(179, 255, 255, 0.8)'
                        ],
                        hoverOffset: 10,
                        // hoverBackgroundColor: 'red'
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Total Users'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                            }
                        },
                        datalabels: {
                            display: true,
                        },
                    },
                    animation: {
                        easing: 'easeOutBounce',
                        duration: 1000, // durasi animasi dalam milidetik
                    },
                },
            });
        }
    });
</script>
