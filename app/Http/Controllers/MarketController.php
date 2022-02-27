<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Dcp;
use App\Models\Location;


class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 8;
        if (Auth::check() && Auth::user()->isEditor()) {
            $pagination = 7;
        }

        $vendors = Vendor::paginate($pagination);
        return view('pages.market', ['vendors' => $vendors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->validateRequest($request) || !$request->hasFile('image_path')) {
            return redirect('/vendor_crud?error');
        }
        $vendor = new Vendor();
        $vendor->name = $request->input('name');
        $vendor->job = $request->input('job');
        $vendor->location_id = 1; //TODO Mudar
        $vendor->description = $request->input('description');
        $vendor->image_path = $this->uploadImg($request, $vendor);
        //$eventPost->editor = Auth::user()->user_id;
        $vendor->save();
        return redirect('/market/' . $vendor->vendor_id);
    }

    public function validateRequest(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|min:1',
                'job' => 'required|string|min:1',
                'description' => 'required|string|min:1',
            ]
        );
        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    public function form()
    {
        $this->authorize('view', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        return view('pages.vendor_crud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate

        //Antes de chamar esta função, precisa de se chamar o
        //Sempre que se quer fazer post ou criar alguma cena «e preciso!
        //@csrf


        // //Vai buscar todos os campos do request e poe num array
        // $vendor = Vendor::create($request->all());
        // //Tem que se chamar este para que ele guarde na base de dados
        // $vendor->save();

        // $item = Item::create([
        //     'id_vendor' => $vendor->vendor_id
        //     //...
        // ]);

        // //tb se pode fazer com a função input

        // return redirect{'/items/' . $item->id};
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::join('location', 'vendor.location_id', '=', 'location.location_id')
        ->join('district_county_parish', 'location.dcp_id', '=', 'district_county_parish.dcp_id')->get()->find($id);
        //$products = $vendor->product;
        $products = Product::all()->random(8);



        return view('pages.vendor', ['vendor' => $vendor, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        $vendor = Vendor::join('location', 'vendor.location_id', '=', 'location.location_id')->join('district_county_parish', 'location.dcp_id', '=', 'district_county_parish.dcp_id')->get()->find($id);

        $districts = DB::table('district_county_parish')
            ->select('district')->distinct('district')
            ->get();

        $counties = DB::table('district_county_parish')
        ->select('county')->where('district', "=", $vendor->district)->distinct('county')
        ->get();

        $parishes = DB::table('district_county_parish')
        ->select('parish', 'dcp_id')->where('district', "=", $vendor->district)
        ->where('county', "=", $vendor->county)->distinct('parish')
        ->get();

        return view('pages.vendor_crud', ['vendor' => $vendor, 'districts' => $districts, 'counties' => $counties, 'parishes' => $parishes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (!$this->validateRequest($request)) {
            return redirect('/market/' . $id . '/edit?errorEdit');
        }
        $vendor = Vendor::find($id);
        $vendor->name = $request->input('name');
        $vendor->job = $request->input('job');

        $location = new Location();
        $location->address = $request->input('address');
        $location->zip_code = $request->input('zip_code');
        $location->dcp_id = $request->input('parish');
        $location->save();
        $vendor->location_id = $location->location_id;

        
        $vendor->description = $request->input('description');
        $vendor->image_path = $this->uploadImg($request, $vendor);
        $vendor->save();
        return redirect('/market/' . $vendor->vendor_id);
    }

    public function uploadImg(Request $request, $vendor)
    {
        if ($request->hasFile('image_path')) {

            $filename = $request->image_path->getClientOriginalName();
            $request->image_path->storeAs('images', $filename, 'public');
            return $filename;
        } else return $vendor->image_path;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        $vendor = Vendor::find($id);
        $vendor->delete();
        return $vendor->vendor_id;
    }
}
