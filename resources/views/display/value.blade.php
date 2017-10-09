<td>
  @php
    if (preg_match('/_id$/', $k)) {
      $relationAttribute = camel_case(preg_replace('/_id/', '', $k));
      $related = $item->$relationAttribute;
      echo $related ? $related->label : '';
      /*
      } else if (preg_match('/^\d{4}/', $v)) {
      try {
        echo \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v)->format('m-d-y');
      } catch (\Exception $e) {}
        */
    } else if (is_bool($v)) {
      echo $v ? 'yes' : 'no';
    } else {
      echo $v;
    }
  @endphp
</td>
