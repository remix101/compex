<?php

use App\Models\Buyer;
use App\Models\Broker;
use App\Models\Seller;
use App\Models\Role;
use App\Models\SearchQuery;
use App\Models\SiteConfig;
use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\ListingMetum;
use App\Models\ListingMetaDatum;
use App\Models\ListingMetaCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;

class ListingsController extends BaseController {
    
    public function __construct()
    {
        parent::__construct();
        $this->search_pages = SiteConfig::getValueByName('search_pages');
    }

    /**
	 * Display a listing of the resource.
	 * GET /listings
	 *
	 * @return Response
	 */
    public function index()
    {
        return View::make(Auth::user()->role->name.'.listings.index');
    }
    
    private $search_pages;

    /**
	 * Display a listing of the resource.
	 * GET /listings/pending
	 *
	 * @return Response
	 */
    public function pending()
    {
        return View::make(Auth::user()->role->name.'.listings.pending');
    }

    /**
	 * Display a listing of the resource.
	 * GET /listings/approved
	 *
	 * @return Response
	 */
    public function approved()
    {
        return View::make(Auth::user()->role->name.'.listings.approved');
    }

    public function getSearch()
    {        
        $data = Input::all();
        
        $q = Input::get('q', '');

        //unset all empty control
        foreach($data as $key => $value)
        {
            if($value == "")
            {
                unset($data[$key]);
            }
        }
        $results = new Listing();
        if(isset($data['country']))
        {
            $results = $results->where('country', '=', $data['country']);
        }
        if(isset($data['category']))
        {
            $results = $results->where('category', '=', $data['category']);
        }
        $results = $results->search($q, 2)->paginate($this->search_pages);

        if(trim($q) != '')
        {
            $sq = new SearchQuery();
            if(Auth::check())
            {
                $sq->user_id = Auth::user()->id;
            }
            $sq->search_term = $q;
            $sq->results_count = $results->getTotal();
            $sq->save();
        }
        if (Request::ajax())
        {
            return Response::json(View::make('search.results')->withResults($results)->render());
        }
        return View::make('search.results')->withResults($results);
    }

    public function advancedSearch()
    {
        $q = Input::get('q');

        $data = Input::all();
        //unset all empty control
        foreach($data as $key => $value)
        {
            if($value == "")
            {
                unset($data[$key]);
            }
        }
        $results = new Listing;
        if(isset($data['ask_price']))
        {
            $results = $results->where('ask_price', '=', $data['ask_price']);
        }
        if(isset($data['category']))
        {
            $results = $results->where('category', '=', $data['category']);
        }
        if(isset($data['country']))
        {
            $results = $results->where('country', '=', $data['country']);
        }
        if(isset($data['prop_status']))
        {
            $results = $results->where('property_status', '=', $data['prop_status']);
        }
        if(isset($data['annual_sales_revenue']))
        {
            $results = $results->where('yearly_revenue', '=', $data['annual_sales_revenue']);
        }
        if(isset($data['annual_cash_flow']))
        {
            $results = $results->where('cash_flow', '=', $data['annual_cash_flow']);
        }
        if(isset($data['annual_operation_cost']))
        {
            $results = $results->where('operation_cost', '=', $data['annual_operation_cost']);
        }
        $results = $results->search($q, 2)->paginate($this->search_pages);

        if(trim($q) != '')
        {
            $sq = new SearchQuery();
            if(Auth::check())
            {
                $sq->user_id = Auth::user()->id;
            }
            $sq->search_term = $q;
            $sq->results_count = $results->getTotal();
            $sq->save();
        }
        if (Request::ajax())
        {
            return Response::json(View::make('search.advanced')->withResults($results)->render());
        }
        return View::make('search.advanced')->withResults($results);
    }

    public function categoryListings($category)
    {
        $results = $category->listings()->paginate($this->search_pages);

        if (Request::ajax())
        {
            return Response::json(View::make('search.category')->withResults($results)->render());
        }
        return View::make('search.category')
            ->withCategory($category)
            ->withResults($results);
    }

    public function countryListings($country)
    {
        $results = $country->listings()->paginate($this->search_pages);

        if (Request::ajax())
        {
            return Response::json(View::make('search.country')->withResults($results)->render());
        }
        return View::make('search.country')
            ->withCountry($country)
            ->withResults($results);
    }

    public function listings()
    {
        return Redirect::to(Auth::user()->role->name.'/listings');
    }

    /**
	 * Show the form for creating a new resource.
	 * GET /listings/create
	 *
	 * @return Response
	 */
    public function create()
    {
        $user = Auth::user();
        if($user->is(Config::get('constants.ROLE_SELLER')) || $user->is(Config::get('constants.ROLE_BROKER')))
        {
            return View::make(Auth::user()->role->name. '.list');
        }
        return View::make('errors.message')
            ->withMessage('You must have a broker/seller account to list a business for sale.')
            ->withButton(['title' => 'Create a Seller Account', 'href' => url('register/seller')]);
    }

