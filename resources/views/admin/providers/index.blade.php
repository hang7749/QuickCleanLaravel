@extends('layouts.admin_app')

@section('title', __('page.serviceProviders') . ' | QuickClean')

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
    <h2 style="font-weight: 800;">{{ __('page.serviceProviders') }}</h2>
    <a href="{{ route('admin.providers.create') }}" 
       style="background: #2563eb; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">+ {{ __('page.newServiceProvider') }}</a>
</div>

<div class="admin-section">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>{{ __('page.provider') }}</th>
                    <th>{{ __('page.specialty') }}</th>
                    <th>{{ __('page.phone') }}</th>
                    <th>{{ __('page.status') }}</th>
                    <th>{{ __('page.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($providers as $p)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img src="{{ $p->image_url ?? 'https://ui-avatars.com/api/?name='.urlencode($p->name) }}" 
                                 style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                            <span style="font-weight: 600;">{{ $p->name }}</span>
                        </div>
                    </td>
                    <td><span style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-size: 12px;">{{ $p->specialty }}</span></td>
                    <td>{{ $p->phone ?? 'N/A' }}</td>
                    <td>
                        @if($p->is_available)
                            <span style="color: #059669; font-size: 13px;">● {{ __('page.available') }}</span>
                        @else
                            <span style="color: #ef4444; font-size: 13px;">● {{ __('page.notAvailable') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.providers.edit', $p->id) }}" style="color: #2563eb; text-decoration: none; font-weight: 600; margin-right: 10px;">{{ __('page.edit') }}</a>
                        <button onclick="confirmDelete('{{ $p->id }}', '{{ $p->name }}')" style="color: #ef4444; background: none; border: none; cursor: pointer; font-weight: 600;">{{ __('page.delete') }}</button>
                        <form id="delete-form-{{ $p->id }}" action="{{ route('admin.providers.destroy', $p->id) }}" method="POST" style="display:none;">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        if(confirm('{{ __('page.confirm') }}: {{ __('page.delete') }} ' + name + '?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection