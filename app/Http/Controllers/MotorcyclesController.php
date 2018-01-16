<?php
namespace App\Http\Controllers;

use App\Motorcycle;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;

class MotorcyclesController extends Controller
{
    /**
     * MotorcyclesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * List all motorcycles
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $motorcycles = Motorcycle::with('media')->latest()->where('sold', 0)->paginate(20);

        return view('motorcycles.index', compact('motorcycles'));
    }

    /**
     * Show motorcycle.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if (\Cache::has('views-motorcycles-show-' . $id)) {
            return \Cache::get('views-motorcycles-show-' . $id);
        }

        return view('motorcycles.show', ['motorcycle' => Motorcycle::findOrFail($id)]);
    }

    /**
     * List current user motorcycles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mine()
    {
        $motorcycles = Motorcycle::with('media')->where('user_id', auth()->id())->latest()->paginate(20);

        return view('motorcycles.mine', compact('motorcycles'));
    }

    /**
     * Show form to create a new motorcycle.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('motorcycles.create', ['motorcycle' => new Motorcycle]);
    }

    /**
     * Persist new motorcycle into database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Show form to edit motorcycle.
     *
     * @param Motorcycle $motorcycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Motorcycle $motorcycle)
    {
        $this->authorize('update', $motorcycle);

        return view('motorcycles.edit', compact('motorcycle'));
    }

    /**
     * Update motorcycle.
     *
     * @param Motorcycle $motorcycle
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Delete motorcycle from database.
     *
     * @param Motorcycle $motorcycle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Motorcycle $motorcycle)
    {
        $this->authorize('destroy', $motorcycle);

        $motorcycle->delete();

        flash('Record has been deleted successfully.')->success();

        return redirect()->back();
    }

    /**
     * Get array of all valid inputs.
     *
     * @param Request $request
     * @return array
     */
    public function getInput(Request $request)
    {
        $input = $request->only('title', 'description', 'phone_number');
        $input['user_id'] = auth()->id();
        $input['sold'] = $request->has('sold');

        return $input;
    }

    /**
     * Store motorcycle images.
     *
     * @param Request $request
     * @param Motorcycle $motorcycle
     * @return bool
     */
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

    /**
     * Delete images.
     *
     * @param Request $request
     * @return bool
     */
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
