<?php

use App\Models\Article;
use App\Models\Role;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class ArticlesController extends BaseController {

    /**
	 * Display a listing of the resource.
	 * GET /articles
	 *
	 * @return Response
	 */
    public function index()
    {
        //
    }


    public function getSearch()
    {
        $q = Input::get('q');

        $results = Article::search($q, 2)->paginate(10);

        if (Request::ajax())
        {
            return Response::json(View::make('articles.search')->withResults($results)->render());
        }
        return View::make('articles.search')->withResults($results);
    }

    public function category($category)
    {
        $results = Article::where('category_id', '=', $category->id)->paginate(18);

        if (Request::ajax())
        {
            return Response::json(View::make('articles.category')->withResults($results)->render());
        }
        return View::make('articles.category')
            ->withCategory($category)
            ->withResults($results);
    }

    public function buyers()
    {
        $category = Role::find(Config::get('constants.ROLE_BUYER'));
        $results = Article::where('category_id', '=', $category->id)->paginate(18);

        if (Request::ajax())
        {
            return Response::json(View::make('articles.category')->withResults($results)->render());
        }
        return View::make('articles.category')
            ->withCategory($category)
            ->withArticles($results);
    }

    public function sellers()
    {
        $category = Role::find(Config::get('constants.ROLE_SELLER'));
        $results = Article::where('category_id', '=', $category->id)->paginate(18);

        if (Request::ajax())
        {
            return Response::json(View::make('articles.category')->withResults($results)->render());
        }
        return View::make('articles.category')
            ->withCategory($category)
            ->withArticles($results);
    }

    public function brokers()
    {
        $category = Role::find(Config::get('constants.ROLE_BROKER'));
        $results = Article::where('category_id', '=', $category->id)->paginate(18);

        if (Request::ajax())
        {
            return Response::json(View::make('articles.category')->withResults($results)->render());
        }
        return View::make('articles.category')
            ->withCategory($category)
            ->withArticles($results);
    }

    /**
	 * Show the form for creating a new resource.
	 * GET /articles/create
	 *
	 * @return Response
	 */
    public function create()
    {
        //
    }

    /**
	 * Store a newly created resource in storage.
	 * POST /articles
	 *
	 * @return Response
	 */
    public function store()
    {
        //
    }

    /**
	 * Display the specified resource.
	 * GET /articles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function show($article)
    {
        if($article->published)
        {
            $article->views += 1;
            $article->save();
            return View::make('articles.show')->withArticle($article);
        }
        else
        {
            return View::make('errors.message')->withMessage('This article is marked as private or yet to be published. Please check back later');
        }
    }

    /**
	 * Show the form for editing the specified resource.
	 * GET /articles/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id)
    {
        //
    }

    /**
	 * Update the specified resource in storage.
	 * PUT /articles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($id)
    {
        //
    }

    /**
	 * Remove the specified resource from storage.
	 * DELETE /articles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id)
    {
        //
    }

}