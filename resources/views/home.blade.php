@extends('layouts.app')
@section('content')
    <main class="container-fluid">
      @if(session('updated'))
        <div class="alert alert-dark" role="alert">
          {{ session('updated') }}
        </div>
      @endif
        @isset($category)
            <h2 class="text-title mb-3">{{ $category->name }}</h2>
        @endif
        @isset($user)
            <h2 class="text-title mb-3">{{ __('Photos de ') . $user->name }}</h2>
        @endif
        <div class="card-columns">
            @foreach($images as $image)
                <div class="card">
                    <a href="{{ url('images/' . $image->name) }}" class="image-link"><img class="card-img-top" src="{{ url('thumbs/' . $image->name) }}" alt="image"></a>
                    @isset($image->description)
                        <div class="card-body">
                            <p class="card-text">{{ $image->description }}</p>
                        </div>
                    @endisset
                    <div class="card-footer text-muted">
                        <small><em>
                            <a href="{{ route('user', $image->user->id) }}" data-toggle="tooltip" title="{{ __('Voir les photos de ') . $image->user->name }}">{{ $image->user->name }}</a>
                            </em></small>
                        <small class="pull-right">
                            <em>
                                {{ $image->created_at->formatLocalized('%x') }}
                                @adminOrOwner($image->user_id)
                                <a class="category-edit" id="{{$image->category_id}}" href="#" data-toggle="tooltip" title="@lang('Changer de catégorie')"><i class="fa fa-edit"></i></a>
                                <a class="form-delete" href="{{ route('image.destroy', $image->id) }}" data-toggle="tooltip" title="@lang('Supprimer cette photo')"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('image.destroy', $image->id) }}" method="POST" class="hide">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                                @endadminOrOwner

                            </em>
                        </small>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $images->links() }}
        </div>
          <div class="modal fade" id="changeCategory" tabindex="-1" role="dialog" aria-labelledby="categoryLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="categoryLabel">@lang('Changement de la catégorie')</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                      <select class="form-control" name="category_id">
                        @foreach($categories as $cat)
                          <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">@lang('Envoyer')</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </main>
@endsection
@section('script')
    <script>
      $(function() {
        $('[data-toggle="tooltip"]').tooltip()
        $('.card-columns').magnificPopup({
          delegate: 'a.image-link',
          type: 'image',
          gallery: { enabled: true }
        });
        $('a.form-delete').click(function(e) {
          e.preventDefault();
          let href = $(this).attr('href')
          $("form[action='" + href + "'").submit()
        })
        $('.category-edit').click(function (e) {
          e.preventDefault()
          $('select').val($(this).attr('id'))
          $('form').attr('action', $(this).next().attr('href'))
          $('#changeCategory').modal('show')
        })
      })
    </script>
@endsection