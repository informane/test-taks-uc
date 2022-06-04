<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tags;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

use voku\helper\HtmlDomParser;

class NewsController extends Controller
{

    protected $users;
    protected $news;
    protected $tags;
    /**
     * NewsController constructor.
     *
     * @param User $users
     * @param News $news
     */
    public function __construct(User $users, News $news, Tags $tags)
    {
        $this->users = $users;
        $this->news = $news;
        $this->tags = $tags;
    }

    /**
     * fetch all articles with news tag from https://laravel-news.com/blog.
     *
     * @param string $tag
     * @param int $months_number
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refresh($tag = 'News',$months_number =4)
    {

        if($months_number <= 0){
            return redirect('/news');
        }

        News::fetchNews($tag,$months_number);

        return redirect('/news/'.$tag);
    }

    /**
     * Display a listing of News.
     *
     * @param string $tag
     * @param string $orderBy
     * @param string $dir
     * @return \Illuminate\Http\Response
     */
    public function index($tag = 'News', $orderBy = 'author', $dir = 'asc')
    {
        $tags = $this->tags = Tags::all();
        $this->news = News::orderBy($orderBy, $dir)->where(['tag'=>urldecode($tag)])->paginate('7');
        return response()->view('index',['news' => $this->news, 'tag' => $tag, 'tags' =>$tags]);
    }


    /**
     * Show the form for editing the News.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $this->authorize('update', News::class);

        $tags = $this->tags = Tags::all();

        return response()->view('edit', ['new' => $news, 'tags' => $tags]);
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
