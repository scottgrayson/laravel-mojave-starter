<div class="d-flex mb-2">
  <div>
    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#filters" aria-expanded="false" aria-controls="filters">
      Filters
    </button>
    @if(request()->query())
      <?php
        $query = array_filter(request()->query());
        $flipped = array_flip($query);
        $applied = collect($query)->reduce(function ($acc, $i) use ($flipped) {
          if ($key = isset($flipped[$i]) ? $flipped[$i] : false) {
            if (strpos($key, 'q_') !== false) {
              $key = str_replace('q_', '', $key);
            }
            return array_merge($acc, ["{$key}={$i}"]);
          }
        }, []);
      ?>
      <span class="pl-1 text-muted d-none d-md-inline">
        Applied:
        @foreach ($applied as $a)
          <span style="font-size:85%" class="badge text-muted badge-pill badge-light">
            {{ $a }}
          </span>
        @endforeach
      </span>
    @endif
  </div>
  <div class="ml-auto">
    @if ($orderable)
      <a href="{{ '/' . request()->path() . '/order' }}"
        class="btn btn-secondary">
        Reorder
      </a>
    @endif
    @if (\Route::has('admin.'.$slug.'.create'))
      <a href="{{ '/' . request()->path() . '/create' }}"
        class="btn btn-primary">
        New
      </a>
    @endif
  </div>
</div>

<div class="collapse mb-2" id="filters">
  @include('admin.partials.filters', $cols)
</div>

@if(!$items->count())
  <div class="alert alert-info">
    No Results
  </div>
@else
  <table class="table table-bordered table-responsive-md">

    <thead class="bg-dark">
      <tr>
        @foreach ($cols as $c)
          <th>
            @php
              $c = str_replace('_id', '', $c);
              $currentOrder = $sort === $c ? $order : '';
              $nextOrder = $currentOrder === 'asc' ? 'desc' : 'asc';
              $sortLink = '/' . request()->path() . '?' . http_build_query(array_merge(
                request()->query(),
                ['sort' => $c, 'order' => $nextOrder]
              ));
            @endphp
            <a class="d-inline-flex align-items-center text-white" href="{{ $sortLink }}">
              {{ title_case(str_replace('_', ' ', preg_replace('/(_id)|(_at)$/', '', $c))) }}
              @if($currentOrder === 'asc')
                @svg('arrow-bottom', 'ml-1 sm s4')
              @else
                @svg('arrow-top', 'ml-1 sm s4')
              @endif
            </a>
          </th>
        @endforeach
        <th class="text-muted">Actions</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($items as $i)
        <tr>
          @foreach ($cols as $k)
            @include('display.value', ['k' => $k, 'v' => $i->$k, 'item' => $i])
          @endforeach
          <td>
            <div class="d-flex">
              @if (\Route::has('admin.'.$slug.'.show'))
                <a target="_blank" rel="noopener norefferer" href="{{ route('admin.'.$slug.'.show', $i->id) }}"
                  class="btn btn-icon">
                  @svg('eye')
                </a>
              @endif
              @if (\Route::has('admin.'.$slug.'.edit'))
                <a href="{{ '/' . request()->path() . '/' . $i->id . '/edit' }}"
                  class="btn btn-icon">
                  @svg('edit')
                </a>
              @endif
              @if (\Route::has('admin.'.$slug.'.destroy'))
                <a href="{{ route('admin.'.$slug.'.destroy', $i->id) }}"
                  data-method="delete"
                  class="btn btn-icon">
                  @svg('trash', 'text-top')
                </a>
              @endif
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {!! $items->links('vendor.pagination.bootstrap-4') !!}
@endif
