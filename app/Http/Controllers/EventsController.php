<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Dcp;
use App\Models\Category;
use App\Models\EventCategory;
use App\Models\Event;
use App\Models\Location;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// TODO Erro quando tem orders e se edita a start date, e a order fica com a date depois da start date
class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::join('location', 'event.location', '=', 'location.location_id')->join('district_county_parish', 'location.dcp_id', '=', 'district_county_parish.dcp_id')->orderBy('start_date', 'ASC')->get()->take(18);
        $categories = Category::all()->take(4);

        foreach ($events as $event) {
            $event['categories'] = EventCategory::where('event_category.event_id', '=', $event->event_id)->join('category', 'event_category.event_category_id', '=', 'category.category_id')->get(['event_category.event_category_id', 'category.name', 'category.icon_label']);
        }

        //return $events->categories;
        return view('pages.events', ['events' => $events, 'categories' => $categories]);
    }

    public function form()
    {
        $this->authorize('view', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        $dcp = DB::table('district_county_parish')
            ->select('district')->distinct('district')
            ->get();

        $categories = $this->getAllCategories();

        return view('pages.event_post_crud', ['districts' => $dcp, 'categories' => $categories]);
    }

    public function getCounties(Request $request)
    {
        if (Auth::check() && Auth::user()->isEditor()) {
            $counties = Dcp::where('district', '=', $request->district)->distinct('county')->get('county');
            return ['counties' => $counties];
        }
        return abort(403);
    }

    public function getParishes(Request $request)
    {
        if (Auth::check() && Auth::user()->isEditor()) {
            $parishes = Dcp::where('district', '=', $request->district)->where('county', "=", $request->county)->get(['dcp_id', 'parish']);
            return ['parishes' => $parishes];
        }
        return abort(403);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allIndex()
    {
        $events = Event::join('location', 'event.location', '=', 'location.location_id')->join('district_county_parish', 'location.dcp_id', '=', 'district_county_parish.dcp_id')->orderBy('start_date', 'ASC')->get(['event.*', 'district_county_parish.*']);

        return view('pages.all_events', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Event::class);

        //TODO FALTA CATEGORIA
        if (!$this->validateRequest($request)  || !$request->hasFile('image_path')) {
            return redirect('/event_post_crud?error');
        }

        $eventPost = new Event();
        $eventPost->name = $request->input('name');
        $eventPost->start_date = $request->input('start_date');
        $eventPost->end_date = $request->input('end_date');
        $eventPost->price = $request->input('price');
        $eventPost->image_path = $this->uploadImg($request, $eventPost);
        $eventPost->description = $request->input('description');
        $location = new Location();
        $location->address = $request->input('address');
        $location->zip_code = $request->input('zip_code');
        $location->dcp_id = $request->input('parish'); //$request->input('location');
        $location->save();
        $eventPost->location = $location->location_id;
        $eventPost->editor = Auth::user()->user_id;
        $eventPost->save();
        return redirect('/event/' . $eventPost->event_id . '/?CreateEvent="success"');
    }

    public function validateRequest(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'phone' => 'required|regex:/^\d{4}(?:[-\s]\d{3})?$/'
                'name' => 'required|string|min:1',
                'address' => 'required|string|min:3',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'price' => 'numeric|min:0',
                'dcp_id' => 'integer|min:0',
                'description' => 'required|string|min:1',
                'zip_code' => 'required|regex:/^\d{4}(-\d{3})?$/'
                // 'job' => 'required|string|min:1',
                // 'description' => 'required|string|min:1',
            ]
        );
        if ($validator->fails()) {
            return false;
        }

        return true;
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
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $event = Event::join('location', 'event.location', '=', 'location.location_id')
            ->join('district_county_parish', 'location.dcp_id', '=', 'district_county_parish.dcp_id')->get()->find($id);

        return view('pages.event', ['event' => $event]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function showFromCategory(int $category_id)
    {
        $category = Category::find($category_id);
        $category_name = $category->name;
        $events = EventCategory::where('event_category_id', '=', $category->category_id)->join('event', 'event_category.event_id', '=', 'event.event_id')
            ->join('category', 'event_category.event_category_id', '=', 'category.category_id')
            ->join('location', 'location.location_id', '=', 'event.location')
            ->join('district_county_parish', 'district_county_parish.dcp_id', '=', 'location.dcp_id')
            ->distinct('event.event_id')->get(['event.*', 'district_county_parish.*']);

        return view('pages.all_events', ['events' => $events, 'category_name' => $category_name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        $event = Event::join('location', 'event.location', '=', 'location.location_id')->join('district_county_parish', 'location.dcp_id', '=', 'district_county_parish.dcp_id')->get()->find($id);
        $districts = DB::table('district_county_parish')
            ->select('district')->distinct('district')
            ->get();

        $counties = DB::table('district_county_parish')
            ->select('county')->where('district', "=", $event->district)->distinct('county')
            ->get();


        $parishes = DB::table('district_county_parish')
            ->select('parish', 'dcp_id')->where('district', "=", $event->district)
            ->where('county', "=", $event->county)->distinct('parish')
            ->get();

        $categories = $this->getAllCategories();
        $event['categories'] = EventCategory::where('event_category.event_id', '=', $event->event_id)->join('category', 'event_category.event_category_id', '=', 'category.category_id')->get(['event_category.event_category_id', 'category.name', 'category.icon_label']);


        for ($i = 0; $i < count($categories); $i++) {
            $found = false;
            for ($j = 0; $j < count($event['categories']); $j++) {
                if ($categories[$i]->name == $event['categories'][$j]->name) {
                    $found = true;
                }
            }
            if ($found == true) {
                $categories[$i]['found'] = true;
            } else {
                $categories[$i]['found'] = false;
            }
        }
        return view('pages.event_post_crud', ['event' => $event, 'districts' => $districts, 'counties' => $counties, 'parishes' => $parishes, 'categories' => $categories]);
    }

    public function getAllCategories()
    {
        return EventCategory::join('category', 'event_category.event_category_id', '=', 'category.category_id')->distinct('category.category_id')->get(['category.category_id', 'category.name']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $eventPost = Event::find($id);
        //$this->authorize('update', $eventPost);

        $eventPost->start_date = $request->input('start_date');
        $eventPost->end_date = $request->input('end_date');
        $eventPost->price = $request->input('price');
        $eventPost->name = $request->input('name');
        $eventPost->image_path = $this->uploadImg($request, $eventPost);

        $eventPost->description = $request->input('description');

        $location = new Location();
        $location->address = $request->input('address');
        $location->zip_code = $request->input('zip_code');
        $location->dcp_id = $request->input('parish'); //$request->input('location');
        $location->save();

        $eventPost->location = $location->location_id; //$request->input('location');
        $eventPost->editor = Auth::user()->user_id;
        $eventPost->save();
        return redirect('/event/' . $eventPost->event_id . '/?UpdateEvent="success"');
    }

    public function uploadImg(Request $request, $eventPost)
    {
        if ($request->hasFile('image_path')) {

            $filename = $request->image_path->getClientOriginalName();
            $request->image_path->storeAs('images', $filename, 'public');
            return $filename;
        } else return $eventPost->image_path;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        $event = Event::find($id);
        $event->delete();
        return $event->event_id;
    }

    public function dateTimeLocal($date)
    {
        return $date->locale('pt')->timezone('Europe/Lisbon')->isoFormat('yyyy-MM-ddThh:mm');
    }

    public function filterEvents(Request $request)
    {

        switch ($request->time) {
            case 'this_week':
                $date_now = new DateTime();
                $end_date = new DateTime();
                date_add($end_date, date_interval_create_from_date_string('7 days'));

                $events = Event::where('start_date', '>=', $date_now)
                    ->where('start_date', '<=', $end_date)->orderBy('start_date', 'ASC')->get();
                break;

            case 'next_week':
                $date_now = new DateTime();
                $end_date = new DateTime();
                date_add($date_now, date_interval_create_from_date_string('7 days'));
                date_add($end_date, date_interval_create_from_date_string('14 days'));

                $events = Event::where('start_date', '>=', $date_now)
                    ->where('start_date', '<=', $end_date)->orderBy('start_date', 'ASC')->get();
                break;

            case 'this_month':

                $date_now = new DateTime();
                $end_date = new DateTime();
                date_add($end_date, date_interval_create_from_date_string('30 days'));

                $events = Event::where('start_date', '>=', $date_now)
                    ->where('start_date', '<=', $end_date)->orderBy('start_date', 'ASC')->get();


                break;

            case 'all':
                $events = Event::all();
                break;

            default:
                break;
        }

        $editor = false;
        if (Auth::check() && Auth::user()->isEditor()) {
            $editor = true;
        }


        return ['events' => $events, 'editor' => $editor];
    }
}
