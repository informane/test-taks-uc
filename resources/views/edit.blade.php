<x-news-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
<div class="p-6">
        <h1 class='text-xl'>Edit article</h1>
        <form method="POST" action="/news-update/{{$new->id}}" enctype="multipart/form-data">
            @csrf
            <div class="items-center">
                <x-label for="img" value="Image" />
                <x-input value="{{$new->img}}" type="text" id="img" name="img" class="block mt-1 w-full @error('img') is-invalid @enderror"/>
                <img src="{{$new->img}}" alt="{{$new->title}}" class="news_img"/>
                @error('img')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="items-center">
                <x-label for="link" value="Article Link" />
                <x-input value="{{$new->link}}" type="text" id="link" name="link" class="block mt-1 w-full @error('link') is-invalid @enderror"/>
                @error('link')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="items-center">
                <x-label for="author" value="Author name" />
                <x-input  value="{{$new->author}}" type="text" id="author" name="author" class="block mt-1 w-full @error('author') is-invalid @enderror"/>
                @error('author')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="items-center">
                <x-label for="tags" value="Tags separated by comma" />
                <x-input value="{{$new->tags}}" type="text" id="tags" name="tags" class="block mt-1 w-full @error('tags') is-invalid @enderror"/>
                @error('tags')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="items-center">
                <x-label for="title" value="Title" />
                <x-input value="{{$new->title}}" type="text" id="title" name="title" class="block mt-1 w-full @error('title') is-invalid @enderror"/>
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="items-center pub_date">
                <x-label for="pub_date" value="Publish date" />
                <x-input data-date-format="YYYY-MM-DD" value="{{$new->pub_date}}" type="text" id="pub_date" name="pub_date" class="block mt-1 w-full @error('pub_date') is-invalid @enderror"/>
                @error('pub_date')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="items-center">
                <x-label for="excerpt" value="Excerpt" />
                <x-input value="{{$new->excerpt}}" type="text" id="excerpt" name="excerpt" class="block mt-1 w-full @error('excerpt') is-invalid @enderror"/>
                @error('excerpt')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="items-center">
                <x-button class="ml-3">
                    Save
                </x-button>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#pub_date').datetimepicker();
        });
    </script>
</x-news-layout>
