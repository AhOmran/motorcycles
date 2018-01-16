<?php
namespace App\Http\Controllers;

use App\Motorcycle;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;

class MotorcyclesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $motorcycles = Motorcycle::with('media')->latest()->where('sold', 0)->paginate(20);

        return view('motorcycles.index', compact('motorcycles'));
    }

    public function show(Motorcycle $motorcycle)
    {
        return view('motorcycles.show', compact('motorcycle'));
    }

    public function mine()
    {
        $motorcycles = Motorcycle::with('media')->where('user_id', auth()->id())->latest()->paginate(20);

        return view('motorcycles.mine', compact('motorcycles'));
    }

    public function create()
    {
        return view('motorcycles.create', ['motorcycle' => new Motorcycle]);
    }

    public function store(Request $request)
    {
        try {
            $input = $this->getInput($request);

            $motorcycle = new Motorcycle($input);

            \DB::transaction(function () use ($motorcycle, $request) {
                $motorcycle->save();

                $this->addImages($request, $motorcycle);
            });
        } catch (\Exception $exception) {
            flash('Request failed, try again later.')->error();

            return redirect()->route('home');
        }

        flash('Record has been saved successfully.')->success();

        return redirect()->route('home');
    }

    public function edit(Motorcycle $motorcycle)
    {
        $this->authorize('update', $motorcycle);

        return view('motorcycles.edit', compact('motorcycle'));
    }

    public function update(Motorcycle $motorcycle, Request $request)
    {
        $this->authorize('update', $motorcycle);

        try {
            $this->deleteImages($request);

            $input = $this->getInput($request);

            \DB::transaction(function () use ($motorcycle, $request, $input) {
                $motorcycle->fill($input)->save();

                $this->addImages($request, $motorcycle);
            });
        } catch (\Exception $exception) {
            flash('Request failed, try again later.')->error();

            return redirect()->back();
        }

        flash('Record has been saved successfully.')->success();

        return redirect()->route('home');
    }

    public function destroy(Motorcycle $motorcycle)
    {
        $this->authorize('destroy', $motorcycle);

        $motorcycle->delete();

        flash('Record has been deleted successfully.')->success();

        return redirect()->back();
    }

    public function getInput(Request $request)
    {
        $input = $request->only('title', 'description', 'phone_number');
        $input['user_id'] = auth()->id();
        $input['sold'] = $request->has('sold');

        return $input;
    }

    public function addImages(Request $request, Motorcycle $motorcycle)
    {
        $uploadedImages = $request->file('images');

        if (!is_array($uploadedImages)) {
            return false;
        }

        foreach ($uploadedImages as $uploadedImage) {
            $motorcycle->addMedia($uploadedImage)->toMediaCollection();
        }

        return true;
    }

    public function deleteImages(Request $request)
    {
        $deletedImageIds = $request->get('deleted_image_ids');

        if (!is_array($deletedImageIds)) {
            return false;
        }

        foreach ($deletedImageIds as $imageId) {
            Media::findOrFail($imageId)->delete();
        }

        return true;
    }
}
