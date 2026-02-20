        
<?php 
//arreglo de icons KEY-VALUE
$links = [
   ['name' => 'DASHBOARD', 
   'icon' => 'fa-solid fa-gauge',
   'href' => route('admin.dashboard'),
   'active' => request()->routeIs('admin.dashboard'),
   ],
   [
      'header' => 'Administración',


   ],
   ['name' => 'Personas', 
   'icon' => 'fa-solid fa-users',
   'href' => route('admin.dashboard'),
   'active' => request()->routeIs('admin.dashboard'),
   ],

];


?>
<aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
      <a href="" class="flex items-center ps-2.5 mb-5">
         <img src="{{asset('images/Ejemplo.jpg')}}" class="h-6 me-3" alt="Healthify Logo" />
         <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Healthify</span>
      </a>
      <ul class="space-y-2 font-medium">
         @foreach ($links as $link)
         <li>
            {{---REVISA SI EXITE--}}
            @isset($link['header'])
            <div class="px-2 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
               {{$link['header']}}

            </div>
            @else
            
            <a href="{{$link['href']}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{$link['active'] ? 'bg-gray-100' : ''}}">
              <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500" >
            <i class="{{$link['icon']}}">
               </i> </span>

               
               <span class="ms-3">{{$link['name']}}</span>
            </a>@endisset

         </li>
         @endforeach

      </ul>
   </div>
</aside>