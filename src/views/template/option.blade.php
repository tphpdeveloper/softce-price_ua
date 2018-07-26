@foreach($categories as $category)
    @if(trim($prefix) != '')
        <?php
        $category->name = $prefix.' '.$category->name;
        ?>
    @endif
    <option value="{{ $category->id }}"
            @if($old && in_array($category->id, $old))
            selected
            @endif
    >
        {{ $category->name }}
    </option>
    @if($category->children->count())
        @include('hotline::tamplate.option', ['prefix' => $prefix.'-', 'categories' => $category->children ])
    @endif
@endforeach