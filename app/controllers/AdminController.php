<?php

use App\Models\Buyer;
use App\Models\Broker;
use App\Models\Seller;
use App\Models\Article;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Role;
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

class AdminController extends BaseController {

    public function dashboard()
    {
        return View::make('admin.dashboard');
    }

    public function getUsers()
    {        
        return View::make('admin.users.index');
    }

    public function sellers()
    {        
        return View::make('admin.users.sellers');
    }

    public function brokers()
    {        
        return View::make('admin.users.brokers');
    }

    public function buyers()
    {        
        return View::make('admin.users.buyers');
    }

    public function listings()
    {
        return View::make('admin.listings.index');
    }

    public function sellerListings()
    {
        return View::make('admin.listings.seller');
    }

    public function brokerListings()
    {
        return View::make('admin.listings.broker');
    }

    public function adverts()
    {
        return View::make('admin.listings.adverts');
    }

    public function articles()
    {
        return View::make('admin.articles.index');
    }

    public function createArticle()
    {
        return View::make('admin.articles.create');
    }

    public function storeArticle()
    {
        $data = Input::all();
        $article = new Article;        
        if($article->validate($data))
        {
            $file = Input::file('featured');
            if ($file != null && $file->isValid())
            {                
                $data['featured_img'] = 'articles/'.$article->id.'/'.time().$file->getClientOriginalName();
                $file->move(public_path('files/articles/'.$article->id), $data['featured_img']);
            }
            $user = Auth::user();
            $article->fill($data);
            $article->user_id = $user->id;
            $article->save();
            Alert::success('Article created '. ($article->published ? 'and published' : '' ) . ' successfully. You may go to menus to link this article to a menu', 'Success');
            return Redirect::to('admin/articles')
                ->withSuccess('<strong>Article created successfully.</strong>');
        }
        Input::flash();
        return View::make('admin.articles.create')->withErrors($article->getValidator());
    }

    public function editArticle($article)
    {
        return View::make('admin.articles.edit')->withArticle($article);
    }

    public function updateArticle($article)
    {
        $data = Input::all();
        if($article->validate($data))
        {
            $article->update($data);
            return View::make('admin.articles.edit')
                ->withArticle($article)
                ->withSuccess('<strong>Article updated successfully.</strong>');
        }
        Input::flash();
        return View::make('admin.articles.edit')
            ->withArticle($article)
            ->withErrors($article->getValidator());
    }

    public function deleteArticle($article)
    {
        $article->delete();
        if(Request::ajax())
        {
            return Response::make(null, 204);
        }
        return View::make('admin.articles.index')->withDelete(true);
    }

    public function destroy($listing)
    {
        $listing->delete();
        if(Request::ajax())
        {
            return Response::make(null, 204);
        }
        return View::make('admin.listings')->withDelete(true);
    }

    public function approve($listing)
    {
        $listing->verified = 1;
        $listing->save();
        if(Request::ajax())
        {
            return Response::json($listing);
        }
        return View::make('admin.listings')
            ->withApprove(true);
    }

    public function unapprove($listing)
    {
        $listing->verified = 0;
        $listing->save();
        if(Request::ajax())
        {
            return Response::json($listing);
        }
        return View::make('admin.listings')
            ->withUnapprove(true);
    }

    /**
     * Create new user
     * @return Response
     */
    public function createUser()
    {
        return View::make('admin.users.create');
    }

    /**
     * Store user account
     * @return Response
     */
    public function storeUser()
    {
        $data = Input::all();
        $u = new User;
        $a = false;
        $role_id = Input::get('role_id');
        if($role_id == Config::get('constants.ROLE_BUYER'))
        {
            $a = new Buyer;
            $u->status = 2;
            $data['skip_verification'] = true;
        }
        elseif($role_id == Config::get('constants.ROLE_SELLER'))
        {
            $a = new Seller;
        }
        elseif($role_id == Config::get('constants.ROLE_BROKER'))
        {
            $a = new Broker;
        }

        $data['password_confirmation'] = $data['password'];
        if($u->validate($data))
        {
            if($a->validate($data))
            {
                $data['password'] = Hash::make($data['password']);            
                $u->fill($data);
                $u->save();
                $a->fill($data);
                $a->user_id = $u->id;
                $a->save();
                return Redirect::to('admin/accounts')
                    ->withCreate(true)
                    ->withUsr($u);
            }
            return View::make('admin.users.create')
                ->withErrors($a->getValidator());
        }
        return View::make('admin.users.create')
            ->withErrors($u->getValidator());
    }

