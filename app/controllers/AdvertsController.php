<?php

use App\Models\Buyer;
use App\Models\Broker;
use App\Models\Seller;
use App\Models\Role;
use App\Models\Advert;
use App\Models\AdvertPhoto;
use App\Models\AdvertMetum;
use App\Models\AdvertMetaDatum;
use App\Models\AdvertMetaCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;

class AdvertsController extends BaseController {

    /**
	 * Display a advert of the resource.
	 * GET /adverts
	 *
	 * @return Response
	 */
    public function index()
    {
        return View::make(Auth::user()->role->name.'.adverts.index');
    }

    /**
	 * Display a advert of the resource.
	 * GET /adverts/pending
	 *
	 * @return Response
	 */
    public function pending()
    {
        return View::make(Auth::user()->role->name.'.adverts.pending');
    }

    public function getSearch()
    {
        $q = Input::get('q');

        $results = Advert::search($q, 2)->paginate(10);

        if (Request::ajax())
        {
            return Response::json(View::make('adverts.search')->withResults($results)->render());
        }
        return View::make('adverts.search')->withResults($results);
    }

    public function categoryAdverts($category)
    {
        $results = $category->adverts()->paginate(20);

        if (Request::ajax())
        {
            return Response::json(View::make('adverts.category')->withResults($results)->render());
        }
        return View::make('adverts.category')
            ->withCategory($category)
            ->withResults($results);
    }

    /**
	 * Show the form for creating a new resource.
	 * GET /adverts/create
	 *
	 * @return Response
	 */
    public function create()
    {
        $user = Auth::user();
        if($user->isBuyer() || $user->isBroker())
        {
            return View::make(Auth::user()->role->name. '.adverts.create');
        }
        return View::make('errors.message')
            ->withMessage('You must have a buyeror broker account to create a business wanted advert.')
            ->withButton(['title' => 'Create a Buyer Account', 'href' => url('register')]);
    }

    /**
	 * Store a newly created resource in storage.
	 * POST /adverts
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
        $advert = new Advert;        
        if($advert->validate($data))
        {
            $advert->fill($data);
            $user = Auth::user();
            if($user->isBuyer())
            {
                $advert->buyer_id = $user->buyer->id;
            }
            elseif($user->isBroker())
            {
                $advert->broker_id = $user->broker->id;
            }
            else{
                Auth::logout();
                return Redirect::to('/');
            }
            $advert->save();
            Alert::success('Your advert has been created successfully. Keep an eye on your inbox for sellers contacting you', 'Congratulations');

            return Redirect::to(Auth::user()->role->name. '/adverts')
                ->withSuccess('<strong>Congratulations. Your advert has been created successfully. Keep an eye on your inbox for messages from sellers/brokers.</strong>');
        }
        Input::flash();
        return View::make(Auth::user()->role->name.'.adverts.create')->withErrors($advert->getValidator());
    }

    /**
	 * Display the specified resource.
	 * GET /adverts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function show($advert)
    {
        if($advert->verified)
        {
            $advert->views++;
            $advert->save();
            return View::make('adverts.show')->withAdvert($advert);
        }
        return View::make('errors.message')->withMessage('This advert is yet to be verified. Please check back later');
    }

    /**
	 * Show the form for editing the specified resource.
	 * GET /adverts/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($advert)
    {
        return View::make(Auth::user()->role->name.'.adverts.edit')
            ->withAdvert($advert);
    }

    /**
	 * Update the specified resource in storage.
	 * PUT /adverts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($advert)
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
        if($advert->validate($data, 'update'))
        {
            $advert->update($data);
            $success = 'Your advert has been updated successfully.';
            Alert::success($success, 'Congratulations');
            return View::make(Auth::user()->role->name.'.adverts.edit')
                ->with(compact('advert', isset($success) ? 'success' : 'a'));
        }
        Input::flash();
        return View::make(Auth::user()->role->name.'.adverts.edit')->withErrors($advert->getValidator());
    }

    /**
	 * Remove the specified resource from storage.
	 * DELETE /adverts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function delete($advert)
    {
        $advert->delete();
        if(Request::ajax())
        {
            return Response::json('success', 200);
        }
        return Redirect::to(Auth::user()->role->name.'.adverts')
            ->withSuccess('Advert deleted successfully.');
    }

}