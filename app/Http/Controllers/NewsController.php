<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

use voku\helper\HtmlDomParser;

class NewsController extends Controller
{

    protected $users;
    protected $news;
    /**
     * NewsController constructor.
     *
     * @param User $users
     * @param News $news
     */
    public function __construct(User $users, News $news)
    {
        $this->users = $users;
        $this->news = $news;
    }

    /**
     * fetch all articles with news tag from https://laravel-news.com/blog.
     *
     * @param $months_number
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refresh($months_number =4)
    {

        if($months_number <= 0){
            return redirect('/news');
        }

        News::fetchNews($months_number);

        return redirect('/news');
    }

    /**
     * Display a listing of News.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($orderBy = 'author', $dir = 'asc')
    {
        $this->news = News::orderBy($orderBy, $dir)->paginate('7');
        return response()->view('index',['news' => $this->news]);
    }


    /**
     * Show the form for editing the News.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $this->authorize('update', News::class);

        return response()->view('edit', ['new' => $news]);
    }

    /**
     * Update News in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->authorize('update', News::class);


        $valid = $request->validate([
           'pub_date' => 'required|date',
           'link' => 'required|max:255',
           'img' => 'required|max:255',
           'title' => 'required|unique:news,id|max:255',
           'excerpt' => 'required',
           'author' => 'required',
           'tags' => 'required',
        ]);

        if($valid){
            $news = News::find($id);
            $news->fill($request->except(['_token']));
            $news->save();
            return redirect('/news');
        }

    }

}
