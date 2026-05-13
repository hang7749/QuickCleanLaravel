@extends('layouts.admin_app')

@section('title', __('page.manageServices') . ' | QuickClean Admin')

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
    <h2 style="font-weight: 800;">{{ __('page.serviceList') }}</h2>
    <a href="{{ route('admin.services.create') }}" class="btn-add">+ {{ __('page.newService') }}</a>
</div>

<div class="admin-section">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>{{ __('page.serviceName') }}</th>
                    <th>{{ __('page.price') }}</th>
                    <th>{{ __('page.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="{{ $service->image_url ?? 'https://via.placeholder.com/40' }}" 
                                style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; background: #f1f5f9;">
                            <span style="font-weight: 600;">{{ $service->name }}</span>
                        </div>
                    </td>
                    <td style="color: #059669; font-weight: 700;">RM {{ number_format($service->price, 2) }}</td>
                    <td>
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <a href="{{ route('admin.services.edit', $service->id) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">{{ __('page.edit') }}</a>

                            <button type="button" 
                                    onclick="confirmDelete('{{ $service->id }}', '{{ $service->name }}')" 
                                    style="color: #ef4444; background: none; border: none; font-weight: 600; cursor: pointer; padding: 0;">
                                {{ __('page.delete') }}
                            </button>
                        </div>

                        <form id="delete-form-{{ $service->id }}" 
                            action="{{ route('admin.services.destroy', $service->id) }}" 
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
    function confirmDelete(id, name) {
        if (confirm('{{ __('page.confirmDeleteService') }}')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>