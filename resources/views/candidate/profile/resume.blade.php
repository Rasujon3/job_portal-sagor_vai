@extends('candidate.profile.index')
@section('section')
<div class="d-flex flex-column ">
    <livewire:resume-table lazy/>
    @include('candidate.profile.modals.upload_resume_modal')
</div>

@endsection
