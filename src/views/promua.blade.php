<?php echo '<?xml version="1.0" encoding="UTF-8" ?>
'; ?>
<catalog>
<currency code="{{ $configuration_currency }}" rate="{{ $rate }}" />
@if($categories)
@foreach($categories as $category)
<category id="{{ $category->id }}" @if($category->parent_id) parentId="{{ $category->parent_id }}" @endif>
    {{ $category->name }}
</category>
@endforeach
@endif
    <items>
    @if($categories)
    @foreach($categories as $category)
        <?php
        $products = $category->products()->with(['attributes','attributeValue'])->chunk(100, function($products) use ($category, $rate, $availability) {
            if (count($products)) {
                foreach ($products as $product) {
                    $name_producer = $product->attributeValue()->wherePivot('attribute_id', 5)->first();
                    ?>
        <item id="{{ $product->id }}" selling_type="u">
            <name>{{ $product->name }}</name>
            <categoryId>{{ $category->id }}</categoryId>
            <price>{{ MultipleCurrency::setRate()->price($product->price) }}</price>

                        @if($product->price > $product->price_discount)
            <prices>
                <price>
                    <value>{{ MultipleCurrency::setRate()->price($product->price_discount) }}</value>
                    <quantity>{{ $product->qty }}</quantity>
                </price>
            </prices>
                        @endif
            <image>{{ asset($product->image->relativePath) }}</image>
            <vendorCode>{{ $product->sku }}</vendorCode>
                        @if($product->attributes && $product->attributeValue)
                            <?php
                            foreach($product->attributes as $attribute){
                                foreach($product->attributeValue as $attributeValue){
                                    if($attribute->id == $attributeValue->attribute_id){
                                        ?>
            <param name="{{ $attribute->name }}"> {{ $attributeValue->name }} </param>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        @endif
            <description><![CDATA[ {{ $product->description }} ]]></description>

            <available> @switch($product->in_stock)
                @case(1) true @break
                @case(2) @break
                @case(3) false @break
                @endswitch </available>

        </item>
                    <?php
                }
            }
        });
        ?>
    @endforeach
    @endif
    </items>
</catalog>