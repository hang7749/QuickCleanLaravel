@extends('layouts.admin_app')

@section('title', 'Manage Members')

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
<div style="margin-bottom: 25px;">
    <h2 style="font-weight: 800;">Platform Members</h2>
    <p style="color: #64748b; font-size: 14px;">Total registered customers: {{ count($members) }}</p>
</div>

<div class="admin-section">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Email Address</th>
                    <th>Joined Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr>
                    <td>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-weight: 600;">{{ $member->name }}</span>
                            <span style="font-size: 12px; color: #64748b;">{{ $member->username ? '@' . $member->username : 'No username' }}</span>
                        </div>
                    </td>
                    <td style="color: #64748b;">{{ $member->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($member->created_at)->format('d M Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 15px;">
                            <a href="{{ route('admin.members.edit', $member->id) }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a>
                            
                            <button onclick="confirmDelete('{{ $member->id }}', '{{ $member->name }}')" style="color: #ef4444; background: none; border: none; cursor: pointer; font-weight: 600; padding: 0;">Delete</button>
                            
                            <form id="delete-form-{{ $member->id }}" action="{{ route('admin.members.destroy', $member->id) }}" method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        if(confirm('Are you sure you want to delete ' + name + '? This will remove all their booking history.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection