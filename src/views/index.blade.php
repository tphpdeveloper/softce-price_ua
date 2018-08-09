@extends('mage2-ecommerce::admin.layouts.app')

@section('content')
    <!-- general form elements disabled -->
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Выберите категории для выгрузки</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        {!! Form::open(['route' => 'admin.promua.create']) !!}
        <!-- Select multiple-->
            <div class="form-group">
                <label class="control-label">Выберите категорию *</label>
                <select name="product_category[]" multiple size="10" class="form-control">
                    <option value="" ></option>
                    @if($categories->count())
                        @include('promua::template.option', [
                            'categories' => $categories,
                            'prefix' => '',
                            'old' => old('product_category')
                        ])
                    @endif
                </select>
                @if($errors->has('product_category'))
                    <div class="alert-error">
                        {{ $errors->first('product_category') }}
                    </div>
                @endif
            </div>



            <div class="form-group">
                <button class="btn btn-success">Создать</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(File::exists(public_path('hotline.xml')))
                <a href="/public/promua.xml" download class="btn btn-success" target="_blank">Скачать файл</a>
            @endif
        </div>

    </div>


@stop