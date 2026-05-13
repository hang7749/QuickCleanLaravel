@extends('layouts.admin_app')

@section('title', __('page.newServiceProvider') . ' | QuickClean')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">{{ __('page.newServiceProvider') }}</h2>
    <div class="admin-section" style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <form action="{{ route('admin.providers.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('page.fullName') }}</label>
                <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('page.specialty') }}</label>
                <select name="specialty" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    @foreach($services as $s)
                        <option value="{{ $s->name }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('page.phone') }}</label>
                <input type="text" name="phone" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('page.imageURL') }}</label>
                <input type="text" name="image_url" placeholder="https://..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_available" checked>
                    <span style="font-weight: 600;">{{ __('page.available') }} / {{ __('page.notAvailable') }}</span>
                </label>
            </div>
            
            <div style="display: flex; gap: 10px;">
                 <button type="submit" style="flex: 1; background: #2563eb; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">{{ __('page.save') }}</button>
                <a href="{{ route('admin.providers.index') }}" style="flex: 1; text-align: center; background: #f1f5f9; color: #475569; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600;">{{ __('page.cancel') }}</a>
            </div>
            
           
        </form>
    </div>
</div>
@endsection