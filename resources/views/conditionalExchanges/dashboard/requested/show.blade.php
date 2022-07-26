<tr>
    <td>
        @foreach ($courseEnrollments as $fromShift)
          $course = $fromShift->course()->first();
          $toShift = $course->getShiftByTag($request->input('to_shift_tag_'.$course->name));
          <br>
          <small class="text-muted">
              From <strong>{{ $fromShift()->tag }}</strong>
              to <strong>{{ $toShift()->tag }}</strong>
          </small>
        @endforeach
    </td>
    <td class="text-right">
        <button v-delete-exchange="{{ $exchange }}" type="button" class="btn btn-link btn-sm"><span class="text-muted">Delete request</span></button>
    </td>
</tr>