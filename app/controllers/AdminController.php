<?php

use App\Models\Buyer;
use App\Models\Broker;
use App\Models\Seller;
use App\Models\Article;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Role;
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

class AdminController extends BaseController {

    /**
     * Gets the admin dashboard
     * @return Response
     */
    public function dashboard()
    {
        return View::make('admin.dashboard');
    }

    /**
     * Gets a page listing all the user on the system
     * @return Response
     */
    public function getUsers()
    {        
        return View::make('admin.users.index');
    }

    /**
     * Gets a page listing all the sellers on the system
     * @return Response
     */
    public function sellers()
    {        
        return View::make('admin.users.sellers');
    }

    /**
     * Gets a page listing all the brokers on the system
     * @return Response
     */
    public function brokers()
    {        
        return View::make('admin.users.brokers');
    }

    /**
     * Gets a page listing all the buyers on the system
     * @return Response
     */
    public function buyers()
    {        
        return View::make('admin.users.buyers');
    }

    /**
     * Gets a page listing all the listings on the system
     * @return Response
     */
    public function listings()
    {
        return View::make('admin.listings.index');
    }

    /**
     * Gets a page listing all the listings by sellers on the system
     * @return Response
     */
    public function sellerListings()
    {
        return View::make('admin.listings.seller');
    }

    /**
     * Gets a page listing all the listings by brokers on the system
     * @return Response
     */
    public function brokerListings()
    {
        return View::make('admin.listings.broker');
    }
    
    /**
     * Gets a page listing all the adverts (businesses wanted) on the system
     * @return Response
     */
    public function adverts()
    {
        return View::make('admin.listings.adverts');
    }

    /**
     * Gets a page listing all the articles on the system
     * @return Response
     */
    public function articles()
    {
        return View::make('admin.articles.index');
    }

    /**
     * Gets the page for creating a new article
     * @return Response
     */
    public function createArticle()
    {
        return View::make('admin.articles.create');
    }

    /**
     * Stores an article
     * @return Response
     */
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
    
    /**
     * Gets the page for editing/updating an article
     * @param  Article $article Article to edit
     * @return Response
     */
    public function editArticle($article)
    {
        return View::make('admin.articles.edit')->withArticle($article);
    }

    /**
     * Updates an article
     * @param  Article $article Article to update
     * @return Response
     */
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

    /**
     * DEletes an article
     * @param  Article $article The article to delete
     * @return Response
     */
    public function deleteArticle($article)
    {
        $article->delete();
        if(Request::ajax())
        {
            return Response::make(null, 204);
        }
        return View::make('admin.articles.index')->withDelete(true);
    }
    
    /**
     * Deletes a listing from the system
     * @param  Listing $listing The listing to delete
     * @return Response
     */
    public function destroy($listing)
    {
        $listing->delete();
        if(Request::ajax())
        {
            return Response::make(null, 204);
        }
        return View::make('admin.listings')->withDelete(true);
    }

    /**
     * Approves a listing
     * @param  Listing $listing
     * @return Response
     */
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

    /**
     * Unapproves a listing
     * @param  Listing $listing The listing to approve/unapprove
     * @return Response
     */
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

    /**
     * Deletes a user from the system
     * @param  User $user
     * @return Response
     */
    public function deleteUser($user)
    {
        $user->delete();
        if(Request::ajax())
        {
            return Response::make(null, 204);
        }
        return View::make('admin.users.index')->withDelete(true);
    }

    /**
     * Bans a user from the system
     * @param  User $user The user to ban
     * @return Response
     */
    public function banUser($user)
    {
        $user->status = Config::get('constants.USER_STATUS_BANNED');
        $user->save();
        if(Request::ajax())
        {
            return Response::json($user);
        }
        return View::make('admin.users.index')
            ->withBan(true);
    }

    /**
     * Unbans a user from the system
     * @param  User $user The user to unban
     * @return Response
     */
    public function unbanUser($user)
    {
        $user->status = Config::get('constants.USER_STATUS_VERIFIED');
        $user->save();
        if(Request::ajax())
        {
            return Response::json($user);
        }
        return View::make('admin.users.index')
            ->withUnban(true);
    }

    /**
     * Deletes an advert from the system
     * @param  Advert $advert The advert to delete
     * @return Response
     */
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
	 * Update/Store admin menu settings
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
    
    /**
     * Configure the site settings on the page
     * @return Response
     */
    public function updateSearch()
    {
        SiteConfig::updateOrCreate(['name' => 'search_pages'], [
            'name' => 'search_pages',
            'value' => Input::get('search_pages'),
        ]);
        if(Request::ajax())
        {
            return Response::json('search page updated');
        }
        return View::make('admin.settings');
    }

}