<?php

namespace Softce\Promua\Http\Controllers;

use Illuminate\Routing\Controller;
use Mage2\Ecommerce\Models\Database\Availability;
use Mage2\Ecommerce\Models\Database\Category;
use Mage2\Ecommerce\Models\Database\Configuration;
use Mage2\Ecommerce\Models\Database\ConfigurationCurrency;
use Softce\Promua\Http\Requests\PromuaRequest;

use File;
use MultipleCurrency;

class PromuaController extends Controller
{

    private $promua_string = '';

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
        //$configuration = Configuration::all()->pluck('configuration_value','configuration_key');

        //dd($configuration);

        if(!count($request->product_category)){
            return redirect()->back()->with('errorText', 'Выберите категории для выгрузки');
        }

        //get selected categories
        $categories = Category::whereIn('id', $request->product_category)->get();
        //get rate the site
        $current_currency = ConfigurationCurrency::where('main', '1')->first();
        //get availability data (Наличие)
        $availability = Availability::query()->pluck('name', 'id')->toArray();
        //get producers name
        //$producers = AttributeValue::where('attribute_id', 5)->pluck('name', 'id')->toArray();
        //generate string from tamplate
        $promua_template = view('promua::promua', [
            'configuration_currency' => $current_currency->name,
            'categories' => $categories,
            'rate' => $current_currency->rate,
            //'guaranty' => (is_null($request->product_war) ? null : $this->guaranties[$request->product_war]),
            'availability' => $availability,
            //'producers' => $producers
        ])->render();

        //write to file
        $name_file = 'promua.xml';
        $bytes_written = File::put(public_path('/'.$name_file), $promua_template);
        if ($bytes_written === false){
            return redirect()->back()->with('errorText', 'Ошибка записи в файл '.$name_file);
        }
        return redirect()->back()->with('notificationText', 'Файл '.$name_file.' успешно создан');
    }

}