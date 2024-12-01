<div>
    <div class="text-sm breadcrumbs">
        <ul>

        @foreach ($routes as $route)
        @if(isset($route['name']) )
            <li><a href="{{ route($route['name']) }}">{{ $route['label'] }}</a></li>
        @else
          <li>{{ $route['label'] }}</li>
        @endif
        @endforeach

        </ul>
      </div>
</div>
