@extends('layouts.admin_app')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #fff;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
    }
    .stat-card .label { color: #64748b; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
    .stat-card .value { font-size: 28px; font-weight: 800; color: #1e293b; }
    .stat-card .trend { font-size: 12px; margin-top: 10px; color: #10b981; }

    .admin-section {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }
    .admin-table th {
        text-align: left;
        padding: 12px;
        border-bottom: 2px solid #f1f5f9;
        color: #64748b;
        font-size: 13px;
        text-transform: uppercase;
    }
    .admin-table td {
        padding: 16px 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }
    .status-pill {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }
    .status-confirmed { background: #dcfce7; color: #166534; }
    .status-pending { background: #fff8e1; color: #b45309; }
</style>
@endpush

@section('content')
    <div class="container-fluid">
        <h2 style="margin-bottom: 25px;">Dashboard Overview</h2>

        <div class="dashboard-grid">
            <div class="stat-card">
                <span class="label">TOTAL BOOKINGS</span>
                <span class="value">{{ $stats['total_bookings'] }}</span>
                <span class="trend">Live Data</span>
            </div>
            <div class="stat-card">
                <span class="label">ACTIVE MEMBERS</span>
                <span class="value">{{ $stats['active_members'] }}</span>
            </div>
            <div class="stat-card">
                <span class="label">SERVICE PROVIDERS</span>
                <span class="value">{{ $stats['total_providers'] }}</span>
            </div>
        </div>

        <div class="admin-section">
            <div class="section-header">
                <h3 style="font-size: 18px; font-weight: 700;">Recent Bookings</h3>
                <a href="{{ route('admin.bookings.index') }}" style="color: #2563eb; text-decoration: none; font-size: 14px; font-weight: 600;">View All</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Provider</th>
                            <th>Date/Time</th>
                            {{-- <th>Price</th> --}}
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                        <tr>
                            <td style="font-weight: 600;">{{ $booking->service_type }}</td>
                            <td>{{ $booking->provider_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} at {{ $booking->booking_time }}</td>
                            {{-- <td>RM {{ number_format($booking->total_price, 2) }}</td> --}}
                            <td>
                                <span class="status-pill status-{{ strtolower($booking->status) }}">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection