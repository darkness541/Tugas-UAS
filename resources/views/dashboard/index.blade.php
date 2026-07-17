<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4 bg-primary text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-3">
                        <i class='bx bx-pie-chart-alt-2 me-2'></i>
                        Dashboard Inventaris
                    </h3>
                    <p class="mb-0 fs-5">
                        Ringkasan performa stok barang dan nilai valuasi gudang Anda saat ini.
                    </p>
                    <p class="mt-2 opacity-75 small">
                        <i class='bx bx-time-five me-1'></i>
                        Pembaruan Terakhir: {{ now()->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                    </p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class='bx bx-buildings' style="font-size: 6rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Items -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 border-start border-primary border-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Barang (Item)</p>
                            <h2 class="fw-bold mb-0 text-primary">{{ number_format($totalItems, 0, ',', '.') }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-box fs-1 text-primary'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 py-3">
                    <a href="{{ route('item.index') }}" class="text-primary text-decoration-none small fw-semibold">
                        Lihat Data Barang <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Valuation -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 border-start border-success border-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Valuasi Stok</p>
                            <h3 class="fw-bold mb-0 text-success">Rp {{ number_format($totalValuation, 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-wallet fs-1 text-success'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 py-3">
                    <small class="text-muted fw-semibold">
                        *Estimasi nilai seluruh barang di gudang.
                    </small>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 border-start border-danger border-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Peringatan Stok Menipis</p>
                            <h2 class="fw-bold mb-0 text-danger">{{ $lowStockItems->count() }} <span class="fs-6 text-muted fw-normal">Barang</span></h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-error-circle fs-1 text-danger'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 py-3">
                    <a href="#lowStockTable" class="text-danger text-decoration-none small fw-semibold">
                        Lihat Detail Peringatan <i class='bx bx-down-arrow-alt'></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Main Chart -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">
                        <i class='bx bx-line-chart me-2 text-primary'></i>
                        Tren Transaksi (30 Hari Terakhir)
                    </h6>
                    <span class="badge bg-light text-dark border">Kuantitas Barang</span>
                </div>
                <div class="card-body">
                    <div id="transactionsChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Low Stock Table -->
        <div class="col-lg-4" id="lowStockTable">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-danger">
                        <i class='bx bx-error me-2'></i>
                        Barang Kritis (Butuh Restock)
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($lowStockItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Barang</th>
                                        <th class="text-center">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockItems as $item)
                                        <tr>
                                            <td class="ps-3">
                                                <div class="fw-bold text-dark">{{ Str::limit($item->name, 20) }}</div>
                                                <div class="small text-muted">{{ $item->sku }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                                    {{ $item->current_stock }} / {{ $item->minimum_stock }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class='bx bx-check-shield text-success' style="font-size: 4rem;"></i>
                            <h6 class="mt-3 text-muted">Semua stok aman!</h6>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-top text-center py-3">
                    <a href="{{ route('item.index') }}" class="btn btn-sm btn-outline-primary">Kelola Barang</a>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
    <!-- ApexCharts is included globally in app.blade.php as per niceadmin theme -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            var chartDates = {!! json_encode($chartDates) !!};
            var chartDataIn = {!! json_encode($chartDataIn) !!};
            var chartDataOut = {!! json_encode($chartDataOut) !!};

            new ApexCharts(document.querySelector("#transactionsChart"), {
                series: [{
                    name: 'Barang Masuk (IN)',
                    data: chartDataIn
                }, {
                    name: 'Barang Keluar (OUT)',
                    data: chartDataOut
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'Nunito, sans-serif'
                },
                markers: {
                    size: 4
                },
                colors: ['#198754', '#dc3545'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: chartDates,
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Kuantitas (Pcs)'
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0) + " pcs";
                            }
                            return y;
                        }
                    }
                }
            }).render();
        });
    </script>
    @endpush

</x-app>
