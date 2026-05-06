@extends('layouts.admin_app')

@section('title', 'Manage Bookings')
@push('styles')
<style>
    /* Section Container */
    .admin-section {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid #e2e8f0;
    }

    /* Table Styling */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .admin-table th {
        text-align: left;
        padding: 12px 15px;
        background: #f8fafc;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 2px solid #edf2f7;
    }

    .admin-table td {
        padding: 15px;
        border-bottom: 1px solid #edf2f7;
        font-size: 14px;
        color: #1e293b;
        vertical-align: middle;
    }

    /* Status Pills */
    .status-pill {
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        text-align: center;
        min-width: 90px;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dcfce7; color: #166534; }
    .status-completed { background: #e0f2fe; color: #075985; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    /* Responsive Wrapper */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .action-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .action-link:hover {
        color: #1e40af;
        text-decoration: underline;
    }
</style>
@endpush
@section('content')
<div class="section-header" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
    <h2 style="font-size: 24px; font-weight: 800;">All Bookings</h2>
</div>

<div class="admin-section">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Provider</th>
                    <th>Schedule</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td style="font-weight: 600;">{{ $booking->created_at }}</td>
                    <td style="font-weight: 600;">{{ $booking->service_type }}</td>
                    <td>{{ $booking->provider_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M') }}, {{ $booking->booking_time }}</td>
                    <td style="font-weight: 700;">RM {{ number_format($booking->total_price, 2) }}</td>
                    <td>
                        <span class="status-pill status-{{ strtolower($booking->status) }}">
                            {{ strtoupper($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" style="color: #2563eb; font-weight: 600; text-decoration: none; font-size: 13px;">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection