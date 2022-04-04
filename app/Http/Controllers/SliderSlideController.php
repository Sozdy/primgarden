<?php

namespace App\Http\Controllers;

use App\SliderSlide;
use Illuminate\Http\Request;

class SliderSlideController extends Controller
{
    public function index()
    {
        return response()->json(SliderSlide::all());
    }

    public function update1c (Request $request) {
        foreach ($request->slides as $item) {
            $slide = SliderSlide::whereId($item["id"])->first() ?? new SliderSlide();

            $slide->id                       =   $item["id"];
            $slide->is_active                = ! $item["markDelete"];
            $slide->link                     =   $item["link"];
            $slide->image_id                 =   $item["image_id"];
            $slide->order                    =   $item["order"];

            $slide->save();
        }

        return response("success", 200);
    }

    public function getSlides()
    {
        return SliderSlide::where("is_active", "1")->orderBy("order", "asc")->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SliderSlide  $sliderSlide
     * @return \Illuminate\Http\Response
     */
    public function show(SliderSlide $sliderSlide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SliderSlide  $sliderSlide
     * @return \Illuminate\Http\Response
     */
    public function edit(SliderSlide $sliderSlide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SliderSlide  $sliderSlide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SliderSlide $sliderSlide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SliderSlide  $sliderSlide
     * @return \Illuminate\Http\Response
     */
    public function destroy(SliderSlide $sliderSlide)
    {
        //
    }
}
