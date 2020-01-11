<ul>
    @foreach ($collection as $menu_items)
<li><a href="{{$menu_items->link() }}">{{$menu_items->title}}</a></li>
    @endforeach

</ul>