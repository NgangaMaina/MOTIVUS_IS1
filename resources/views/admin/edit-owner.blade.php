@extends('layouts.admin')

@section('content')
<div class="admin-page">
    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Edit Owner Profile</h1>
            <p class="page-subtitle">Update details for owner: <b>{{ $owner->name }}</b></p>
        </div>
        <form method="POST" action="#" class="owner-edit-form" style="max-width:500px;margin:0 auto;background:#fff;padding:32px 24px;border-radius:16px;box-shadow:0 4px 18px rgba(0,0,0,0.07);">
            @csrf
            <div class="form-group" style="margin-bottom:18px;">
                <label for="name" style="font-weight:600;">Name</label>
                <input type="text" id="name" name="name" value="{{ $owner->name }}" class="form-input" style="width:100%;padding:10px;border-radius:8px;border:1.5px solid #00d4ff;">
            </div>
            <div class="form-group" style="margin-bottom:18px;">
                <label for="email" style="font-weight:600;">Email</label>
                <input type="email" id="email" name="email" value="{{ $owner->email }}" class="form-input" style="width:100%;padding:10px;border-radius:8px;border:1.5px solid #00d4ff;">
            </div>
            <div class="form-group" style="margin-bottom:18px;">
                <label for="phone" style="font-weight:600;">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ $owner->phone }}" class="form-input" style="width:100%;padding:10px;border-radius:8px;border:1.5px solid #00d4ff;">
            </div>
            <button type="submit" class="btn btn-primary" style="background:linear-gradient(90deg,#00d4ff,#0099cc);color:#fff;font-weight:600;border:none;border-radius:8px;padding:12px 32px;font-size:1.1rem;margin-top:8px;cursor:pointer;">Update Owner</button>
        </form>
    </div>
</div>
@endsection
