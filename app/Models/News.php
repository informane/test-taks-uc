<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use voku\helper\HtmlDomParser;

class News extends Model
{
    protected $fillable = ['img','title','author','excerpt','pub_date','link', 'tag'];
    use HasFactory;


    //fetch all articles with news tag from https://laravel-news.com/blog.
    public static function fetchNews($tag,$months_number)
    {
        $is_newer = true;
        $page = 1;


        while($is_newer) {

            //first page has not all articles so dont use page var in query string for first page
            if($page > 1)
                $html = file_get_contents('https://laravel-news.com/blog?page='.$page);
            else
                $html = file_get_contents('https://laravel-news.com/blog');

            //simple html dom parser
            $doc = HtmlDomParser::str_get_html($html);

            //get all articles
            $articles = $doc->findMulti('main > div > ul > li');

            $articleNum = 1;
            foreach($articles as $article) {


                //if current article is newer than $months_number months do fetch otherwise stop
                if ($is_newer) {
                    $articleA = $article->findOne('a');

                    $articleAhref = 'https://laravel-news.com' . $articleA->getAttribute('href');


                    $date = \DateTime::createFromFormat('F jS, Y', trim($articleA->findOne('div > div > p')->text()));

                    $articleDate = $date->format('Y-m-d');


                    //$articleNum == 1 stands for top article so its fetched not regarding of date
                    if (strtotime($articleDate) > strtotime("-$months_number months") or ($articleNum == 1 && $page == 1)) {

                        $articleTag = trim($articleA->findOne('div > div > span')->text());


                        //if main tag is not $tag go further
                        if ($articleTag != urldecode($tag)) {
                            $articleNum++;
                            continue;
                        }

                        $articleImg = $articleA->findOne('img')->getAttribute('data-cfsrc');


                        //get title: h3 for main article, h4 for others
                        if($articleNum == 1) $titleTag = 'h3'; else $titleTag = 'h4';
                        $articleTitle = trim($articleA->findOne($titleTag)->text());


                        $articleExcerpt = trim($article->findOne('a > div > p')->text());


                        //go to articles page to get all tags and other
                        $articleDoc = HtmlDomParser::str_get_html(file_get_contents($articleAhref));

                        $articleSummary = $articleDoc->findMulti('article > div > div:nth-child(2) > div:nth-child(2)')[0];

                        $articleTagsHtml = $articleSummary->findMulti('span');

                        $articleTags = [];
                        foreach ($articleTagsHtml as $articleTag) {
                            $articleTags[] = trim($articleTag->text());
                        }


                        $articleAuthor = $articleDoc->findOne('article > div > div:nth-child(2) > div:nth-child(2) > div:nth-child(3) > div>div > p > a')->text();



                        //create or update News
                        $new = News::where('title', $articleTitle)->first();
                        if($new == null) {
                            $new = new News();
                        }
                        $new->tag = urldecode($tag);
                        $new->pub_date = $articleDate;
                        $new->link = $articleAhref;
                        $new->img = $articleImg;
                        $new->title = $articleTitle;
                        $new->excerpt = $articleExcerpt;
                        $new->author = $articleAuthor;
                        $new->tags = implode(', ', $articleTags);

                        $new->save();



                    } else
                        $is_newer = false;



                }
            }
            $page++;
        }
    }
}