    public function deleteUser($user)
    {
        $user->delete();
        if(Request::ajax())
        {
            return Response::make(null, 204);
        }
        return View::make('admin.users.index')->withDelete(true);
    }

    public function banUser($user)
    {
        $user->status = 2;
        $user->save();
        if(Request::ajax())
        {
            return Response::json($user);
        }
        return View::make('admin.users.index')
            ->withBan(true);
    }

    public function unbanUser($user)
    {
        $user->status = 1;
        $user->save();
        if(Request::ajax())
        {
            return Response::json($user);
        }
        return View::make('admin.users.index')
            ->withUnban(true);
    }

    public function deleteAdvert($advert)
    {
        $advert->delete();
        if(Request::ajax())
        {
            return Response::json('success', 200);
        }
        return Redirect::to('admin/adverts')
            ->withSuccess('Advert deleted successfully.');
    }

    /**
	 * View admin settings
	 * GET /admin/settings
	 *
	 * @return Response
	 */
    public function settings()
    {
        return View::make('admin.settings');
    }

    /**
	 * Store admin settings
	 * POST /admin/settings
	 *
	 * @return Response
	 */
    public function storeSettings()
    {
        $data = Input::all();
        Log::info($data);
        $allMenus = Menu::lists('name', 'id');
        $allItems = MenuItem::lists('title', 'id');
        //existing menus
        foreach($data['menus'] as $i => $menu)
        {
            $m = Menu::updateOrCreate(['id' => $i], array(
                'name' => $menu,
                'link' => $data['mlinks'][$i],
                'sort_id' => $data['msorts'][$i],
            ));
            if(isset($data['imenus'][$i]))
            {
                foreach($data['imenus'][$i] as $k => $im)
                {
                    $sm = MenuItem::updateOrCreate(['id' => $k], array(
                        'title' => $im,
                        'link' => $data['ilinks'][$i][$k],
                        'sort_id' => $data['isorts'][$i][$k],
                    ));
                    unset($allItems[$k]);
                }
            }
            if(isset($data['submenus'][$i]))
            {
                foreach($data['submenus'][$i] as $k=> $sb)
                {
                    MenuItem::create(array(
                        'menu_id' => $i,
                        'title' => $sb,
                        'link' => $data['sublinks'][$i][$k],
                        'sort_id' => $data['subsorts'][$i][$k],
                    ));
                }
            }
            unset($allMenus[$i]);
        }
        //new menus
        if(isset($data['newmenus']))
        {
            foreach($data['newmenus'] as $i => $nmenu)
            {
                $m = Menu::create(array(
                    'name' => $nmenu,
                    'link' => $data['newlinks'][$i],
                    'sort_id' => $data['newsorts'][$i],
                ));
                if(isset($data['submenus'][$i]))
                {
                    foreach($data['submenus'][$i] as $k => $im)
                    {
                        $sm = MenuItem::create(array(
                            'menu_id' => $m->id,
                            'title' => $im,
                            'link' => $data['sublinks'][$i][$k],
                            'sort_id' => $data['subsorts'][$i][$k],
                        ));
                    }
                    unset($data['submenus'][$i]);
                    unset($allItems[$i]);
                }
            }
            //new submenus of exising menus
            foreach($data['submenus'] as $k => $im)
            {
                foreach($data['submenus'][$k] as $i=> $sb)
                {
                    MenuItem::create(array(
                        'menu_id' => $k,
                        'title' => $sb,
                        'link' => $data['sublinks'][$k][$i],
                        'sort_id' => $data['subsorts'][$k][$i],
                    ));
                }
            }
        }
        foreach($allItems as $i => $title)
        {
            MenuItem::where('id', '=', $i)->delete();
        }
        foreach($allMenus as $m => $name)
        {
            Menu::where('id', '=', $m)->delete();
        }
        if(Request::ajax())
        {
            return Response::json('success');
        }
        return View::make('admin.settings');
    }

}