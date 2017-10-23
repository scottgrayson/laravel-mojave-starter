@php
  // Example use (send these as args with blade include)

  /*
  $steps = [
    'Upload requested documents.',
    'Waiting on approval...',
    'Approved!',
  ];

  $currentStep = 1;
   */
 @endphp

 <div class="d-flex align-items-center">
   @foreach ($steps as $step)
     <div class="h2">
       @if(isset($step['href']) && $currentStep > $loop->iteration)
         <a href="{{ $step['href'] }}" class="badge badge-{{ $currentStep >= $loop->iteration ? 'primary' : 'secondary' }} badge-pill">
           {{ $loop->iteration }}
         </a>
       @else
         <span class="badge badge-{{ $currentStep >= $loop->iteration ? 'primary' : 'secondary' }} badge-pill">
           {{ $loop->iteration }}
         </span>
       @endif
     </div>

     @if (!$loop->last)
       <div class="col">
         <hr>
       </div>
     @endif
   @endforeach
 </div>

 <br>

 <h3 class="text-muted text-center">
   {{ $steps[$currentStep - 1]['label'] }}
 </h3>
