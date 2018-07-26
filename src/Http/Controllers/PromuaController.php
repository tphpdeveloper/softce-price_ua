<?php

namespace Softce\Promua\Http\Controllers;

use Mage2\Ecommerce\Http\Controllers\Admin\AdminController;
use Mage2\Ecommerce\Models\Database\Configuration;
use Mage2\Ecommerce\Models\Database\Category;
use Softce\Promua\Http\Requests\PromuaRequest;
use Softce\Promua\Http\Requests\TypeRequest;
use File;
use DB;

class PromuaController extends AdminController
{

    public function __construct()
    {
        $this->middleware(['admin.auth']);
    }

    /**
     * Show form for select category
     * @return type
     */
    public function show(){
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('promua::index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Write info to the promua.xml file
     * @param PromuaRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function create(PromuaRequest $request){

        dd($request->all());

        //get selected categories
        $categories = Category::whereIn('id', $request->product_category)->get();
        //get rate the site
        $current_currency = ConfigurationCurrency::where('main', '1')->first();
        //get availability data (Наличие)
        $availability = Availability::query()->pluck('name', 'id')->toArray();
        //get producers name
        //$producers = AttributeValue::where('attribute_id', 5)->pluck('name', 'id')->toArray();
        //generate string from tamplate
        $hotline_template = view('hotline::hotline', [
            'magazine_key' => $magazine_key,
            'categories' => $categories,
            'rate' => $current_currency->rate,
            'guaranty' => (is_null($request->product_war) ? null : $this->guaranties[$request->product_war]),
            'availability' => $availability,
            //'producers' => $producers
        ])->render();
        //write to file
        $name_file = 'hotline.xml';
        $bytes_written = File::put(public_path('/'.$name_file), $hotline_template);
        if ($bytes_written === false){
            return redirect()->back()->with('errorText', 'Ошибка записи в файл '.$name_file);
        }
        return redirect()->back()->with('notificationText', 'Файл '.$name_file.' успешно создан');
    }

}