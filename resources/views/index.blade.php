<x-news-layout>
    <div class="p-3 index">
    <a href="/news-refresh/{{$tag}}">Fetch</a>
    </div>
    <div class="p-3 index">
        Tag name:
        @foreach($tags as $tag)
        <a href="/news/{{urlencode($tag->tag)}}">{{$tag->tag}}</a>
        @endforeach
    </div>
    <div class="p-3 index">
        Sort By:
        <a href="/news/{{$tag}}/author">Author name</a>
        <a href="/news/{{$tag}}/title">Title</a>
        <a href="/news/{{$tag}}/pub_date/desc">Publish date (newer first)</a>
        <a href="/news/{{$tag}}/pub_date/asc">Publish date</a>
    </div>
    @foreach ($news as $new)
            <div class="p-3 index">
                <div class="flex items-center">
                    <img src="{{$new->img}}" alt="{{html_entity_decode($new->title)}}" class="news_img"/>
                    <div class="flex flex-col">
                        <div class="tags flex mb-1">
                            @foreach (explode(', ', $new->tags) as $tag)
                                <span class="tag inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold leading-5 text-white font-display mr-2 capitalize bg-brand-500" style="background-color: deepskyblue">
                                    {{$tag}}
                                </span>
                            @endforeach
                            <p class="font-mono text-xs font-normal text-gray-400">{{date('d.m.Y', strtotime($new->pub_date))}}</p>
                        </div>
                        <h5 class="font-display font-semibold tracking-tight text-black">
                            <span class="link link-underline link-underline-black">
                                <a href="{{$new->link}}">{{html_entity_decode($new->title)}}</a>
                            </span>
                        </h5>
                        <p class="font-display mt-2 text-sm text-gray-400">
                            {{$new->excerpt}}
                        </p>
                        <h5>Author: {{$new->author}}</h5>
                        @auth<a href="/news-edit/{{$new->id}}">Edit</a>@endauth
                    </div>
                </div>

            </div>
        @endforeach
    <div class="p-3 index">
        {{$news->links()}}
    </div>
</x-news-layout>