    /**
	 * Store a newly created resource in storage.
	 * POST /listings
	 *
	 * @return Response
	 */
    public function store()
    {
        $data = Input::all();
        //unset all empty control
        foreach($data as $key => $value)
        {
            if($value == "")
            {
                unset($data[$key]);
            }
        }
        $listing = new Listing;        
        if($listing->validate($data))
        {
            $listing->fill($data);
            $listing->save();
            $user = Auth::user();
            if($user->seller != null)
            {
                $listing->seller()->associate($user->seller);
                $listing->save();
            }
            elseif($user->broker != null)
            {
                $listing->broker()->associate($user->broker);
                $listing->save();
            }
            $files = Input::file('photos');
            foreach($files as $file)
            {
                if ($file != null && $file->isValid())
                {
                    $lp = new ListingPhoto;
                    $lp->photo_url = 'listings/'.$listing->id.'/'.time().$file->getClientOriginalName();
                    $file->move(public_path('files/listings/'.$listing->id), $lp->photo_url);
                    $lp->listing()->associate($listing);
                    $lp->save();
                }
            }
            return View::make(Auth::user()->role->name. '.listings.add_photos')
                ->withListing($listing)
                ->withSuccess('<strong>Congratulations. Your listing has been created successfully and will be available once verified by admin.</strong>');
        }
        Input::flash();
        return View::make(Auth::user()->role->name.'.listings.create')->withErrors($listing->getValidator());
    }

    /**
	 * Display the specified resource.
	 * GET /listings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function show($listing)
    {
        if($listing->verified)
        {
            $listing->views++;
            $listing->save();
            return View::make('listings.show')->withListing($listing);
        }
        return View::make('errors.message')->withMessage('This listing is yet to be verified. Please check back later');
    }

    /**
	 * Show the form for editing the specified resource.
	 * GET /listings/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($listing)
    {
        return View::make(Auth::user()->role->name.'.listings.edit')
            ->withListing($listing);
    }

    /**
	 * Update the specified resource in storage.
	 * PUT /listings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($listing)
    {
        $data = Input::all();
        //unset all empty control
        foreach($data as $key => $value)
        {
            if($value == "")
            {
                unset($data[$key]);
            }
        }
        if($listing->validate($data, 'update'))
        {
            $listing->update($data);
            $listingCount = 0;
            //delete ignored photos
            $photosKept = isset($data['photos_kept']) ? $data['photos_kept'] : [];
            foreach($listing->photos as $photo)
            {
                if(!in_array($photo->id, $photosKept))
                {
                    $photo->delete();
                }
                else
                {
                    $listingCount++;
                }
            }
            $files = Input::file('photos');
            //upload new photos
            foreach($files as $file)
            {
                if ($file != null && $file->isValid())
                {
                    $lp = new ListingPhoto;
                    $lp->photo_url = 'listings/'.$listing->id.'/'.time().$file->getClientOriginalName();
                    $file->move(public_path('files/listings/'.$listing->id), $lp->photo_url);
                    $lp->listing()->associate($listing);
                    $lp->save();
                    $listingCount++;
                }
            }
            if($listingCount < 3)
            {
                $success = '<strong>Upload more photos to improve your listing.</strong>';
            }
            else
            {
                $a = false;//lol, just for conditional return
            }
            Alert::success('Your listing has been updated successfully', 'Congratulations');
            return View::make(Auth::user()->role->name.'.listings.edit')
                ->with(compact('listing', isset($success) ? 'success' : 'a'));
        }
        Input::flash();
        return View::make(Auth::user()->role->name.'.listings.edit')->withErrors($listing->getValidator());
    }


    /**
	 * Shows a listing preview
	 * GET /sellers/listings/preview/{id}
	 *
	 * @param  App\Models\Listing  $listing
	 * @return Response
	 */
    public function preview($listing)
    {
        //ensure preview is owner
        $user = Auth::user();
        if($user->seller != null && $user->seller->id == $listing->seller_id)
        {
            return View::make('seller.listings.preview')->withListing($listing);
        }
        elseif($user->broker != null && $user->broker->id == $listing->broker_id)
        {
            return View::make('broker.listings.preview')->withListing($listing);            
        }
        return View::make('errors.message')->withMessage('You can only preview a listing you created');
    }

    /**
	 * Update the specified resource in storage.
	 * POST /sellers/listings/{id}/photos
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function addPhotos($listing)
    {
        $files = Input::file('photos');
        foreach($files as $file)
        {
            if ($file != null && $file->isValid())
            {
                $lp = new ListingPhoto;
                $lp->photo_url = 'listings/'.$listing->id.'/'.time().$file->getClientOriginalName();
                $file->move(public_path('files/listings/'.$listing->id), $lp->photo_url);
                $lp->listing()->associate($listing);
                $lp->save();
            }
        }
        Alert::success('Your listing has been created successfully and will be available once verified by admin', 'Congratulations');
        return Redirect::to(Auth::user()->role->name.'/listings');
    }

    /**
	 * Remove the specified resource from storage.
	 * DELETE /listings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($listing)
    {
        $listing->delete();
        if(Request::ajax())
        {
            return Response::json('success', 200);
        }
        return Redirect::to(Auth::user()->role->name.'.listings')
            ->withSuccess('Listing deleted successfully.');
    }

}