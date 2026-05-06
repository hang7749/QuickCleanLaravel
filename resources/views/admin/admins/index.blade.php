@extends('layouts.admin_app')

@section('title', 'Admin List')

@push('styles')
<style>
    .admin-section { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0; }
    .btn-add { background: #2563eb; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; }
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { text-align: left; padding: 12px; background: #f8fafc; border-bottom: 2px solid #edf2f7; color: #64748b; font-size: 12px; }
    .admin-table td { padding: 15px 12px; border-bottom: 1px solid #edf2f7; }
</style>
@endpush


@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h2 style="font-weight: 800;">Administrator List</h2>
    <a href="{{ route('admin.admins.create') }}" 
       style="background: #0f172a; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">+ Add New Admin</a>
</div>

<div class="admin-section">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Admin Name</th>
                    <th>Email</th>
                    <th>Role</th>

                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #dcfce7; color: #166534; padding: 5px; border-radius: 5px; font-size: 10px; font-weight: 800;">STAFF</span>
                            <span style="font-weight: 600;">{{ $admin->name }}</span>
                        </div>
                    </td>
                    <td>{{ $admin->email }}</td>
                    <td><span style="text-transform: capitalize;">{{ $admin->role }}</span></td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        if(confirm('Are you sure you want to remove ' + name + ' as an admin?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection