<?php

namespace Softce\Slider\Http\Controllers;

use Mage2\Ecommerce\Http\Controllers\Admin\AdminController;
use Softce\Slider\Http\Requests\SlideRequest;
use Softce\Slider\Http\Requests\TypeRequest;
use Softce\Slider\Module\Slider;
use File;
use DB;

class PriceuaController extends AdminController
{

    private $path_slide = '';

    public function __construct()
    {
        $this->middleware(['admin.auth']);
        $this->path_slide = 'uploads/slider';
    }

    /**
     * Show list slide
     */
    public function index()
    {
        return view('slider::admin-slide')
            ->with('slides', Slider::all())
            ->with('path_slide', $this->path_slide);
    }

    /**
     * Create new slide
     * @param SlideRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SlideRequest $request)
    {
        $new_slide = $request->file('new_slide');

        if($new_slide) {
            foreach($new_slide as $slide) {
                $name_file = $slide->getClientOriginalName();
                $slide->move(public_path($this->path_slide), $name_file);
                Slider::create([
                    'path' => $name_file
                ]);
            }

            return redirect()->route('admin.slider.index')->with('notificationText', 'Слайд(и) успешно добавлен(и)');
        }

        return redirect()->route('admin.slider.index')->with('errorText', 'Для создания слайд(а/ов) нужно изображение');
    }

    /**
     * Update slide
     * @param SlideRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SlideRequest $request, $id)
    {
        $slide = Slider::find($id);
        if($slide){
            $new_slide = $request->file('slide');
            $data = $request->except(['_token', 'slide']);


            if($new_slide){
                File::delete(public_path($this->path_slide.'/'.$slide->path));

                $name_file = $new_slide->getClientOriginalName();
                $new_slide->move(public_path($this->path_slide), $name_file);
                $data['path'] = $name_file;
            }
            $slide->update($data);

            return redirect()->route('admin.slider.index')->with('notificationText', 'Слайд успешно обновлен');
        }
        return redirect()->route('admin.slider.index')->with('errorText', 'Ошибка обновления слайда. Повторите запрос позже!!!');
    }

    /**
     * Delete slide
     * @param $id_slide
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id_slide)
    {
        $slide = Slider::find($id_slide);
        if($slide){
            File::delete(public_path($this->path_slide.'/'.$slide->path));
            $slide->delete();
            return redirect()->route('admin.slider.index')->with('notificationText', 'Слайд успешно удален');
        }
        return redirect()->route('admin.slider.index')->with('errorText', 'Ошибка удаления слайда. Повторите запрос позже!!!');
    }

}