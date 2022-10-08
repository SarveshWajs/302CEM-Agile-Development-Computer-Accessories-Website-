@extends('layouts.app')
<style>
img {
  border: 5px solid #555;
}
</style>
@section('content')
  <section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">
                    Food Blog Details
                </h1>
            </div>
            <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                   <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Food Blog Details
                </h1>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<br/>
<section class="blog spad">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 posts-list">
          <div class="blog__item">
            <h3 align="center">{{ $blog->title }}</h3>
            <br/>
              <div align="center"class="blog__item__pic">
                  <img src="{{ url($blog->image) }}" alt=""style="width:100%;">
              </div>
              <div class="blog__item__text">

                  <div class="f">
                      <i class="fa fa-calendar fa-1.5x" aria-hidden="true"></i>&nbsp;&nbsp; {{ date('M d, Y', strtotime($blog->blog_date)) }}
                  </div>
                      

                     <div class="f">
                      <i class="fa fa-tag" aria-hidden="true"></i> &nbsp;&nbsp;{{ $blog->blog_tags }}
                      </div>
                      
              
                  <p><b>Food Blog Details</b></p>
                       <div style="word-wrap: break-word;" >
                       {!! htmlspecialchars_decode($blog->description) !!}
                      </div>
                  
              </div>
          </div>
      </div>
    </div>
    @foreach($comments as $comment)
    <div class="container-box form-group">
        <blockquote class="blockquote">
          <p class="mb-0">{{ $comment->comment }}</p>
          <footer class="blockquote-footer">
            <small>
              @if(!empty($comment->u_name))
                {{ $comment->u_name }}
              @elseif(!empty($comment->a_name))
                {{ $comment->a_name }}
              @else
                {{ $comment->m_name }}
              @endif
            </small>
          </footer>
        </blockquote>
    </div>
    @endforeach

    <hr>

    <form method="POST" action="{{ route('blog_comment', $blog->id) }}">
    @csrf
      <label>Write down your comment.</label> 
      <textarea class="form-control col-md-6" name="comment" placeholder="Write a comment"required></textarea>

      <div class="e">
            <button  class="btn btn-primary">Sumbit</button>
      </div>
      

    </form>
  </section>
@endsection