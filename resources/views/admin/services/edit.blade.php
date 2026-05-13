@extends('layouts.admin_app')

@section('title', __('page.editService') . " | QuickClean Admin")

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
        <h2 style="font-weight: 800;">{{ __('page.editService') }}: {{ $service->name }}</h2>
    </div>

    <div style="background: #fff; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">{{ __('page.serviceName') }}</label>
                    <input type="text" name="name" value="{{ $service->name }}" required 
                           style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">{{ __('page.price') }} (RM)</label>
                    <input type="number" step="0.01" name="price" value="{{ $service->price }}" required 
                           style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">{{ __('page.imageURL') }}</label>
                <input type="text" name="image_url" id="image_url_input" value="{{ $service->image_url }}" 
                       placeholder="https://example.com/image.png"
                       style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: monospace; font-size: 13px;">
                
                @if($service->image_url)
                <div style="margin-top: 15px; padding: 10px; background: #f8fafc; border-radius: 8px; display: flex; align-items: center; gap: 15px;">
                    <img src="{{ $service->image_url }}" alt="Preview" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; background: #eee;">
                    <span style="font-size: 12px; color: #64748b;">{{ __('page.currentImagePreview') }}</span>
                </div>
                @endif
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">{{ __('page.description') }}</label>
                <textarea name="description" rows="5" 
                          style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; resize: vertical;">{{ $service->description }}</textarea>
            </div>

            <div style="display: flex; gap: 12px; border-top: 1px solid #f1f5f9; pt: 25px; margin-top: 20px; padding-top: 20px;">
                <button type="submit" style="background: #2563eb; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    {{ __('page.update') }}
                </button>
                <a href="{{ route('admin.services.index') }}" style="padding: 12px 30px; text-decoration: none; color: #64748b; font-weight: 600;">{{ __('page.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection