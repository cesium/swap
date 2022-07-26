@extends('layouts.app')

@section('content')

<div class="card card--section">
        <div class="card-header">Propose a new shift exchange</div>
        <div class="card-body">
            <form method="post" action="{{ route('conditionalExchange.store', $student->id) }}">
                {{ csrf_field() }}
                @foreach (array_keys($courseEnrollments) as $course)
                {{-- FromCourse--}}
                <p>{{$course}}</p>
                <p>{{"to_shift_tag_".str_replace(" ","",$course)}}</p>
                {{-- From enrollment--}}
                <div class="form-group">
                    <label>From enrollment</label>
                    <input type="text"
                    class="form-control {{ $errors->has('from_enrollment_'.$course) ? 'is-invalid' : '' }}"
                    value="{{ $courseEnrollments[$course]['fromEnrollment']->present()->inlineToString() }}"
                    required readonly>
                    <div class="form-text text-danger">{{ $errors->first('from_enrollment_'.$course) }}</div>
                </div>
                {{-- To shift--}}
                <div class="form-group">
                    <label>To Shift <label>
                    <shift-select name= {{"to_shift_tag_".str_replace(" ","",$course)}} :options="{{ $courseEnrollments[$course]['matchingShifts']}}"></shift-select>
                    <div class="form-text text-danger">{{ $errors->first("to_shift_tag_".str_replace(" ","",$course)) }}</div>
                </div>
                <br>
                @endforeach
                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">Request exchange</button>
            </form>
        </div>
    </div>
@endsection